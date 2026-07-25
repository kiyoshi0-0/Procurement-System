<?php

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
    Schema::create('delivery_issues', function (Blueprint $table) {
        $table->id();
        $table->foreignId('receipt_id')->constrained('receipts')->onDelete('cascade');
        $table->string('receipt_number');
        $table->string('supplier');
        $table->string('item_name');
        $table->string('issue_type')->nullable();
        $table->string('priority')->nullable();
        $table->string('status')->default('Active');
        $table->dateTime('reported_date')->nullable();
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('delivery_issues');
    }
};
