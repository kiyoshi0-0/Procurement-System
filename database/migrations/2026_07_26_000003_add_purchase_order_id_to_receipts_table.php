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

        DB::table('receipts')->update([
            'purchase_order_id' => DB::raw("(SELECT purchase_orders.id FROM purchase_orders WHERE purchase_orders.po_number = receipts.po_number LIMIT 1)")
        ]);
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
