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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            // Link to the users table. A vendor is essentially a user with a 'vendor' role.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('shop_name')->unique();
            $table->string('shop_slug')->unique(); // For friendly URLs (e.g., /shop/my-awesome-shop)
            $table->text('shop_description')->nullable();
            $table->string('shop_phone')->nullable();
            $table->string('shop_address')->nullable();
            $table->string('shop_banner')->nullable(); // Path to shop banner image
            $table->decimal('commission_rate', 5, 2)->default(0.00); // Admin can set commission for this vendor
            $table->boolean('is_approved')->default(false); // Admin approval for vendor shops
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};