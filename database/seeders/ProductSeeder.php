<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Engine Oil (1L)',
                'quantity' => 100,
                'selling_price' => 6.00,
                'purchase_price' => 4.00,
                'category' => 'Lubricants',
                'supplier' => 'Lubricants Co.',
                'reorder_level' => 20,
                'expiry_date' => now()->addYears(2),
            ],
            [
                'name' => 'Front Brake Pads',
                'quantity' => 40,
                'selling_price' => 15.00,
                'purchase_price' => 10.00,
                'category' => 'Braking System',
                'supplier' => 'Quick Brakes Ltd',
                'reorder_level' => 10,
            ],
            [
                'name' => 'Rear Brake Pads',
                'quantity' => 35,
                'selling_price' => 14.00,
                'purchase_price' => 9.00,
                'category' => 'Braking System',
                'supplier' => 'Quick Brakes Ltd',
                'reorder_level' => 10,
            ],
            [
                'name' => 'Spark Plug (NGK)',
                'quantity' => 80,
                'selling_price' => 5.00,
                'purchase_price' => 3.00,
                'category' => 'Electrical',
                'supplier' => 'MotorWorks Ltd',
                'reorder_level' => 20,
            ],
            [
                'name' => '12V Motorcycle Battery',
                'quantity' => 25,
                'selling_price' => 40.00,
                'purchase_price' => 30.00,
                'category' => 'Electrical',
                'supplier' => 'MotorWorks Ltd',
                'reorder_level' => 5,
                'expiry_date' => now()->addYears(2),
            ],
            [
                'name' => 'Air Filter',
                'quantity' => 30,
                'selling_price' => 15000.00,
                'purchase_price' => 10000.00,
                'category' => 'Engine Parts',
                'supplier' => 'FreshAir Ltd',
                'reorder_level' => 5,
                'expiry_date' => now()->addYear(),
            ],
            [
                'name' => 'Fuel Filter',
                'quantity' => 25,
                'selling_price' => 10.00,
                'purchase_price' => 7.00,
                'category' => 'Engine Parts',
                'supplier' => 'FreshAir Ltd',
                'reorder_level' => 5,
                'expiry_date' => now()->addYear(),
            ],
            [
                'name' => 'Front Tyre (2.75-18)',
                'quantity' => 15,
                'selling_price' => 45.00,
                'purchase_price' => 35.00,
                'category' => 'Tyres',
                'supplier' => 'TyreCo',
                'reorder_level' => 5,
                'expiry_date' => now()->addYears(5),
            ],
            [
                'name' => 'Rear Tyre (3.00-18)',
                'quantity' => 15,
                'selling_price' => 50.00,
                'purchase_price' => 38.00,
                'category' => 'Tyres',
                'supplier' => 'TyreCo',
                'reorder_level' => 5,
                'expiry_date' => now()->addYears(5),
            ],
            [
                'name' => 'Side Mirrors (Pair)',
                'quantity' => 40,
                'selling_price' => 20.00,
                'purchase_price' => 12.00,
                'category' => 'Accessories',
                'supplier' => 'SafeRide Accessories',
                'reorder_level' => 10,
            ],
            [
                'name' => 'Rider Helmet',
                'quantity' => 50,
                'selling_price' => 60.00,
                'purchase_price' => 40.00,
                'category' => 'Safety Gear',
                'supplier' => 'SafetyFirst Ltd',
                'reorder_level' => 15,
                'expiry_date' => now()->addYears(5),
            ],
        ];

        foreach ($products as $p) {
            Product::create([
                'name' => $p['name'],
                'quantity' => $p['quantity'],
                'selling_price' => $p['selling_price'],
                'purchase_price' => $p['purchase_price'],
                'category_id' => Category::where('name', $p['category'])->first()->id ?? null,
                'supplier_id' => Supplier::where('name', $p['supplier'])->first()->id ?? null,
                'reorder_level' => $p['reorder_level'],
                'damaged_quantity' => $p['damaged_quantity'] ?? 0,
                'barcode' => Str::random(10),
                'expiry_date' => $p['expiry_date'] ?? null,
            ]);
        }
    }
}
