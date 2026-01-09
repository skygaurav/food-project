<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminPasswordResetMail;
use App\Models\Admin;
use App\Services\MailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Controller for admin password reset functionality.
 *
 * Handles forgot password requests and password reset operations for admins.
 *
 * @package App\Http\Controllers\Admin
 */
class AdminPasswordResetController extends Controller
{
    /**
     * Token expiration time in minutes.
     */
    private const TOKEN_EXPIRATION_MINUTES = 60;

    /**
     * Token length for password reset.
     */
    private const TOKEN_LENGTH = 64;

    /**
     * Database table for admin password reset tokens.
     */
    private const TOKENS_TABLE = 'admin_password_reset_tokens';

    /**
     * Show the forgot password form.
     *
     * @return \Illuminate\View\View
     */
    public function showForgotPassword(): View
    {
        return view('admin.forgot-password');
    }

    /**
     * Handle the forgot password request.
     *
     * Generates a password reset token and sends it via email.
     * Always returns success to prevent email enumeration attacks.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLink(Request $request): RedirectResponse
    {
        $rules = [
            'email' => ['required', 'email'],
        ];

        // Add captcha validation if enabled
        if (config('captcha.enabled', true) && config('captcha.sitekey')) {
            $rules['g-recaptcha-response'] = ['required', 'captcha'];
        }

        $request->validate($rules, [
            'g-recaptcha-response.required' => 'Please complete the captcha verification.',
            'g-recaptcha-response.captcha' => 'Captcha verification failed. Please try again.',
        ]);

        $admin = Admin::query()->where('email', $request->email)->first();

        if ($admin) {
            $token = $this->createResetToken($request->email);
            MailService::send(new AdminPasswordResetMail($admin, $token), $admin->email);
        }

        // Always return success to prevent email enumeration
        return back()->with(
            'status',
            'If your email address exists in our database, you will receive a password reset link shortly.'
        );
    }

    /**
     * Show the reset password form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $token
     * @return \Illuminate\View\View
     */
    public function showResetPassword(Request $request, string $token): View
    {
        return view('admin.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Handle the password reset.
     *
     * Validates the token and updates the admin's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        $record = DB::table(self::TOKENS_TABLE)
            ->where('email', $request->email)
            ->first();

        if (! $record) {
            return back()->withErrors(['email' => 'Invalid password reset request.']);
        }

        if (! $this->isValidToken($request->token, $record)) {
            return back()->withErrors(['email' => 'Invalid password reset token.']);
        }

        if ($this->isTokenExpired($record)) {
            return back()->withErrors(['email' => 'Password reset link has expired.']);
        }

        $this->updateAdminPassword($request->email, $request->password);
        $this->deleteResetToken($request->email);

        return redirect('/admin/login')->with(
            'status',
            'Your password has been reset successfully. Please login with your new password.'
        );
    }

    /**
     * Create a password reset token for the given email.
     *
     * @param  string  $email
     * @return string
     */
    private function createResetToken(string $email): string
    {
        $token = Str::random(self::TOKEN_LENGTH);

        // Delete existing tokens
        DB::table(self::TOKENS_TABLE)
            ->where('email', $email)
            ->delete();

        // Store new token
        DB::table(self::TOKENS_TABLE)->insert([
            'email' => $email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        return $token;
    }

    /**
     * Check if the provided token matches the stored hash.
     *
     * @param  string  $token
     * @param  object  $record
     * @return bool
     */
    private function isValidToken(string $token, object $record): bool
    {
        return Hash::check($token, $record->token);
    }

    /**
     * Check if the reset token has expired.
     *
     * @param  object  $record
     * @return bool
     */
    private function isTokenExpired(object $record): bool
    {
        return now()->diffInMinutes($record->created_at) > self::TOKEN_EXPIRATION_MINUTES;
    }

    /**
     * Update the admin's password.
     *
     * @param  string  $email
     * @param  string  $password
     * @return void
     */
    private function updateAdminPassword(string $email, string $password): void
    {
        Admin::query()
            ->where('email', $email)
            ->update(['password' => Hash::make($password)]);
    }

    /**
     * Delete the password reset token for the given email.
     *
     * @param  string  $email
     * @return void
     */
    private function deleteResetToken(string $email): void
    {
        DB::table(self::TOKENS_TABLE)
            ->where('email', $email)
            ->delete();
    }
}
