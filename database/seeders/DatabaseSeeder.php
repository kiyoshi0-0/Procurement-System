<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;
use App\Models\Receipt;
use App\Models\DeliveryIssue;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Temporarily disabled all seeders to diagnose
        // $this->call([
        //     SupplierSeeder::class,
        //     ContractSeeder::class,
        //     PurchaseRequestSeeder::class,
        // ]);
    }
}
    
    
