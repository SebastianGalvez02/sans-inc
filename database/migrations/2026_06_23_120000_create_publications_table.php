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
        Schema::create('publications', function (Blueprint $table) {
            $table->id('publicationId');
            $table->float('rating');
            $table->dateTime('publicationDate');
            $table->foreignId('userId')->constrained('users', 'id')->onDelete('cascade');
            $table->foreignId('productId')->constrained('products', 'productId')->onDelete('cascade');
            $table->integer('numberOfLikes')->default(0);
            $table->boolean('active')->default(true);
            $table->text('review')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};
