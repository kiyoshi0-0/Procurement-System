<?php


// DANICA


// database/migrations/xxxx_xx_xx_xxxxxx_create_purchase_orders_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('po_number')->unique(); // e.g., PO-101
            $table->date('date');
            $table->string('supplier'); // e.g., TicTac PC, MasterPc
            $table->string('status')->default('Confirmed'); // Confirmed, Sent, Delivered, Cancelled
            $table->text('delivery_address');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('purchase_orders');
    }
};

