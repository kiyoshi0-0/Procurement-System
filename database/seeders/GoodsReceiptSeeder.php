<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Receipt;
use Carbon\Carbon;

class GoodsReceiptSeeder extends Seeder
{
    public function run(): void
    {
        // Gagawa ito ng mga receipts na naka-set agad sa approved at matched
        Receipt::factory()->count(100)->create([
            'inspection_status' => 'Passed',
            'match_status' => 'MATCHED',
            'approved_at' => Carbon::now(),
        ]);
    }
}