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
        //Crea la tabla de Datos Personales por completar
        Schema::create('dpersonales', function (Blueprint $table) {
            $table->integer('num_economico')->primary();
            $table->string('edificio');
            $table->string('nivel');
            $table->string('cubiculo');
            $table->string('extension');
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
