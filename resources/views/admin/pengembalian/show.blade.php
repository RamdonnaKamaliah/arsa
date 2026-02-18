@extends('layouts.admin')

@section('title', 'detail pengembalian')

@section('content')

    <div class="w-full mx-auto py-8 px-6">

        <div class="bg-white shadow-xl rounded-2xl p-8">

            <div class="mb-6">
                <a href="{{ route('admin.pengembalian.index') }}"
                    class="text-blue-600 hover:text-blue-800 font-semibold flex items-center gap-2">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
            </div>


            <!-- Header -->
            <div class="mb-6 border-b pb-4">
                <h2 class="text-2xl font-bold text-gray-800">
                    Detail Pengembalian Alat
                </h2>
                <h2>ID Pengembalian : #{{ $pengembalian->id_peminjaman }}</h2>
            </div>

            <!-- Detail Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">

                <!-- Tanggal Pengembalian -->
                <div>
                    <p class="text-gray-500">Tanggal Pengembalian</p>
                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $pengembalian->tanggal_pengembalian_sebenarnya ?? '-' }}
                    </p>
                </div>

                <!-- Status Pelanggaran -->
                <div>
                    <p class="text-gray-500">Status Pelanggaran</p>
                    <span
                        class="mt-1 inline-block px-3 py-1 rounded-full text-xs font-semibold
                    {{ $pengembalian->status_pelanggaran ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">

                        {{ $pengembalian->status_pelanggaran ? 'Ada Pelanggaran' : 'Tidak Ada Pelanggaran' }}
                    </span>
                </div>

                <!-- Hari Terlambat -->
                <div>
                    <p class="text-gray-500">Hari Terlambat</p>
                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $pengembalian->hari_terlambat ?? 0 }} Hari
                    </p>
                </div>

                <!-- Kondisi Kembali -->
                <div>
                    <p class="text-gray-500">Kondisi Kembali</p>
                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $pengembalian->kondisi_kembali ?? '-' }}
                    </p>
                </div>

            </div>

            <!-- Catatan -->
            <div class="mt-6">
                <p class="text-gray-500">Catatan</p>
                <div class="mt-2 p-4 bg-gray-50 rounded-lg text-gray-700 text-sm">
                    {{ $pengembalian->catatan ?? 'Tidak ada catatan.' }}
                </div>
            </div>



        </div>
    </div>

@endsection
