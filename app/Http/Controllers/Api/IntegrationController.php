<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Support\Facades\Http;
use App\Models\Purchase;
use Illuminate\Http\JsonResponse;

class IntegrationController extends Controller
{
    // API 1: Send Procurement & Vendor Data to Supply Chain Management
    // API 1: Send Procurement & Vendor Data to Supply Chain Management
    public function exportSuppliersToSupplyChain(): JsonResponse
    {
        $suppliers = Supplier::select(
            'id',
            'name',
            'contact_person',
            'phone',
            'email',
            'category',
            'sub_categories',
            'payment_terms',
            'rating',
            'delivery_schedule'
        )->get();

        // 1. PUT IT HERE: Attach the token when making the outgoing HTTP POST request
        $response = Http::withToken(env('SUPPLY_CHAIN_API_TOKEN'))
            ->post('http://supply.test/api/sync-suppliers', [
                'suppliers' => $suppliers->toArray()
            ]);

        // 2. Handle the response from Supply Chain
        if ($response->successful()) {
            return response()->json([
                'status' => 'success',
                'source_module' => 'Procurement',
                'target_module' => 'Supply Chain Management',
                'data_count' => $suppliers->count(),
                'payload' => $suppliers
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Authentication failed or target server unreachable.'
        ], 500);
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