<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Controller for managing admin users.
 *
 * Provides CRUD operations for administrator accounts.
 *
 * @package App\Http\Controllers\Admin
 */
class AdminManagementController extends Controller
{
    /**
     * List all admin users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(Admin::query()->orderBy('username')->get());
    }

    /**
     * Show a single admin user.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Admin $admin): JsonResponse
    {
        return response()->json($admin);
    }

    /**
     * Create a new admin user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:admins,username'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $admin = Admin::query()->create([
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json($admin, 201);
    }

    /**
     * Update an existing admin user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Admin $admin): JsonResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:admins,username,' . $admin->id],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        $admin->username = $validated['username'];

        if (! empty($validated['password'])) {
            $admin->password = Hash::make($validated['password']);
        }

        $admin->save();

        return response()->json($admin);
    }

    /**
     * Delete an admin user.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Admin $admin): JsonResponse
    {
        $admin->delete();

        return response()->json(null, 204);
    }
}
