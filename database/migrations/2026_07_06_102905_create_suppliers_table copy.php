<?php

// CJ


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
    Schema::create('suppliers', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('category');
        $table->string('sub_categories')->nullable(); // <--- Add this line
        $table->string('contact_person');
        $table->string('phone');
        $table->string('email')->nullable();
        $table->text('address');
        $table->string('payment_terms')->nullable();
        $table->string('delivery_schedule')->nullable();
        $table->decimal('rating', 3, 2)->default(0.00); // <--- Make sure rating is here too
        $table->timestamps();
    });
    }

    public function down(): void {
        Schema::dropIfExists('suppliers');
    }
};