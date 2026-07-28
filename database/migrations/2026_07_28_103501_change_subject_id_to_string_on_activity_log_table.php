<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('activity_log', function (Blueprint $table) {
            // Cambiamos el tipo de dato a string para soportar "saat_1", etc.
            $table->string('subject_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('activity_log', function (Blueprint $table) {
            // Revertir a número entero en caso de rollback
            $table->unsignedBigInteger('subject_id')->nullable()->change();
        });
    }
};