<?php

namespace Tests\Feature;

use App\Models\PurchaseOrder;
use App\Models\Receipt;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GoodsReceiptControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_receipt_update_syncs_the_linked_purchase_order_status(): void
    {
        $supplier = Supplier::factory()->create();

        $purchaseOrder = PurchaseOrder::factory()->create([
            'supplier_id' => $supplier->id,
            'status' => 'Confirmed',
        ]);

        $receipt = Receipt::create([
            'gr_number' => 'GR-TEST-1',
            'po_number' => $purchaseOrder->po_number,
            'supplier' => $supplier->name,
            'item_name' => 'Test Item',
            'po_quantity' => 10,
            'gr_quantity' => 8,
            'warehouse' => 'Main Warehouse',
            'inspection_status' => 'Pending',
            'match_status' => 'QTY MISMATCH',
            'status' => 'Pending',
            'purchase_order_id' => $purchaseOrder->id,
        ]);

        $response = $this->put(route('receipts.update', $receipt->id), [
            'supplier' => $supplier->name,
            'item_name' => 'Test Item',
            'po_quantity' => 10,
            'gr_quantity' => 10,
            'po_price' => 100,
            'invoice_price' => 100,
            'warehouse' => 'Main Warehouse',
            'inspection_status' => 'Passed',
        ]);

        $response->assertRedirect(route('orders.list'));

        $receipt->refresh();
        $purchaseOrder->refresh();

        $this->assertSame('MATCHED', $receipt->match_status);
        $this->assertSame('Delivered', $purchaseOrder->status);
    }
}
