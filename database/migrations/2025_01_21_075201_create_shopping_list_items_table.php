<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shopping_list_items', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('shopping_list_id')->constrained()->onDelete('cascade'); 
            $table->foreignId('ingredient_id')->constrained()->onDelete('cascade'); 
            $table->float('quantity'); 
            $table->enum('unit', ['grams', 'milliliters', 'pieces']); 
            $table->boolean('is_purchased')->default(false); 
            $table->timestamps(); 
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_allergen')->default(false);
            $table->string('category')->nullable(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shopping_list_items');
    }
};
