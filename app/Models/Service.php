<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Service extends Model
{
    use LogsActivity;

    protected $fillable = [
        'title',
        'sort_order',
        'subtitle',
        'hero_pill_text',
        'slug',
        'content_title',
        'content_title_color_text',
        'content',
        'info_list',
        'capabilities',
        'how_we_work',
        'service_video_url',
        'faq',
        'image',
        'is_active',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'json_ld_schema',
        'service_category_id',
        'icon',

        // New Custom Sections
        'expertise_badge',
        'expertise_title',
        'expertise_description',
        'expertise_warnings',
        'capabilities_title',
        'capabilities_description',
        'capabilities_list',
        'requirements_title',
        'requirements_subtitle',
        'requirements_description',
        'requirements_notice',
        'requirements_list',
        'coverage_title',
        'coverage_subtitle',
        'coverage_list',

        // Dynamic Section Labels
        'overview_badge',
        'capabilities_card_title',
        'warnings_title',
        'capabilities_badge',
        'how_we_work_badge',
        'how_we_work_title',
        'req_col_document',
        'req_col_why_required',
        'req_col_format',
        'video_badge',
        'video_title',
        'faq_badge',
        'faq_title',
        'faq_description',
        'cta_badge',
        'cta_title',
        'cta_button_text',
        'cta_secondary_text',
    ];

    protected $casts = [
        'info_list' => 'json',
        'capabilities' => 'json',
        'how_we_work' => 'json',
        'faq' => 'json',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'service_category_id' => 'integer',
        
        // New Custom Sections Casts
        'expertise_warnings' => 'json',
        'capabilities_list' => 'json',
        'requirements_list' => 'json',
        'coverage_list' => 'json',
    ];

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }
}
