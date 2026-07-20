<?php

// JOHNNY


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suppliersLegaspi', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('supplier_code')->nullable();
            $table->string('type')->nullable();
            $table->string('category')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('contact_person')->nullable();
            $table->text('description')->nullable();
            $table->text('address')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};