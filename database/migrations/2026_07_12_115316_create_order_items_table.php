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
    Schema::create('order_items', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('order_id');
        $table->string('item_name');
        $table->string('category')->nullable();
        $table->string('unit')->nullable();
        $table->decimal('price', 15, 2)->default(0.00);
        $table->integer('quantity')->default(1);
        $table->timestamps();

        // Optional connection safety rule
        $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
