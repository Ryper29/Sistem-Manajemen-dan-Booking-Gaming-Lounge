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
        Schema::create('hubs', function (Blueprint $table) {
            $table->id();
            $table->string('hub_number')->unique();
            $table->enum('tier', ['Standard', 'VIP', 'VVIP']);
            $table->string('facilities');
            $table->integer('price_per_hour');
            $table->enum('status', ['Tersedia', 'Disewa', 'Maintenance'])->default('Tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hubs');
    }
};
