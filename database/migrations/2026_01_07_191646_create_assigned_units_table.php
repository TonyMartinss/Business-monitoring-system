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
        Schema::create('assigned_units', function (Blueprint $table) {
            $table->id(); // Primary key, auto-increment integer

            // Use unsignedBigInteger for foreign keys (better than string for IDs)
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('unit_id');

            // Content can be text if it's longer than 255 characters
            $table->text('content')->nullable();

            // Price should be decimal for money, with 2 decimal places
            $table->decimal('price', 10, 2);

            // Add timestamps for created_at and updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assigned_units');
    }
};
