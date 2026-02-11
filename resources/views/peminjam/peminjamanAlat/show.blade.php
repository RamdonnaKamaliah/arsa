@extends('layouts.peminjam')

@section('title', 'Detail Peminjaman')

@section('content')

    <div class="pt-6 px-4 flex justify-center">
        <div class="w-full bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-8">

            <div class="mb-6">
                <a href="{{ route('peminjam.peminjamAlat') }}"
                    class="text-blue-600 hover:text-blue-800 font-semibold flex items-center gap-2">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
            </div>

            {{-- Judul --}}
            <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-8">
                Detail Peminjaman
            </h2>

            {{-- Info Status --}}
            <div class="flex justify-between items-center mb-6">
                <p class="text-gray-600 dark:text-gray-300">
                    ID Peminjaman:
                    <span class="font-bold text-gray-800 dark:text-white">
                        #{{ $peminjaman->id }}
                    </span>
                </p>

                <span
                    class="px-4 py-2 rounded-xl text-sm font-semibold
                @if ($peminjaman->status == 'pending') bg-yellow-100 text-yellow-700
                @elseif($peminjaman->status == 'disetujui') bg-green-100 text-green-700
                @elseif($peminjaman->status == 'ditolak') bg-red-100 text-red-700 @endif">
                    {{ strtoupper($peminjaman->status) }}
                </span>
            </div>

            {{-- Tanggal --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <div class="p-4 rounded-xl bg-gray-50 dark:bg-slate-700">
                    <p class="text-sm text-gray-500 dark:text-gray-300">Rencana Ambil</p>
                    <p class="font-bold text-gray-800 dark:text-white">
                        {{ $peminjaman->tanggal_pengambilan_rencana }}
                    </p>
                </div>

                <div class="p-4 rounded-xl bg-gray-50 dark:bg-slate-700">
                    <p class="text-sm text-gray-500 dark:text-gray-300">Rencana Kembali</p>
                    <p class="font-bold text-gray-800 dark:text-white">
                        {{ $peminjaman->tanggal_pengembalian_rencana }}
                    </p>
                </div>
            </div>

            {{-- Alasan --}}
            <div class="mb-8">
                <p class="text-sm text-gray-500 dark:text-gray-300 mb-2">
                    Alasan / Catatan
                </p>
                <div class="p-4 rounded-xl bg-gray-100 dark:bg-slate-700 text-gray-800 dark:text-white">
                    {{ $peminjaman->alasan_peminjaman }}
                </div>
            </div>

            {{-- List Alat --}}
            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">
                Daftar Alat Dipinjam
            </h3>

            <div class="space-y-4">
                @foreach ($peminjaman->detail as $item)
                    <div class="flex justify-between items-center p-4 rounded-xl bg-gray-50 dark:bg-slate-700">
                        <p class="font-semibold text-gray-800 dark:text-white">
                            {{ $item->alat->nama_alat }}
                        </p>
                        <span class="px-3 py-1 rounded-lg bg-blue-100 text-blue-700 font-bold">
                            {{ $item->jumlah }} pcs
                        </span>
                    </div>
                @endforeach
            </div>

            <div
                class="text-center p-6 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700">
                <h3 class="text-lg font-bold mb-4 text-slate-800 dark:text-white">Kode QR Peminjaman</h3>

                <div class="inline-block p-4 bg-white rounded-xl mb-4 border border-slate-100">
                    {!! QrCode::size(200)->generate($peminjaman->id_peminjaman) !!}
                </div>

                <p class="text-xs text-slate-500 mb-6">Gunakan kode ini saat pengambilan alat di gudang.</p>

                <a href="{{ route('peminjam.peminjaman.downloadQr', $peminjaman->id) }}"
                    class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-blue-500/30 transform hover:-translate-y-1">
                    <i class="fas fa-download mr-2"></i> Unduh Kode QR
                </a>
            </div>

            {{-- QR Code --}}
            @if ($peminjaman->status == 'disetujui' && $peminjaman->qr_token)
                <div class="mt-10 text-center">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">
                        QR Code Pengambilan
                    </h3>

                    <p class="text-sm text-gray-500 dark:text-gray-300 mb-4">
                        Tunjukkan QR ini kepada petugas saat mengambil alat.
                    </p>

                    <div class="flex justify-center">
                        <img src="{{ asset('storage/qrcode/' . $peminjaman->qr_token) }}"
                            class="w-52 h-52 rounded-xl shadow-md">
                    </div>
                </div>
            @endif

            {{-- Jika Pending --}}
            @if ($peminjaman->status == 'pending')
                <div class="mt-10 text-center">
                    <p class="text-yellow-600 font-semibold">
                        Menunggu persetujuan petugas...
                    </p>
                </div>
            @endif

        </div>
    </div>

@endsection
