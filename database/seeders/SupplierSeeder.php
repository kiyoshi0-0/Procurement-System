<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        // This will generate 100 fake suppliers
        Supplier::factory()->count(100)->create();
    }
}