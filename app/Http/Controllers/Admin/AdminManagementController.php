<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminManagementController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Admin::query()->orderBy('username')->get());
    }

    public function show(Admin $admin): JsonResponse
    {
        return response()->json($admin);
    }

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

    public function update(Request $request, Admin $admin): JsonResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:admins,username,' . $admin->id],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        $admin->username = $validated['username'];
        
        if (!empty($validated['password'])) {
            $admin->password = Hash::make($validated['password']);
        }
        
        $admin->save();

        return response()->json($admin);
    }

    public function destroy(Admin $admin): JsonResponse
    {
        $admin->delete();
        return response()->json(null, 204);
    }
}
