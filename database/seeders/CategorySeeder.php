<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Lubricants'],
            ['name' => 'Braking System'],
            ['name' => 'Engine Parts'],
            ['name' => 'Electrical'],
            ['name' => 'Tyres'],
            ['name' => 'Control System'],
            ['name' => 'Accessories'],
            ['name' => 'Safety Gear'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
