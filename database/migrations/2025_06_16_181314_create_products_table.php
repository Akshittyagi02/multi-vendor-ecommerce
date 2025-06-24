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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // Foreign key to link product to its vendor (shop owner)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // This is the vendor's user_id
            $table->string('name');
            $table->string('slug')->unique(); // For friendly URLs
            $table->longText('description')->nullable();
            $table->string('image')->nullable(); // Main product image path
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->boolean('is_approved')->default(false); // Admin approval for product visibility
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};


