<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Redirect extends Model
{
    use LogsActivity;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'status_code' => 'integer',
    ];

    protected function setOldUrlAttribute($value): void
    {
        $value = trim($value);
        $normalized = '/' . ltrim($value, '/');
        // Strip trailing slash if it is not just '/'
        if ($normalized !== '/' && str_ends_with($normalized, '/')) {
            $normalized = rtrim($normalized, '/');
        }
        $this->attributes['old_url'] = $normalized;
    }

    protected static function booted(): void
    {
        static::saved(fn () => cache()->forget('active_redirects'));
        static::deleted(fn () => cache()->forget('active_redirects'));
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }

    /**
     * @return array<string, array{new_url: string|null, status_code: int}>
     */
    public static function getActiveRedirects(): array
    {
        return cache()->remember('active_redirects', now()->addHours(24), function () {
            return static::where('is_active', true)
                ->get(['old_url', 'new_url', 'status_code'])
                ->keyBy('old_url')
                ->toArray();
        });
    }
}
