<?php

//jed
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('goods_receipts', function (Blueprint $table) {

            $table->id();

            // Receipt Information
            $table->string('gr_number')->unique();
            $table->string('po_number');

            // Supplier
            $table->string('supplier')->nullable();

            // Item Details
            $table->string('item_name');
            $table->integer('po_quantity');
            $table->integer('gr_quantity');

            // Warehouse
            $table->string('warehouse')
                  ->default('Main Warehouse');

            // Inspection
            $table->enum('inspection_status', [
                'Pending',
                'Passed',
                'Failed',
                'Partial'
            ])->default('Pending');

            // Matching
            $table->string('match_status')
                  ->default('MATCHED');

            // Overall Status
            $table->enum('status', [
                'Pending',
                'Approved',
                'Disputed',
                'Rejected'
            ])->default('Pending');

            $table->timestamp('approved_at')
                  ->nullable();

            // Optional procurement fields
            $table->string('invoice_number')->nullable();
            $table->string('item_code')->nullable();
            $table->decimal('po_price',10,2)->nullable();
            $table->decimal('invoice_price',10,2)->nullable();

            $table->text('resolution_notes')
                  ->nullable();

            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('goods_receipts');
    }
};