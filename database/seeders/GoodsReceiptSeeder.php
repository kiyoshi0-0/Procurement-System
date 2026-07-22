<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Receipt; // Siguraduhing naka-import ang Receipt model

class GoodsReceiptSeeder extends Seeder
{
    public function run(): void
    {
        // Gagawa ito ng 10 na magkakaibang receipts nang awtotomatiko
        Receipt::factory()->count(100)->create();
    }
}