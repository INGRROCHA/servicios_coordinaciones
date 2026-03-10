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
        //
        Schema::create('servicios', function (Blueprint $table) {
            $table->string('id_servicio')->primary();
            $table->string('servicio');
            $table->integer('id_seccion');
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
        Schema::dropIfExists('servicios_1');
    }
};
