<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('sort_order')->default(0);
            $table->string('subtitle');
            $table->string('slug')->unique();
            $table->string('content_title');
            $table->string('content_title_color_text');
            $table->longText('content')->nullable();
            $table->json('info_list')->nullable();
            $table->json('capabilities')->nullable();
            $table->json('how_we_work')->nullable();
            $table->string('service_video_url')->nullable();
            $table->json('faq')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->foreignId('service_category_id')->nullable()->constrained('service_categories')->onDelete('set null');
            $table->string('icon')->nullable();
            $table->text('json_ld_schema')->nullable();
            $table->string('requirements_subtitle')->nullable();
            $table->text('requirements_description')->nullable();
            $table->text('requirements_notice')->nullable();
            $table->json('requirements_list')->nullable();
            $table->string('coverage_title')->nullable();
            $table->string('coverage_subtitle')->nullable();
            $table->json('coverage_list')->nullable();
            $table->string('hero_pill_text')->nullable();
            $table->string('overview_badge')->nullable();
            $table->string('capabilities_card_title')->nullable();
            $table->string('warnings_title')->nullable();
            $table->string('capabilities_badge')->nullable();
            $table->string('how_we_work_badge')->nullable();
            $table->string('how_we_work_title')->nullable();
            $table->string('req_col_document')->nullable();
            $table->string('req_col_why_required')->nullable();
            $table->string('req_col_format')->nullable();
            $table->string('video_badge')->nullable();
            $table->string('video_title')->nullable();
            $table->string('faq_badge')->nullable();
            $table->string('faq_title')->nullable();
            $table->text('faq_description')->nullable();
            $table->string('cta_badge')->nullable();
            $table->string('cta_title')->nullable();
            $table->string('cta_button_text')->nullable();
            $table->string('cta_secondary_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
