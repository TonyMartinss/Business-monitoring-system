<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expense_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained()->onDelete('cascade'); // Account (Cash, Bank, Mpesa)
            $table->decimal('amount', 15, 2); // Expense amount
            $table->string('reason')->nullable(); // Optional reason
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // User who recorded
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expense_movements');
    }
};
