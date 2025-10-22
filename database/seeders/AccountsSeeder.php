<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;

class AccountsSeeder extends Seeder
{
    public function run()
    {
        
        $accounts = [
            ['name' => 'Cash',  'type' => 'asset', 'code' => '001', 'balance' => 0],
            ['name' => 'Bank',  'type' => 'asset', 'code' => '002', 'balance' => 0],
            ['name' => 'Mpesa', 'type' => 'asset', 'code' => '003', 'balance' => 0],
        ];

        foreach ($accounts as $acc) {
            // Avoid duplicates
            Account::firstOrCreate(
                ['name' => $acc['name']], // only check by name
                $acc // fill the rest
            );
        }
    }
}
