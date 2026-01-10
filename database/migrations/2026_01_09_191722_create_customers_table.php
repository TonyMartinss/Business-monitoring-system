<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->decimal('advance', 12, 2)->nullable();
            $table->timestamps();
        });

        // Insert some dummy customers after table creation
        Db::table('customers')->insert([
            ['name' => 'John Doe',        'phone' => '0712345678', 'email' => 'john@example.com',      'address' => 'Dar es Salaam',  'advance' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jane Smith',      'phone' => '0723456789', 'email' => 'jane@example.com',      'address' => 'Arusha',         'advance' => 500,  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Michael Johnson', 'phone' => '0734567890', 'email' => 'michael@example.com',   'address' => 'Mwanza',         'advance' => 0,    'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Emily Davis',     'phone' => '0745678901', 'email' => 'emily@example.com',     'address' => 'Dodoma',         'advance' => 200,  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'David Wilson',    'phone' => '0756789012', 'email' => 'david@example.com',     'address' => 'Mbeya',          'advance' => 0,    'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sarah Brown',     'phone' => '0767890123', 'email' => 'sarah@example.com',     'address' => 'Tanga',          'advance' => 300,  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'James Miller',    'phone' => '0778901234', 'email' => 'james@example.com',     'address' => 'Kilimanjaro',    'advance' => 150,  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Linda Anderson',  'phone' => '0789012345', 'email' => 'linda@example.com',     'address' => 'Morogoro',       'advance' => 0,    'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Robert Thomas',   'phone' => '0790123456', 'email' => 'robert@example.com',    'address' => 'Singida',        'advance' => 400,  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Patricia Jackson', 'phone' => '0701234567', 'email' => 'patricia@example.com',  'address' => 'Mbinga',         'advance' => 250,  'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
