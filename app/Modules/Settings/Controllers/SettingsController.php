<?php

namespace App\Modules\Settings\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    /**
     * Display the settings index page.
     */
    public function index()
    {
        $settings = Setting::orderBy('group')->orderBy('key')->get()->groupBy('group');
        $groups = ['general', 'company', 'seo', 'social', 'email', 'maps'];
        
        return view('admin.settings.index', compact('settings', 'groups'));
    }

    /**
     * Update settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'settings' => ['required', 'array'],
            'settings.*' => ['nullable', 'string'],
        ]);

        foreach ($validated['settings'] as $key => $value) {
            Setting::set($key, $value ?? '', 'string');
        }

        // Clear specific caches instead of flushing everything
        $this->clearSettingsRelatedCache();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }

    /**
     * Clear settings-related cache selectively.
     */
    protected function clearSettingsRelatedCache(): void
    {
        // Clear settings cache
        Cache::forget('settings');
        Cache::forget('settings.all');
        
        // Clear homepage content cache (may use settings)
        Cache::forget('homepage.content');
        
        // Clear dashboard stats cache
        Cache::forget('superadmin_dashboard_stats');
        Cache::forget('admin_dashboard_stats');
        
        // Try to clear tagged caches if driver supports it
        try {
            $driver = config('cache.default');
            if (in_array($driver, ['redis', 'memcached', 'dynamodb'])) {
                Cache::tags(['settings'])->flush();
            }
        } catch (\BadMethodCallException $e) {
            // Cache driver doesn't support tags, continue
        }
    }

    /**
     * Store a new setting.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => ['required', 'string', 'max:255', 'unique:settings,key'],
            'value' => ['nullable', 'string'],
            'type' => ['required', 'in:string,text,json,file'],
            'group' => ['required', 'in:general,company,seo,social,email,maps'],
        ]);

        Setting::create($validated);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Setting created successfully.');
    }

    /**
     * Delete a setting.
     */
    public function destroy(Setting $setting)
    {
        $setting->delete();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Setting deleted successfully.');
    }
}






