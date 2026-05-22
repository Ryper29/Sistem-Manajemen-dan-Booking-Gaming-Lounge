<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel hubs
            $table->foreignId('hub_id')->constrained('hubs')->onDelete('cascade');
            
            // Data Pelanggan & Sewa
            $table->string('customer_name');
            $table->integer('duration_hours');
            $table->integer('total_price');
            
            // Tracking Waktu
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            
            // Status Transaksi
            $table->string('status');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
