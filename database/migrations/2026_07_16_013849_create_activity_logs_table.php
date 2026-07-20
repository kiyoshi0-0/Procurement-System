<?php


// DANICA


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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id(); //[cite: 14]
            
            // Mga idinagdag na columns para sa PO History:
            $table->string('po_number')->nullable(); // Para malaman kung saang PO patungkol ang log
            $table->string('activity');              // Halimbawa: 'Created', 'Updated', 'Deleted', 'Status Change'
            $table->text('details');                 // Detalyadong mensahe (e.g., "PO-103 status changed to Dispatched")
            $table->string('user_name')->nullable(); // (Optional) Kung sino ang gumawa ng action (halimbawa: Admin)
            
            $table->timestamps(); //[cite: 14]
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs'); //[cite: 14]
    }
};