<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('slug_seos', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique()->index()->comment('URL path, e.g. / or /tours or /contact');
            $table->string('meta_title', 60)->nullable();
            $table->text('meta_description')->nullable();
            $table->json('meta_keywords')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slug_seos');
    }
};
