<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones (Run the migrations).
     * Este método se llama cuando ejecutas 'php artisan migrate'.
     * Su función es construir la estructura de la tabla en la base de datos.
     */
    public function up(): void
    {
        // Crea una nueva tabla llamada 'roles'
        Schema::create('roles', function (Blueprint $table) {
            // Genera una llave primaria (PK) autoincremental llamada 'id'
            $table->id();

            // Crea una columna tipo VARCHAR para guardar el nombre del rol (ej: 'cliente', 'admin')
            $table->string('nombre_rol');

            // Crea una columna para una breve descripción. El método ->nullable() indica que no es obligatoria
            $table->string('descripcion')->nullable();

            // Crea automáticamente dos columnas de tipo TIMESTAMP: 'created_at' y 'updated_at'
            $table->timestamps();

            // Crea la columna 'deleted_at' requerida para el borrado lógico (SoftDeletes).
            // Así los roles no se borran físicamente, solo quedan inactivos.
            $table->softDeletes();
        });
    }

    /**
     * Revierte las migraciones (Reverse the migrations).
     * Este método se llama cuando ejecutas 'php artisan migrate:rollback'.
     * Su función es deshacer lo que hizo el método up().
     */
    public function down(): void
    {
        // Elimina la tabla 'roles' de la base de datos si es que existe
        Schema::dropIfExists('roles');
    }
};
