@extends('layouts.petugas')
@section('title', 'Laporan Peminjaman')

@section('content')

    <div class="bg-white rounded-2xl shadow p-6">

        <h2 class="text-xl font-bold text-gray-800 mb-6">
            Laporan Peminjaman Alat
        </h2>

        <!-- Filter -->
        <form method="GET" class="flex flex-wrap gap-3 mb-6">

            <select name="filter" class="border rounded-lg px-3 py-2 text-sm">
                <option value="">Semua Data</option>
                <option value="hari" {{ request('filter') == 'hari' ? 'selected' : '' }}>Per Hari</option>
                <option value="minggu" {{ request('filter') == 'minggu' ? 'selected' : '' }}>Per Minggu</option>
                <option value="bulan" {{ request('filter') == 'bulan' ? 'selected' : '' }}>Per Bulan</option>
            </select>

            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700">
                Filter
            </button>

            <a href="{{ route('petugas.laporan.index') }}"
                class="px-4 py-2 bg-gray-500 text-white rounded-lg text-sm hover:bg-gray-600">
                Reset
            </a>

            <a href="{{ route('petugas.laporan.unduh', ['filter' => request('filter')]) }}"
                class="ml-auto px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700">
                Unduh PDF
            </a>

        </form>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">Nama Peminjam</th>
                        <th class="px-4 py-2 border">Alat</th>
                        <th class="px-4 py-2 border">Tanggal Pinjam</th>
                        <th class="px-4 py-2 border">Tanggal Kembali</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjaman as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">
                                {{ $item->user->name ?? '-' }}
                            </td>
                            <td class="px-4 py-2 border">
                                @foreach ($item->detail as $detail)
                                    {{ $detail->alat->nama_alat ?? '-' }} <br>
                                @endforeach
                            </td>
                            <td class="px-4 py-2 border">
                                {{ $item->tanggal_pengajuan }}
                            </td>
                            <td class="px-4 py-2 border">
                                {{ $item->pengembalian->tanggal_pengembalian_sebenarnya ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500">
                                Tidak ada data
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

@endsection
