<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Menambahkan 2 kolom baru setelah kolom duration_hours
            $table->string('add_on_name')->nullable()->after('duration_hours');
            $table->integer('add_on_price')->default(0)->after('add_on_name');
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['add_on_name', 'add_on_price']);
        });
    }
};