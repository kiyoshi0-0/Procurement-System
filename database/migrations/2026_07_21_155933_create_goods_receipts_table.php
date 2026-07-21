<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('goods_receipts', function (Blueprint $table) {
            $table->id();
            $table->string('gr_number')->unique();
            $table->string('po_number');
            $table->string('supplier')->nullable();
            $table->string('item_name');
            $table->integer('po_quantity');
            $table->integer('gr_quantity');
            $table->string('warehouse')->default('Main Warehouse');
            $table->string('inspection_status')->default('Pending');
            $table->string('match_status')->default('MATCHED');
            $table->string('status')->default('Pending');
            $table->dateTime('approved_at')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('item_code')->nullable();
            $table->decimal('po_price', 10, 2)->nullable();
            $table->decimal('invoice_price', 10, 2)->nullable();
            $table->text('resolution_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goods_receipts');
    }
};