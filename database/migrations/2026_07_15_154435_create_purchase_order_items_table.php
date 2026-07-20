<?php


// DANICA


// database/migrations/xxxx_xx_xx_xxxxxx_create_purchase_order_items_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained('purchase_orders')->onDelete('cascade');
            $table->string('name'); // e.g., BUBLI-parts Main Deck
            $table->integer('qty');
            $table->decimal('price', 10, 2); // Handles high precision pricing
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('purchase_order_items');
    }
};

