<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('suppliers')) {
            Schema::create('suppliers', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('category');
                $table->string('status')->default('Active');
                $table->string('sub_categories')->nullable();
                $table->string('contact_person');
                $table->string('phone');
                $table->string('email')->nullable();
                $table->text('address');
                $table->string('payment_terms')->nullable();
                $table->string('delivery_schedule')->nullable();
                $table->decimal('rating', 3, 2)->default(0.00);
                $table->timestamps();
            });
        } else {
            // Safely add missing columns if the table already exists
            Schema::table('suppliers', function (Blueprint $table) {
                if (!Schema::hasColumn('suppliers', 'status')) {
                    $table->string('status')->default('Active')->after('category');
                }
                if (!Schema::hasColumn('suppliers', 'sub_categories')) {
                    $table->string('sub_categories')->nullable()->after('status');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};