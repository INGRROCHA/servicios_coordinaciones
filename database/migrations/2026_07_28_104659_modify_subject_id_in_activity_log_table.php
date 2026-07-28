<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Alteramos la columna directamente en MySQL para convertirla a VARCHAR
        DB::statement("ALTER TABLE activity_log MODIFY subject_id VARCHAR(255) NULL;");
    }

    public function down(): void
    {
        // Revertimos la columna a BIGINT en caso de rollback
        DB::statement("ALTER TABLE activity_log MODIFY subject_id BIGINT UNSIGNED NULL;");
    }
};