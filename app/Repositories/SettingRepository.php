<?php

namespace App\Repositories;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     */
    public function __construct(Setting $model)
    {
        parent::__construct($model);
    }

    /**
     * Get setting value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getValue(string $key, $default = null)
    {
        return Cache::remember("setting.{$key}", 3600, function () use ($key, $default) {
            $setting = $this->model->where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set setting value by key.
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function setValue(string $key, $value): bool
    {
        $setting = $this->model->firstOrNew(['key' => $key]);
        $setting->value = $value;
        $result = $setting->save();
        
        Cache::forget("setting.{$key}");
        
        return $result;
    }

    /**
     * Get all settings as key-value array.
     *
     * @return array
     */
    public function getAllAsArray(): array
    {
        return Cache::remember('settings.all', 3600, function () {
            return $this->model->pluck('value', 'key')->toArray();
        });
    }

    /**
     * Update multiple settings at once.
     *
     * @param array $settings
     * @return void
     */
    public function updateMultiple(array $settings): void
    {
        foreach ($settings as $key => $value) {
            $this->setValue($key, $value);
        }
        
        Cache::forget('settings.all');
    }
}

