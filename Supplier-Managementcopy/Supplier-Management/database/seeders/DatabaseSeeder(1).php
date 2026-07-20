<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Call your custom seeder here
        $this->call([
            SupplierSeeder::class,
            PurchaseSeeder::class,
            ContractSeeder::class,
        ]);
    }
}