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
        Schema::create('public_comments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('comment');
            $table->longText('avatar_base64')->nullable();
            $table->boolean('is_approved')->default(true);
            $table->boolean('is_pinned')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_comments');
    }
};
