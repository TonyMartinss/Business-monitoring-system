<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            ['name' => 'Quick Brakes Ltd', 'contact_info' => 'quickbrakes@example.com', 'lead_time_days' => 5],
            ['name' => 'Lubricants Co.', 'contact_info' => 'lubricants@example.com', 'lead_time_days' => 7],
            ['name' => 'FreshAir Ltd', 'contact_info' => 'filters@example.com', 'lead_time_days' => 4],
            ['name' => 'TyreCo', 'contact_info' => 'tyreco@example.com', 'lead_time_days' => 10],
            ['name' => 'SafeRide Accessories', 'contact_info' => 'saferide@example.com', 'lead_time_days' => 3],
            ['name' => 'SafetyFirst Ltd', 'contact_info' => 'safety@example.com', 'lead_time_days' => 6],
            ['name' => 'MotorWorks Ltd', 'contact_info' => 'motorworks@example.com', 'lead_time_days' => 8],
            ['name' => 'Cables & More', 'contact_info' => 'cables@example.com', 'lead_time_days' => 5],
        ];

        foreach ($suppliers as $supplier
        ) {
            Supplier::create($supplier);
        }
    }
}
