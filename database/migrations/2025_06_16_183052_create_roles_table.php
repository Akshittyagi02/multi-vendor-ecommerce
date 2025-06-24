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
     Schema::create('roles', function (Blueprint $table) {
    $table->id(1);
    $table->string('name')->unique('admin');
        
    $table->string('guard_name'); // Add this line
    $table->timestamps();
     Schema::create('roles', function (Blueprint $table) {
    $table->id(2);
    $table->string('name')->unique('vendor');
        
    $table->string('guard_name'); // Add this line
    $table->timestamps();
     Schema::create('roles', function (Blueprint $table) {
    $table->id(1);
    $table->string('name')->unique('coustomer');
        
    $table->string('guard_name'); // Add this line
    $table->timestamps();
        });

    }
     }

    /**$table->string('name')->unique('vendor');
            $table->string('name')->unique('customer');
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
