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
        Schema::table('orders', function (Blueprint $table) {
            // Kolom untuk menyimpan status permintaan refund
            $table->string('refund_status')->nullable()->after('status_pesanan');
            // Kolom untuk menyimpan alasan refund dari user
            $table->text('refund_reason')->nullable()->after('refund_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['refund_status', 'refund_reason']);
        });
    }
};
