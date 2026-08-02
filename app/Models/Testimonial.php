<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Testimonial extends Model
{
    use LogsActivity;

    use HasFactory;

    protected $fillable = [
        "client_description",
        "region",
        "industry",
        "client_brief_description",
        "project_type",
        "project_type_description",
        "project_description",
        "primary_location",
        "primary_location_description",
        "location_description",
        "services_scope",
        "services_scope_description",
        "services_description",
        "verification_type",
        "verification_description",
        "services_delivered",
        "reference_document",
        "reference_document_summary",
        "full_letter",

        'client_name',
        'slug',
        'client_logo',
        'quote',
        'video_url',
        'author_name',
        'author_role',
        'featured_image',
        'case_study_content',
        'is_featured',
        'sort_order',
        'is_published',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }
}
