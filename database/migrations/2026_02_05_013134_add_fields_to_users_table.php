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
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('id_user')->unique()->after('id');
            // $table->string('nama_lengkap')->after('id_user');
            $table->enum('role', ['admin', 'petugas', 'peminjam'])->default('peminjam')->after('password');
             $table->boolean('status_blokir')->default(false)->after('role');
            $table->boolean('masa_blokir')->nullable()->after('status_blokir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'id_user',
                'role',
                'status_blokir',
                'masa_blokir'
            ]);
        });
    }
};