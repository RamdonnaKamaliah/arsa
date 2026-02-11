@extends('layouts.peminjam')
@section('title', 'Dashboard Saya')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard Peminjam</h1>
    <p class="text-gray-500 text-sm">Selamat datang kembali 👋</p>
</div>

{{-- Card Statistik --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">

    {{-- Total Peminjaman --}}
    <div class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-2xl shadow-lg p-6 hover:scale-105 transition duration-300 relative overflow-hidden">
        <div class="absolute -top-4 -right-4 opacity-20 text-6xl">📚</div>
        <h2 class="text-sm">Total Peminjaman</h2>
        <p class="text-3xl font-bold mt-2">15</p>
    </div>

    {{-- Sedang Dipinjam --}}
    <div class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white rounded-2xl shadow-lg p-6 hover:scale-105 transition duration-300 relative overflow-hidden">
        <div class="absolute -top-4 -right-4 opacity-20 text-6xl">⏳</div>
        <h2 class="text-sm">Sedang Dipinjam</h2>
        <p class="text-3xl font-bold mt-2">2</p>
    </div>

    {{-- Riwayat Selesai --}}
    <div class="bg-gradient-to-r from-green-400 to-emerald-500 text-white rounded-2xl shadow-lg p-6 hover:scale-105 transition duration-300 relative overflow-hidden">
        <div class="absolute -top-4 -right-4 opacity-20 text-6xl">✅</div>
        <h2 class="text-sm">Selesai</h2>
        <p class="text-3xl font-bold mt-2">12</p>
    </div>

    {{-- Barang Bermasalah --}}
    <div class="bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-2xl shadow-lg p-6 hover:scale-105 transition duration-300 relative overflow-hidden">
        <div class="absolute -top-4 -right-4 opacity-20 text-6xl">⚠️</div>
        <h2 class="text-sm">Barang Bermasalah</h2>
        <p class="text-3xl font-bold mt-2">1</p>
    </div>

</div>

{{-- Reminder & Aktivitas --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">

    {{-- Reminder --}}
    <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="text-gray-700 font-semibold mb-4">📅 Pengembalian Terdekat</h2>
        <div class="flex justify-between items-center border-b pb-3 mb-3">
            <div>
                <p class="font-medium text-gray-800">Proyektor Epson</p>
                <p class="text-sm text-gray-500">Jatuh tempo: 15 Feb 2026</p>
            </div>
            <span class="bg-red-100 text-red-600 text-xs px-3 py-1 rounded-full">
                2 Hari Lagi
            </span>
        </div>

        <div class="flex justify-between items-center">
            <div>
                <p class="font-medium text-gray-800">Kamera Canon</p>
                <p class="text-sm text-gray-500">Jatuh tempo: 18 Feb 2026</p>
            </div>
            <span class="bg-yellow-100 text-yellow-600 text-xs px-3 py-1 rounded-full">
                5 Hari Lagi
            </span>
        </div>
    </div>

    {{-- Aktivitas Terakhir --}}
    <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="text-gray-700 font-semibold mb-4">🕒 Aktivitas Terakhir</h2>

        <ul class="space-y-3 text-sm">
            <li class="flex justify-between">
                <span class="text-gray-600">Mengajukan peminjaman Laptop</span>
                <span class="text-gray-400">2 jam lalu</span>
            </li>

            <li class="flex justify-between">
                <span class="text-gray-600">Mengembalikan Proyektor</span>
                <span class="text-gray-400">1 hari lalu</span>
            </li>

            <li class="flex justify-between">
                <span class="text-gray-600">Peminjaman disetujui Admin</span>
                <span class="text-gray-400">3 hari lalu</span>
            </li>
        </ul>
    </div>

</div>

@endsection
