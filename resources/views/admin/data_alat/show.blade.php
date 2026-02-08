@extends('layouts.admin')

@section('title', 'Detail Data Alat')

@section('content')
<div class="pt-6 px-4 flex justify-center">

    <div class="w-full max-w-4xl bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-8">

        {{-- Tombol Back --}}
        <div class="mb-6">
            <a href="{{ route('admin.data-alat.index') }}"
               class="text-blue-600 hover:text-blue-800 font-semibold flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        {{-- Judul --}}
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6 text-center">
            Detail Data Alat
        </h2>

        {{-- Card Detail --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Foto --}}
            <div class="flex justify-center items-center">
                @if ($alat->foto_alat)
                    <img src="{{ asset('storage/' . $alat->foto_alat) }}"
                         alt="Foto Alat"
                         class="w-72 h-72 object-cover rounded-xl shadow-md">
                @else
                    <div class="w-72 h-72 flex items-center justify-center bg-gray-200 rounded-xl">
                        <span class="text-gray-500">Tidak ada foto</span>
                    </div>
                @endif
            </div>

            {{-- Informasi --}}
            <div class="space-y-4">

                <div>
                    <p class="text-gray-500 text-sm">Nama Alat</p>
                    <p class="text-lg font-semibold text-gray-800 dark:text-white">
                        {{ $alat->nama_alat }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500 text-sm">Kategori</p>
                    <p class="text-lg font-semibold text-gray-800 dark:text-white">
                        {{ $alat->kategori->nama_kategori ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500 text-sm">Stok</p>
                    <p class="text-lg font-semibold text-gray-800 dark:text-white">
                        {{ $alat->stok }}
                    </p>
                </div>

                {{-- Tombol Aksi --}}
                <div class="pt-4 flex gap-3">
                    <a href="{{ route('admin.data-alat.edit', $alat->id) }}"
                       class="px-5 py-2 rounded-lg bg-yellow-500 (text-white) hover:bg-yellow-600 transition">
                        Edit
                    </a>

                    <a href="{{ route('admin.data-alat.index') }}"
                       class="px-5 py-2 rounded-lg bg-gray-500 text-white hover:bg-gray-600 transition">
                        Kembali
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
