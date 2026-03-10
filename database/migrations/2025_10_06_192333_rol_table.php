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
        Schema::create('rol', function (Blueprint $table) {
            $table->id('id_rol')->primary();
            $table->string('tipo_rol', 25);
            $table->string('descripcion', 100);
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
