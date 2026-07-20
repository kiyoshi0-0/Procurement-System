<?php

// IRA


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
        Schema::table('purchase_requests', function (Blueprint $table) {
        $table->date('estimated_delivery')->nullable(); // Date format
        $table->decimal('total_estimated', 15, 2)->nullable(); // Decimal (for money)
        $table->string('supplier')->nullable();
        $table->string('supported_documents')->nullable(); // Dito mo ilalagay yung path ng file
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_requests', function (Blueprint $table) {
            //
        });
    }
};
