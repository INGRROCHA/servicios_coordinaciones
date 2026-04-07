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
         Schema::create('tr_secc', function (Blueprint $table) {
            $table->integer('id_tr_secc')->primary();
            $table->integer('id_rol');
            $table->integer('id_seccion');
            $table->string('nombre', 100);
            $table->string('id_servicio', 20);
            $table->boolean('estatus')->default(true); // 1 = activo, 0 = inactivo
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
