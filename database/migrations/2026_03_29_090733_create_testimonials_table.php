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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('client_logo')->nullable();
            $table->text('quote');
            $table->string('author_name');
            $table->string('author_role');
            $table->string('featured_image')->nullable();
            $table->longText('case_study_content')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->string('slug')->unique();
            $table->string('video_url')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('region')->nullable();
            $table->string('industry')->nullable();
            $table->string('client_description')->nullable();
            $table->string('project_type')->nullable();
            $table->string('project_description')->nullable();
            $table->string('primary_location')->nullable();
            $table->string('location_description')->nullable();
            $table->string('services_scope')->nullable();
            $table->string('services_description')->nullable();
            $table->string('verification_type')->nullable();
            $table->string('verification_description')->nullable();
            $table->longText('full_letter')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
