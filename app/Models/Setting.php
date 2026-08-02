<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use LogsActivity;

    protected $fillable = ['key', 'value'];

    /**
     * Get a setting value by key with optional default.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::rememberForever("setting:{$key}", function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set a setting value and flush its cache.
     */
    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("setting:{$key}");
    }

    /**
     * Return all settings as a cached Collection.
     */
    public static function allCached(): \Illuminate\Database\Eloquent\Collection
    {
        return Cache::rememberForever('settings:all', fn () => parent::all());
    }

    /**
     * Return all settings as a simple key=>value array.
     */
    public static function map(): array
    {
        return static::allCached()->pluck('value', 'key')->toArray();
    }

    /**
     * Flush all settings cache (call after bulk save).
     */
    public static function flushCache(): void
    {
        Cache::forget('settings:all');
        // Individual keys are flushed on set(); for bulk, also purge individual entries
        parent::all(['key'])->each(fn ($s) => Cache::forget("setting:{$s->key}"));
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }
}
