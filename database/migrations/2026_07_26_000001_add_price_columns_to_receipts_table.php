<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('receipts', function (Blueprint $table) {
            if (!Schema::hasColumn('receipts', 'po_price')) {
                $table->decimal('po_price', 15, 2)->nullable();
            }

            if (!Schema::hasColumn('receipts', 'invoice_price')) {
                $table->decimal('invoice_price', 15, 2)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('receipts', function (Blueprint $table) {
            if (Schema::hasColumn('receipts', 'po_price')) {
                $table->dropColumn('po_price');
            }

            if (Schema::hasColumn('receipts', 'invoice_price')) {
                $table->dropColumn('invoice_price');
            }
        });
    }
};
