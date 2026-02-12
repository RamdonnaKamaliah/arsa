@extends('layouts.peminjam')

@section('content')
    <div class="w-full mx-auto py-8 px-6">

        <div class="bg-white shadow-xl rounded-2xl p-8">

            <!-- Header -->
            <div class="mb-6 border-b pb-4">
                <h2 class="text-2xl font-bold text-gray-800">
                    Detail Pengembalian Alat
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Informasi lengkap pengembalian alat
                </p>
            </div>

            <!-- Detail Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">

                <!-- Tanggal Pengembalian -->
                <div>
                    <p class="text-gray-500">Tanggal Pengembalian</p>
                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $peminjaman->tanggal_pengembalian_sebenarnya ?? '-' }}
                    </p>
                </div>

                <!-- Status Pelanggaran -->
                <div>
                    <p class="text-gray-500">Status Pelanggaran</p>
                    <span
                        class="mt-1 inline-block px-3 py-1 rounded-full text-xs font-semibold
                    {{ $peminjaman->status_pelanggaran ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">

                        {{ $peminjaman->status_pelanggaran ? 'Ada Pelanggaran' : 'Tidak Ada Pelanggaran' }}
                    </span>
                </div>

                <!-- Hari Terlambat -->
                <div>
                    <p class="text-gray-500">Hari Terlambat</p>
                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $peminjaman->hari_terlambat ?? 0 }} Hari
                    </p>
                </div>

                <!-- Kondisi Kembali -->
                <div>
                    <p class="text-gray-500">Kondisi Kembali</p>
                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $peminjaman->kondisi_kembali ?? '-' }}
                    </p>
                </div>

            </div>

            <!-- Catatan -->
            <div class="mt-6">
                <p class="text-gray-500">Catatan</p>
                <div class="mt-2 p-4 bg-gray-50 rounded-lg text-gray-700 text-sm">
                    {{ $peminjaman->catatan ?? 'Tidak ada catatan.' }}
                </div>
            </div>

            <!-- Back Button -->
            <div class="mt-8 text-right">
                <a href="{{ route('peminjam.pengembalianAlat') }}"
                    class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                    Kembali
                </a>
            </div>

        </div>
    </div>
@endsection
