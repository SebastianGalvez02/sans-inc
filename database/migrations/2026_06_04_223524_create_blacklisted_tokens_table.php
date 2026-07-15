<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates the 'blacklisted_tokens' table to store invalidated JWT tokens on logout.
     */
    public function up(): void
    {
        Schema::create('blacklisted_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Stores the full JWT string — TEXT to handle long tokens
            $table->text('token');

            // When this token naturally expires (matches JWT exp claim)
            $table->timestamp('expires_at');

            $table->timestamps();

            // Index for fast lookup during middleware validation
            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blacklisted_tokens');
    }
};
