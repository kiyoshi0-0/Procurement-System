<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('receipts', function (Blueprint $table) {
        $table->id();
        $table->string('gr_number');
        $table->string('po_number');
        $table->string('supplier');
        $table->string('item_name');
        $table->integer('po_quantity');
        $table->integer('gr_quantity');
        $table->string('warehouse');
        $table->string('inspection_status');
        $table->string('match_status')->nullable();
        $table->timestamp('approved_at')->nullable(); // <-- Add this line
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('goods_receipts');
    }
};