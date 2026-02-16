@extends('layouts.admin')

@section('title', 'lihat akun pengguna')

@section('content')

    <div class="w-full p-2 min-h-screen">
        <div class="bg-white shadow-xl rounded-2xl p-8 mx-auto">

            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('admin.akun-pengguna.index') }}"
                    class="inline-flex items-center text-blue-600 hover:text-blue-800 transition">
                    <i class="fas fa-arrow-left mr-2 text-lg"></i> 
                </a>
            </div>

            <!-- Header -->
            <div class="text-center mb-10">
                <div
                    class="w-20 h-20 mx-auto rounded-full bg-blue-100 flex items-center justify-center text-3xl font-bold text-blue-600">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h1 class="font-bold text-2xl text-gray-700 mt-4">
                    {{ $user->name }}
                </h1>
                <p class="text-gray-400 text-sm">{{ $user->email }}</p>
            </div>

            <!-- Detail Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- LEFT -->
                <div class="space-y-5">

                    <div class="bg-gray-50 rounded-xl p-4 shadow-sm">
                        <p class="text-gray-400 text-sm">Nama</p>
                        <p class="font-semibold text-gray-700 text-lg">{{ $user->name }}</p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 shadow-sm">
                        <p class="text-gray-400 text-sm">Email</p>
                        <p class="font-semibold text-gray-700 text-lg">{{ $user->email }}</p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 shadow-sm">
                        <p class="text-gray-400 text-sm">Role</p>
                        <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-600 font-semibold">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>

                </div>

                <!-- RIGHT -->
                <div class="space-y-5">

                    <div class="bg-gray-50 rounded-xl p-4 shadow-sm">
                        <p class="text-gray-400 text-sm">Status Blokir</p>

                        @if ($user->status_blokir == 'blokir')
                            <span class="px-3 py-1 text-sm rounded-full bg-red-100 text-red-600 font-semibold">
                                Diblokir
                            </span>
                        @else
                            <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-600 font-semibold">
                                Aktif
                            </span>
                        @endif
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 shadow-sm">
                        <p class="text-gray-400 text-sm">Masa Blokir</p>
                        <p class="font-semibold text-gray-700">
                            {{ $user->masa_blokir ?? '-' }}
                        </p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 shadow-sm">
                        <p class="text-gray-400 text-sm">Alasan Blokir</p>
                        <p class="font-semibold text-gray-700">
                            {{ $user->alasan_blokir ?? '-' }}
                        </p>
                    </div>

                </div>

            </div>

        </div>
    </div>

@endsection
