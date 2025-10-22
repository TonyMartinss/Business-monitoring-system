<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id(); // Primary key: auto-incrementing ID

            // ✅ Supplier details
            $table->string('supplier_name'); // Name of the supplier
           
            // ✅ Financial details
            $table->decimal('total_amount', 15, 2); // Total purchase value
            $table->foreignId('account_id')->nullable()->constrained('accounts');

            // ✅ Date and notes
            $table->date('purchase_date'); // When the purchase was made
            $table->text('notes')->nullable(); // Optional field for description or extra info

            $table->timestamps(); // Creates 'created_at' and 'updated_at' automatically
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchases'); // Rollback support
    }
};
