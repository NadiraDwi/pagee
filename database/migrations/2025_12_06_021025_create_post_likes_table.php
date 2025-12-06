<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_likes', function (Blueprint $table) {
            $table->id('id_like');
            $table->foreignId('id_post')->constrained('posts', 'id_post')->onDelete('cascade');
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['id_post', 'id_user']); // 1 user = 1 like per post
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_likes');
    }
};
