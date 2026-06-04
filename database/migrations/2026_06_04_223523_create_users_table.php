<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /**
     * Run the migrations.
     * Creates the 'users' table with foreign key to 'roles'.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Foreign key linking to the 'roles' table
            $table->foreignId('role_id')->constrained('roles');

            // Basic user information
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password'); // Laravel uses this specific name by default
            $table->string('recovery_email')->nullable();

            // Timestamps (created_at, updated_at) and SoftDeletes (deleted_at)
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
