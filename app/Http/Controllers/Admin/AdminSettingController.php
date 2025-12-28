<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function get(Request $request): JsonResponse
    {
        $adminId = $request->session()->get('admin_id');
        if (! $adminId) {
            return response()->json([], 403);
        }

        $rows = AdminSetting::query()->where('admin_id', $adminId)->get();
        $out = [];
        foreach ($rows as $r) {
            $out[$r->key] = $r->value;
        }

        return response()->json($out);
    }

    public function save(Request $request): JsonResponse
    {
        $adminId = $request->session()->get('admin_id');
        if (! $adminId) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $data = $request->all();
        
        // Save each setting as a separate key-value pair
        foreach ($data as $key => $value) {
            if ($key === '_token') {
                continue;
            }
            
            AdminSetting::query()->updateOrCreate(
                [
                    'admin_id' => $adminId,
                    'key' => $key,
                ],
                ['value' => $value]
            );
        }

        return response()->json(['success' => true]);
    }
}
