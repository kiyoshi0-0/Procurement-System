<?php

// JOHNNY


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('supplier_id');
        $table->date('po_date');
        $table->date('delivery_date')->nullable();
        $table->string('department');
        $table->string('requesting_person');
        $table->string('delivery_terms');
        $table->string('payment_mode');
        $table->string('currency');
        $table->string('email');
        $table->text('address');
        $table->text('notes')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
