<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->enum('type', ['ebook', 'formation', 'service']); // Type de produit
            $table->decimal('price', 10, 2);
            $table->decimal('old_price', 10, 2)->nullable(); // Pour les promotions
            $table->integer('discount_percentage')->nullable();
            $table->string('image');
            $table->json('features'); // Liste des caractéristiques
            $table->integer('sales_count')->default(0);
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
