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
        Schema::create('ticket', function (Blueprint $table) {
            $table->id('id_ticket')->primary();
            $table->integer('id_coordinacion');
            $table->integer('id_seccion');
            $table->string('id_servicio');
            $table->string('nombre');
            $table->string('email');
            $table->integer('num_economico');
            $table->string('adscripcion');
            $table->string('dpto_coord');
            $table->string('area_secc');
            $table->text('descripcion')->nullable();;   
            $table->integer('id_estado')->default(1);
            $table->integer('id_tr_secc')->nullable();
            $table->boolean('estatus')->default(true); // 1 = activo, 0 = inactivo
            $table->text('observaciones')->nullable(); 
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