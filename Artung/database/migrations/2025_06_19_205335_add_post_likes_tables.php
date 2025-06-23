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
        Schema::create('posts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('title');
        $table->text('description')->nullable();
        $table->string('image_path');
        $table->timestamps();
        $table->foreignId('tag1_id')
                  ->nullable()
                  ->constrained('tags')
                  ->nullOnDelete();
        $table->foreignId('tag2_id')
                  ->nullable()
                  ->constrained('tags')
                  ->nullOnDelete();
        $table->foreignId('tag3_id')
                  ->nullable()
                  ->constrained('tags')
                  ->nullOnDelete();
        });

        Schema::create('likes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('post_id')->constrained()->onDelete('cascade');
        $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
        Schema::dropIfExists('likes');
    }
};
