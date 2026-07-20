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
            $table->string('address');
            $table->string('category');
            $table->string('contact_person');
            $table->string('phone');
            $table->string('email');
            $table->string('payment_terms')->nullable();
            $table->string('delivery_schedule')->nullable();
            $table->decimal('rating', 2, 1)->default(0.0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('suppliers');
    }
};