<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Brand extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'logo',
        'row',
        'is_active',
        'sort_order',
        'url',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'row' => 'integer',
        'sort_order' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }
}
