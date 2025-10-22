<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // ties to Product
            $table->integer('quantity')->default(1);
            $table->decimal('selling_price', 12, 2);   // unit selling price at sale time
            $table->decimal('purchase_price', 12, 2);  // unit purchase price at sale time
            $table->decimal('total_price', 14, 2);     // quantity * selling_price
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
