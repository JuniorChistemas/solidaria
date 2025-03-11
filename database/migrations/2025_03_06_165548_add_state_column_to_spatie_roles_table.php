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
        // Obtener el nombre de la tabla desde la configuración de Spatie
        $tableNames = config('permission.table_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not loaded.');
        }

        Schema::table($tableNames['roles'], function (Blueprint $table) {
            // Añadir la columna state
            $table->boolean('state')->default(true)->comment('true: activo, false: inactivo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableNames = config('permission.table_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not found.');
        }

        Schema::table($tableNames['roles'], function (Blueprint $table) {
            $table->dropColumn('state');
        });
    }
};
