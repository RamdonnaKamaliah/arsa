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
        Schema::table('pengembalian', function (Blueprint $table) {
            $table->integer('hari_terlambat')->default(0)->after('status_pelanggaran');
            $table->datetime('tanggal_penggantian')->nullable()->after('catatan');
            $table->enum('status_penggantian', ['menunggu', 'selesai'])->nullable()->after('tanggal_penggantian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengembalian', function (Blueprint $table) {
            //
        });
    }
};