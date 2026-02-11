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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_peminjaman')->unique();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->timestamp('tanggal_pengajuan')->useCurrent();
            $table->date('tanggal_pengambilan_rencana');
            $table->date('tanggal_pengembalian_rencana');
            $table->timestamp('tanggal_pengambilan_sebenarnya')->nullable();
            $table->text('alasan_peminjaman');
            $table->foreignId('disetujui_oleh')->nullable()->constrained('users');
            $table->enum('status', ['pending', 'disetujui', 'ditolak', 'diambil', 'kembali', 'terlambat', 'bermasalah'])->default('pending');
            $table->string('qr_token')->nullable()->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};