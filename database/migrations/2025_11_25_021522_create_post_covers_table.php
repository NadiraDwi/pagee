<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_covers', function (Blueprint $table) {
            $table->id('id_cover');

            $table->unsignedBigInteger('id_post');
            $table->string('cover_path');

            $table->timestamps();

            $table->foreign('id_post')
                ->references('id_post')
                ->on('posts')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_covers');
    }
};
