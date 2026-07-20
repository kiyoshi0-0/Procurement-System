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
    // Palitan ang (Schema $table) ng (Blueprint $table)
    Schema::table('purchase_requests', function (Blueprint $table) {
        // Dito natin idadagdag ang bagong column para sa comment ng manager
        $table->text('manager_comment')->nullable()->after('status');
    });
}

public function down(): void
{
    // Palitan din dito ang (Schema $table) ng (Blueprint $table)
    Schema::table('purchase_requests', function (Blueprint $table) {
        $table->dropColumn('manager_comment');
    });
}
};
