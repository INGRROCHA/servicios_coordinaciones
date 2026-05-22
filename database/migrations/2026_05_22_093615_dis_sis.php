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
       Schema::create('dis_sis', function (Blueprint $table) {
            $table->integer('id_dis_sis')->primary();
            $table->integer('num_economico');
            $table->integer('id_rol');
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
        Schema::dropIfExists('dis_sis');
    }
};
