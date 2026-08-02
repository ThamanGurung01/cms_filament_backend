<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('filming_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('tagline')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('where_is_it')->nullable();
            $table->longText('how_to_get_there')->nullable();
            $table->longText('filming_highlights')->nullable();
            $table->string('hero_image')->nullable();
            $table->json('gallery')->nullable();        // array of image paths
            $table->decimal('map_x', 6, 2)->default(50); // % position on the Nepal map
            $table->decimal('map_y', 6, 2)->default(50);
            $table->string('region')->nullable();       // e.g. Himalayan, Terai, Hills
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('filming_locations');
    }
};
