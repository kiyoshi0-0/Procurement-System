<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('receipts', function (Blueprint $table) {
            if (!Schema::hasColumn('receipts', 'purchase_order_id')) {
                $table->foreignId('purchase_order_id')
                    ->nullable()
                    ->after('po_number')
                    ->constrained('purchase_orders')
                    ->nullOnDelete();
            }
        });

        DB::table('receipts')
            ->join('purchase_orders', 'receipts.po_number', '=', 'purchase_orders.po_number')
            ->whereNotNull('purchase_orders.id')
            ->update(['receipts.purchase_order_id' => DB::raw('purchase_orders.id')]);
    }

    public function down(): void
    {
        Schema::table('receipts', function (Blueprint $table) {
            if (Schema::hasColumn('receipts', 'purchase_order_id')) {
                $table->dropConstrainedForeignId('purchase_order_id');
            }
        });
    }
};
