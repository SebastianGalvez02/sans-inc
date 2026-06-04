<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Runs the migrations.
     * This method is called when running 'php artisan migrate'.
     * It builds the table structure in the database.
     */
    public function up(): void
    {
        // Creates a new table called 'roles'
        Schema::create('roles', function (Blueprint $table) {
            // Generates an Auto-incrementing primary key(PK) called 'id'
            $table->id();

            // Creates a VARCHAR type column to store the role's name (ej: 'client', 'admin')
            $table->string('role_name');

            // Creates a column FOR brief descriptions. the ->nullable() method indicates that it is optional
            $table->string('description')->nullable();

            // Automatically creates two TIMESTAMP type columns: 'created_at' y 'updated_at'
            $table->timestamps();

            // Creates the 'deleted_at' column that's needed for SoftDeletes.
            // This means roles are not fully deleted, just inactive
            $table->softDeletes();
        });
    }

    /**
     * Reverts migrations.
     * This method is called when running 'php artisan migrate:rollback'.
     * It undoes everything done in up().
     */
    public function down(): void
    {
        // Deletes the 'roles' table from the database if it exists
        Schema::dropIfExists('roles');
    }
};
