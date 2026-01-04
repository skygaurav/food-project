<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminPasswordResetMail;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminPasswordResetController extends Controller
{
    /**
     * Show the forgot password form.
     */
    public function showForgotPassword(): View
    {
        return view('admin.forgot-password');
    }

    /**
     * Handle the forgot password request.
     */
    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $admin = Admin::query()->where('email', $request->email)->first();

        if ($admin) {
            // Generate token
            $token = Str::random(64);

            // Delete existing tokens
            DB::table('admin_password_reset_tokens')
                ->where('email', $request->email)
                ->delete();

            // Store new token
            DB::table('admin_password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => Hash::make($token),
                'created_at' => now(),
            ]);

            // Send email
            Mail::to($admin->email)->send(new AdminPasswordResetMail($admin, $token));
        }

        // Always return success to prevent email enumeration
        return back()->with('status', 'If your email address exists in our database, you will receive a password reset link shortly.');
    }

    /**
     * Show the reset password form.
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
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        $record = DB::table('admin_password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$record) {
            return back()->withErrors(['email' => 'Invalid password reset request.']);
        }

        // Check token validity
        if (!Hash::check($request->token, $record->token)) {
            return back()->withErrors(['email' => 'Invalid password reset token.']);
        }

        // Check if token is expired (60 minutes)
        if (now()->diffInMinutes($record->created_at) > 60) {
            return back()->withErrors(['email' => 'Password reset link has expired.']);
        }

        // Update admin password
        Admin::query()
            ->where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        // Delete token
        DB::table('admin_password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect('/admin/login')->with('status', 'Your password has been reset successfully. Please login with your new password.');
    }
}
