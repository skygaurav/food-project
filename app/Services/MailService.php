<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\AdminSetting;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Transport\Dsn;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransportFactory;

class MailService
{
    /**
     * Configure mail settings from database before sending.
     */
    public static function configureDynamicMail(): bool
    {
        // Get SMTP settings from database (use admin_id = 1 for global settings)
        $settings = AdminSetting::query()
            ->whereIn('key', [
                'smtp_host',
                'smtp_port',
                'smtp_username',
                'smtp_password',
                'smtp_encryption',
                'mail_from_address',
                'mail_from_name',
            ])
            ->pluck('value', 'key')
            ->toArray();

        // Check if we have the required settings
        if (empty($settings['smtp_host']) || empty($settings['smtp_port'])) {
            return false;
        }

        // Configure the mail settings dynamically
        Config::set('mail.mailers.smtp.host', $settings['smtp_host']);
        Config::set('mail.mailers.smtp.port', (int) $settings['smtp_port']);
        Config::set('mail.mailers.smtp.username', $settings['smtp_username'] ?? null);
        Config::set('mail.mailers.smtp.password', $settings['smtp_password'] ?? null);
        Config::set('mail.mailers.smtp.encryption', $settings['smtp_encryption'] ?? 'tls');
        
        if (!empty($settings['mail_from_address'])) {
            Config::set('mail.from.address', $settings['mail_from_address']);
        }
        
        if (!empty($settings['mail_from_name'])) {
            Config::set('mail.from.name', $settings['mail_from_name']);
        }

        return true;
    }

    /**
     * Send a mailable using dynamic SMTP settings.
     */
    public static function send(Mailable $mailable, string $to): bool
    {
        try {
            // Configure dynamic mail settings
            if (!self::configureDynamicMail()) {
                // Fall back to .env settings if no database settings
                Mail::to($to)->send($mailable);
                return true;
            }

            // Purge the cached mailer so it uses the new config
            Mail::purge('smtp');

            // Send the email
            Mail::to($to)->send($mailable);

            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to send email: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send a test email.
     */
    public static function sendTestEmail(string $to): array
    {
        try {
            // Configure dynamic mail settings
            if (!self::configureDynamicMail()) {
                return [
                    'success' => false,
                    'error' => 'SMTP settings are not configured. Please fill in the SMTP settings first.',
                ];
            }

            // Purge the cached mailer
            Mail::purge('smtp');

            // Send test email
            Mail::raw('This is a test email from FOODCITA. Your SMTP settings are working correctly!', function ($message) use ($to) {
                $message->to($to)
                    ->subject('FOODCITA - Test Email');
            });

            return ['success' => true];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get the admin notification email address.
     */
    public static function getAdminNotificationEmail(): ?string
    {
        $setting = AdminSetting::where('key', 'admin_notification_email')->first();
        return $setting?->value;
    }
}
