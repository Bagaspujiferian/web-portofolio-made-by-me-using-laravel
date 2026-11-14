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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('Bagas Puji Ferian');
            $table->string('brand_name')->default('BagasDev.');
            $table->string('role_badge')->default('FULLSTACK');
            $table->string('institution_name')->default('UNIVERSITAS BSI');
            $table->string('institution_logo_url')->nullable();
            $table->string('card_header')->default('DEVELOPER');
            $table->string('card_side_label')->default('SOFTWARE ENGINEER');
            $table->string('card_footer_left')->default('PORTFOLIO');
            $table->string('card_footer_right')->default("Don't repeat yourself");
            $table->json('typewriter_texts')->nullable();
            $table->text('hero_bio')->nullable();
            $table->text('about_bio')->nullable();
            $table->string('id_card_photo_url')->nullable();
            $table->string('spiderman_photo_url')->nullable();
            $table->string('spotify_playlist_url')->nullable();
            $table->string('spotify_embed_url')->nullable();
            $table->string('background_audio_url')->nullable();
            $table->string('github_url')->nullable();
            $table->string('github_username')->default('@bagaspujiferian');
            $table->string('instagram_url')->nullable();
            $table->string('instagram_username')->default('@bagaspujiferian');
            $table->string('tiktok_url')->nullable();
            $table->string('tiktok_username')->default('@bagas.dev');
            $table->string('linkedin_url')->nullable();
            $table->string('email')->default('bagaspujiferian@gmail.com');
            $table->integer('projects_count_override')->nullable();
            $table->integer('certificates_count_override')->nullable();
            $table->integer('awards_count_override')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
