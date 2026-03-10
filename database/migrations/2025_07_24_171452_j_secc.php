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
         Schema::create('j_secc', function (Blueprint $table) {
            $table->integer('id_j_secc')->primary();
            $table->integer('id_rol');
            $table->integer('id_seccion');
            $table->string('j_secc');
            $table->boolean('estatus')->default(true); // true = activo, false = inactivo
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
