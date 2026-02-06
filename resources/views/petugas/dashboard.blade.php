@extends('layouts.petugas')
@section('title', 'dashboard petugas')

@section('content')

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-gray-600 text-sm">Total User</h2>
            <p class="text-3xl font-bold text-gray-800 mt-2">120</p>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-gray-600 text-sm">Total Alat</h2>
            <p class="text-3xl font-bold text-gray-800 mt-2">45</p>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-gray-600 text-sm">Peminjaman Aktif</h2>
            <p class="text-3xl font-bold text-gray-800 mt-2">8</p>
        </div>

    </div>
@endsection
