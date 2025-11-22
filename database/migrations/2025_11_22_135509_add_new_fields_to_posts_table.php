<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {

            // Tambah hanya kolom yang belum ada

            if (!Schema::hasColumn('posts', 'mentions')) {
                $table->json('mentions')->nullable()->after('isi');
            }

            if (!Schema::hasColumn('posts', 'scheduled_at')) {
                $table->dateTime('scheduled_at')->nullable()->after('is_anonymous');
            }

            if (!Schema::hasColumn('posts', 'status')) {
                $table->enum('status', ['public', 'private'])->default('public')->after('scheduled_at');
            }
        });
    }


    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['mentions', 'scheduled_at', 'status']);
        });
    }

};
