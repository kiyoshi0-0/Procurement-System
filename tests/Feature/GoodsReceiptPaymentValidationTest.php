<?php

namespace Tests\Feature;

use App\Models\Receipt;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class GoodsReceiptPaymentValidationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->string('gr_number')->nullable();
            $table->string('po_number')->nullable();
            $table->string('supplier')->nullable();
            $table->string('item_name')->nullable();
            $table->integer('po_quantity')->nullable();
            $table->integer('gr_quantity')->nullable();
            $table->decimal('po_price', 12, 2)->nullable();
            $table->decimal('invoice_price', 12, 2)->nullable();
            $table->string('warehouse')->nullable();
            $table->string('inspection_status')->nullable();
            $table->string('match_status')->nullable();
            $table->string('status')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('receipts');

        parent::tearDown();
    }

    public function test_payment_validation_page_uses_consistent_receipt_statuses_and_counts(): void
    {
        Receipt::factory()->create([
            'inspection_status' => 'Passed',
            'po_quantity' => 10,
            'gr_quantity' => 10,
            'po_price' => 100.00,
            'invoice_price' => 100.00,
            'match_status' => 'MATCHED',
            'status' => null,
            'approved_at' => null,
        ]);

        Receipt::factory()->create([
            'inspection_status' => 'Passed',
            'po_quantity' => 10,
            'gr_quantity' => 8,
            'po_price' => 100.00,
            'invoice_price' => 100.00,
            'match_status' => 'QTY MISMATCH',
        ]);

        Receipt::factory()->create([
            'inspection_status' => 'Passed',
            'po_quantity' => 10,
            'gr_quantity' => 10,
            'po_price' => 100.00,
            'invoice_price' => 100.00,
            'match_status' => 'COMPLETED',
        ]);

        $response = $this->get(route('receipts.payment'));

        $response->assertOk();
        $response->assertViewHasAll([
            'totalInvoices' => 3,
            'approvedPaymentsCount' => 1,
            'pendingValidationCount' => 1,
            'paymentIssuesCount' => 1,
            'sentToFinanceCount' => 0,
        ]);
        $response->assertSee('Payment Validation');
        $response->assertSee('MATCHED');
        $response->assertSee('QTY MISMATCH');
        $response->assertSee('COMPLETED');
    }
}
