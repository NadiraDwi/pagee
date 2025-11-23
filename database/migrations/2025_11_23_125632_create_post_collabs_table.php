<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_collabs', function (Blueprint $table) {
            $table->id('id_collab');

            // Relasi post
            $table->unsignedBigInteger('id_post');

            // Dua user yang berkolaborasi
            $table->unsignedBigInteger('id_user1');
            $table->unsignedBigInteger('id_user2');

            $table->timestamps();

            // Foreign key
            $table->foreign('id_post')
                  ->references('id_post')
                  ->on('posts')
                  ->onDelete('cascade');

            $table->foreign('id_user1')
                  ->references('id_user')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('id_user2')
                  ->references('id_user')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_collabs');
    }
};
