<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminSetting;
use App\Services\MailService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Controller for managing admin settings.
 *
 * Handles global application settings stored in key-value format.
 *
 * @package App\Http\Controllers\Admin
 */
class AdminSettingController extends Controller
{
    /**
     * Session key for admin ID.
     */
    private const SESSION_ADMIN_ID = 'admin_id';

    /**
     * Get all settings as key-value pairs.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request): JsonResponse
    {
        $adminId = $request->session()->get(self::SESSION_ADMIN_ID);

        if (! $adminId) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $settings = $this->formatSettingsAsKeyValue();

        return response()->json($settings);
    }

    /**
     * Save settings from request data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request): JsonResponse
    {
        $adminId = $request->session()->get(self::SESSION_ADMIN_ID);

        if (! $adminId) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $this->saveSettings($request->all(), $adminId);

        return response()->json(['success' => true]);
    }

    /**
     * Send a test email to verify email configuration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function testEmail(Request $request): JsonResponse
    {
        $adminId = $request->session()->get(self::SESSION_ADMIN_ID);

        if (! $adminId) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $result = MailService::sendTestEmail($request->input('email'));

        return response()->json($result);
    }

    /**
     * Upload site logo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadLogo(Request $request): JsonResponse
    {
        $adminId = $request->session()->get(self::SESSION_ADMIN_ID);

        if (! $adminId) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $request->validate([
            'logo' => ['required', 'image', 'max:2048'],
        ]);

        // Delete old logo if exists
        $oldLogo = AdminSetting::query()->where('key', 'site_logo')->first();
        if ($oldLogo && $oldLogo->value) {
            Storage::disk('public')->delete($oldLogo->value);
        }

        // Store new logo
        $path = $request->file('logo')->store('logos', 'public');

        // Save setting
        AdminSetting::query()->updateOrCreate(
            ['key' => 'site_logo'],
            ['value' => $path, 'admin_id' => $adminId]
        );

        return response()->json(['path' => $path]);
    }

    /**
     * Remove site logo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeLogo(Request $request): JsonResponse
    {
        $adminId = $request->session()->get(self::SESSION_ADMIN_ID);

        if (! $adminId) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $setting = AdminSetting::query()->where('key', 'site_logo')->first();
        if ($setting && $setting->value) {
            Storage::disk('public')->delete($setting->value);
            $setting->delete();
        }

        return response()->json(['success' => true]);
    }

    /**
     * Format all settings as a key-value array.
     *
     * @return array<string, mixed>
     */
    private function formatSettingsAsKeyValue(): array
    {
        $rows = AdminSetting::query()->get();
        $settings = [];

        foreach ($rows as $row) {
            $settings[$row->key] = $row->value;
        }

        return $settings;
    }

    /**
     * Save settings from data array.
     *
     * @param  array<string, mixed>  $data
     * @param  int  $adminId
     * @return void
     */
    private function saveSettings(array $data, int $adminId): void
    {
        foreach ($data as $key => $value) {
            if ($key === '_token') {
                continue;
            }

            AdminSetting::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'admin_id' => $adminId]
            );
        }
    }
}
