<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Mail\UserPasswordResetMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PasswordResetController extends Controller
{
    /**
     * Show the forgot password form.
     */
    public function showForgotPassword(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle the forgot password request.
     */
    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::query()->where('email', $request->email)->first();

        if ($user) {
            // Generate token
            $token = Str::random(64);

            // Delete existing tokens
            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();

            // Store new token
            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => Hash::make($token),
                'created_at' => now(),
            ]);

            // Send email
            Mail::to($user->email)->send(new UserPasswordResetMail($user, $token));
        }

        // Always return success to prevent email enumeration
        return back()->with('status', 'If your email address exists in our database, you will receive a password reset link shortly.');
    }

    /**
     * Show the reset password form.
     */
    public function showResetPassword(Request $request, string $token): View
    {
        return view('auth.reset-password', [
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

        $record = DB::table('password_reset_tokens')
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

        // Update user password
        User::query()
            ->where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        // Delete token
        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect('/login')->with('status', 'Your password has been reset successfully. Please login with your new password.');
    }
}
