<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('chapters', function (Blueprint $table) {
            // tahap 1: biar nullable dulu, menghindari truncation
            $table->string('link_musik', 255)->nullable()->change();
        });

        Schema::table('chapters', function (Blueprint $table) {
            // tahap 2: baru ubah ke TEXT
            $table->text('link_musik')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('chapters', function (Blueprint $table) {
            $table->string('link_musik', 255)->nullable(false)->change();
        });
    }

};
