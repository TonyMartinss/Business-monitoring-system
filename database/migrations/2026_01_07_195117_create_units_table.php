<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Name of the unit, e.g., Piece, Box
            $table->timestamps();
        });

        // Insert some dummy units after table creation
        DB::table('units')->insert([
            ['name' => 'Piece', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Box', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kilogram', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Liter', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Packet', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
