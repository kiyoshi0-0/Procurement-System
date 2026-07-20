<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Call your other seeders first
        $this->call([
            SupplierSeeder::class,
            PurchaseSeeder::class,
            ContractSeeder::class,
            PurchaseRequestSeeder::class,
        ]);

        // 2. Run your factory generation logic
        PurchaseOrder::factory(100)
            ->create()
            ->each(function ($po) {
                PurchaseOrderItem::factory()
                    ->count(rand(1, 4))
                    ->create([
                        'purchase_order_id' => $po->id
                    ]);
            });
    }
}