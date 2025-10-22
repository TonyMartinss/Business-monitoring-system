<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['in', 'out']); // stock in or out
            $table->integer('quantity');
            $table->integer('balance_before'); // stock balance before movement
            $table->integer('balance_after'); // stock balance after movement
            $table->string('reason')->nullable(); // e.. g Sale, Purchase, Adjustment..etc
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // user id
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
