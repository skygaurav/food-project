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
            return response()->json(null, 403);
        }

        $data = $request->validate([
            'key' => ['required','string'],
            'value' => ['required','array'],
        ]);

        $setting = AdminSetting::query()->updateOrCreate([
            'admin_id' => $adminId,
            'key' => $data['key'],
        ],['value' => $data['value']]);

        return response()->json($setting);
    }
}
