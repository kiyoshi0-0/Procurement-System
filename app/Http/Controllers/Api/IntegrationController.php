<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\Purchase;
use Illuminate\Http\JsonResponse;

class IntegrationController extends Controller
{
    // API 1: Send Procurement & Vendor Data to Supply Chain Management
    public function exportSuppliersToSupplyChain(): JsonResponse
    {
        $suppliers = Supplier::select('name', 'category', 'sub_categories', 'payment_terms', 'rating', 'delivery_schedule')->get();

        return response()->json([
            'status' => 'success',
            'source_module' => 'Procurement',
            'target_module' => 'Supply Chain Management',
            'data_count' => $suppliers->count(),
            'payload' => $suppliers
        ], 200);
    }

    // API 2: Send Completed Purchases to Inventory & Warehouse
    public function exportPurchaseOrdersToWarehouse(): JsonResponse
    {
        // Fetch purchases matching the 'Completed' status with their supplier details
        $purchases = Purchase::with('supplier')
            ->where('status', 'Completed')
            ->get();

        return response()->json([
            'status' => 'success',
            'source_module' => 'Procurement',
            'target_module' => 'Inventory & Warehouse',
            'data_count' => $purchases->count(),
            'payload' => $purchases
        ], 200);
    }
}