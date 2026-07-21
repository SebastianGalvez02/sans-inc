<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('publication_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userId')->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('publicationId')->constrained('publications', 'publicationId')->cascadeOnDelete();
            $table->unique(['userId', 'publicationId']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publication_likes');
    }
};
