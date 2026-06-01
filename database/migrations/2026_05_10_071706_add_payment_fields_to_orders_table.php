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
            // បន្ថែម Column ទាំង ២ នេះចូល
            $table->string('payment_method')->nullable();
            $table->string('payment_receipt')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // កូដសម្រាប់លុបវិញ ពេលយើងថយក្រោយ
            $table->dropColumn(['payment_method', 'payment_receipt']);
        });
    }
};
