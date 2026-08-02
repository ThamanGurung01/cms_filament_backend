<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Page extends Model
{
    use LogsActivity;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    // ─── meta_keywords — stored comma-separated, exposed as array ─────────────

    public function getMetaKeywordsAttribute(?string $value): array
    {
        if (empty($value)) {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode(',', $value))));
    }

    public function setMetaKeywordsAttribute(mixed $value): void
    {
        if (is_array($value)) {
            $this->attributes['meta_keywords'] = implode(',', array_filter(array_map('trim', $value)));
        } else {
            $this->attributes['meta_keywords'] = $value ?? '';
        }
    }

    /**
     * Return a comma-separated string for use in <meta name="keywords"> tags.
     */
    public function getMetaKeywordsString(): string
    {
        $keywords = $this->meta_keywords;
        return is_array($keywords) ? implode(', ', $keywords) : (string) $keywords;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }
}
