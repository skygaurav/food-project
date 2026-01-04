<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\AdminSetting;
use Exception;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Service for sending emails with dynamic SMTP configuration.
 *
 * Loads SMTP settings from database and configures Laravel's mail
 * system dynamically before sending emails.
 *
 * @package App\Services
 */
class MailService
{
    /**
     * SMTP setting keys.
     */
    private const SETTING_SMTP_HOST = 'smtp_host';
    private const SETTING_SMTP_PORT = 'smtp_port';
    private const SETTING_SMTP_USERNAME = 'smtp_username';
    private const SETTING_SMTP_PASSWORD = 'smtp_password';
    private const SETTING_SMTP_ENCRYPTION = 'smtp_encryption';
    private const SETTING_MAIL_FROM_ADDRESS = 'mail_from_address';
    private const SETTING_MAIL_FROM_NAME = 'mail_from_name';
    private const SETTING_ADMIN_NOTIFICATION_EMAIL = 'admin_notification_email';

    /**
     * Default encryption type.
     */
    private const DEFAULT_ENCRYPTION = 'tls';

    /**
     * Configure mail settings from database before sending.
     *
     * @return bool True if configuration was successful, false otherwise
     */
    public static function configureDynamicMail(): bool
    {
        $settings = self::getSmtpSettings();

        if (! self::hasRequiredSettings($settings)) {
            return false;
        }

        self::applyMailConfiguration($settings);

        return true;
    }

    /**
     * Send a mailable using dynamic SMTP settings.
     *
     * Falls back to .env settings if database settings are not configured.
     *
     * @param  \Illuminate\Mail\Mailable  $mailable
     * @param  string  $to
     * @return bool True if email was sent successfully
     */
    public static function send(Mailable $mailable, string $to): bool
    {
        try {
            if (! self::configureDynamicMail()) {
                // Fall back to .env settings if no database settings
                Mail::to($to)->send($mailable);

                return true;
            }

            // Purge the cached mailer so it uses the new config
            Mail::purge('smtp');

            Mail::to($to)->send($mailable);

            return true;
        } catch (Exception $e) {
            Log::error('Failed to send email: ' . $e->getMessage());

            return false;
        }
    }

    /**
     * Send a test email to verify SMTP configuration.
     *
     * @param  string  $to  The recipient email address
     * @return array{success: bool, error?: string}
     */
    public static function sendTestEmail(string $to): array
    {
        try {
            if (! self::configureDynamicMail()) {
                return [
                    'success' => false,
                    'error' => 'SMTP settings are not configured. Please fill in the SMTP settings first.',
                ];
            }

            Mail::purge('smtp');

            Mail::raw(
                'This is a test email from FOODCITA. Your SMTP settings are working correctly!',
                function ($message) use ($to): void {
                    $message->to($to)->subject('FOODCITA - Test Email');
                }
            );

            return ['success' => true];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get the admin notification email address from settings.
     *
     * @return string|null The admin notification email, or null if not set
     */
    public static function getAdminNotificationEmail(): ?string
    {
        $setting = AdminSetting::where('key', self::SETTING_ADMIN_NOTIFICATION_EMAIL)->first();

        return $setting?->value;
    }

    /**
     * Get all SMTP settings from the database.
     *
     * @return array<string, mixed>
     */
    private static function getSmtpSettings(): array
    {
        return AdminSetting::query()
            ->whereIn('key', [
                self::SETTING_SMTP_HOST,
                self::SETTING_SMTP_PORT,
                self::SETTING_SMTP_USERNAME,
                self::SETTING_SMTP_PASSWORD,
                self::SETTING_SMTP_ENCRYPTION,
                self::SETTING_MAIL_FROM_ADDRESS,
                self::SETTING_MAIL_FROM_NAME,
            ])
            ->pluck('value', 'key')
            ->toArray();
    }

    /**
     * Check if required SMTP settings are present.
     *
     * @param  array<string, mixed>  $settings
     * @return bool
     */
    private static function hasRequiredSettings(array $settings): bool
    {
        return ! empty($settings[self::SETTING_SMTP_HOST])
            && ! empty($settings[self::SETTING_SMTP_PORT]);
    }

    /**
     * Apply mail configuration from settings array.
     *
     * @param  array<string, mixed>  $settings
     * @return void
     */
    private static function applyMailConfiguration(array $settings): void
    {
        Config::set('mail.mailers.smtp.host', $settings[self::SETTING_SMTP_HOST]);
        Config::set('mail.mailers.smtp.port', (int) $settings[self::SETTING_SMTP_PORT]);
        Config::set('mail.mailers.smtp.username', $settings[self::SETTING_SMTP_USERNAME] ?? null);
        Config::set('mail.mailers.smtp.password', $settings[self::SETTING_SMTP_PASSWORD] ?? null);
        Config::set(
            'mail.mailers.smtp.encryption',
            $settings[self::SETTING_SMTP_ENCRYPTION] ?? self::DEFAULT_ENCRYPTION
        );

        if (! empty($settings[self::SETTING_MAIL_FROM_ADDRESS])) {
            Config::set('mail.from.address', $settings[self::SETTING_MAIL_FROM_ADDRESS]);
        }

        if (! empty($settings[self::SETTING_MAIL_FROM_NAME])) {
            Config::set('mail.from.name', $settings[self::SETTING_MAIL_FROM_NAME]);
        }
    }
}
