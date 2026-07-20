<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;
use App\Models\Contract;
use Carbon\Carbon;

class ContractSeeder extends Seeder
{
    public function run(): void
    {
        // Get the first 10 suppliers
        $suppliers = Supplier::take(10)->get();

        foreach ($suppliers as $index => $supplier) {
            Contract::create([
                'contract_id' => 'CT-2026-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'start_date' => Carbon::now()->subMonths(6), // Starts 6 months ago
                'end_date' => Carbon::now()->addMonths(6),   // Ends 6 months from now
                'supplier_id' => $supplier->id,
            ]);
        }
    }
}