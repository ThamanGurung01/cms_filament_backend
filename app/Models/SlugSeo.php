<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SlugSeo extends Model
{
    use LogsActivity;

    protected $table = 'slug_seos';

    protected $fillable = [
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'meta_keywords' => 'array',
    ];

    /**
     * Ensure slug always starts with a leading slash.
     */
    public function setSlugAttribute(string $value): void
    {
        $this->attributes['slug'] = str_starts_with($value, '/') ? $value : '/' . $value;
    }

    /**
     * Return keywords as a comma-separated string for use in <meta> tags.
     */
    public function getMetaKeywordsString(): string
    {
        return implode(', ', $this->meta_keywords ?? []);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }
}
