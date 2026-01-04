<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * Controller for admin authentication.
 *
 * Handles admin login, logout, and dashboard access.
 *
 * @package App\Http\Controllers\Admin
 */
class AdminAuthController extends Controller
{
    /**
     * Session key for admin ID.
     */
    private const SESSION_ADMIN_ID = 'admin_id';

    /**
     * Show the admin login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLogin(): View
    {
        return view('admin.login');
    }

    /**
     * Handle admin login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $admin = Admin::query()->where('username', $credentials['username'])->first();

        if (! $admin || ! Hash::check($credentials['password'], $admin->password)) {
            return back()->withErrors(['username' => 'Invalid username or password.'])->withInput();
        }

        $request->session()->put(self::SESSION_ADMIN_ID, $admin->id);

        return redirect('/admin');
    }

    /**
     * Show the admin dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function dashboard(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has(self::SESSION_ADMIN_ID)) {
            return redirect('/admin/login');
        }

        return view('admin.dashboard');
    }

    /**
     * Handle admin logout request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget(self::SESSION_ADMIN_ID);

        return redirect('/admin/login');
    }
}
