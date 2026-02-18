@extends('layouts.admin')

@section('title', 'edit data alat')

@section('content')
    <div class="pt-1">
        <div class="flex justify-center items-center min-h-[80vh] py-6 px-4">
            <div class="w-full max-w-5xl min-h-100 bg-white dark:bg-slate-800 p-6 rounded-lg shadow-lg">
                <div class="mb-4">
                    <a href="{{ route('admin.data-alat.index') }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </a>
                </div>

                {{-- @include('components.alert') --}}

                <!-- Judul -->
                <h2 class="text-center text-2xl font-bold text-gray-800 mb-6 dark:text-white">Edit Data Alat</h2>

                <!-- Form -->
                <form action="{{ route('admin.data-alat.update', $alat->id) }}" method="POST" id="editForm"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label for="nama_alat" class="block text-gray-700 font-semibold mb-2 dark:text-gray-300">Nama
                            Alat</label>
                        <input type="text" id="nama_alat" name="nama_alat" placeholder="Input nama Alat"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition"
                            value="{{ old('nama_alat', $alat->nama_alat) }}">
                        @error('nama_alat')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">

                        <label for="id_kategori" class="block text-gray-700 font-semibold mb-2 dark:text-gray-300">Kategori
                            Alat</label>
                        <select id="id_kategori" name="id_kategori"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition">
                            <option value="{{ old('id_kategori') }}">Pilih Kategori</option>
                            @foreach ($kategori as $kategori)
                                <option value="{{ $kategori->id }}"
                                    {{ old('id_kategori', $alat->id_kategori) == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('id_kategori')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="mb-4">
                        <label for="stok" class="block text-gray-700 font-semibold mb-2 dark:text-gray-300">Stok
                            Alat</label>
                        <input type="number" id="stok" name="stok" placeholder="Input stok Alat"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition"
                            value="{{ old('stok', $alat->stok) }}">
                        @error('stok')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="foto_alat" class="block text-gray-700 font-semibold mb-2 dark:text-gray-300">
                            Foto Alat</label>
                            @if ($alat->foto_alat)
                                <div class="mb-2">
                                    <p class="text-gray-500 text-sm mb-2">Foto alat saat ini</p>
                                    <img src="{{ asset('storage/' . $alat->foto_alat) }}" alt="foto_alat" 
                                    class="aspect-4/3 object-cover rounded-lg border-gray-200 border-2 border-dashed">
                                </div>
                            @endif
                        
                        <p class="text-gray-500 text-sm mb-2">Pilih untuk mengganti foto</p>
                        <input type="file" id="foto_alat" name="foto_alat"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition">
                        @error('foto_alat')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Tombol Submit -->
                    <div class="pt-6">
                        <button type="submit"
                            class="w-full bg-primary text-white py-3 rounded-lg hover:bg-secondary transition cursor-pointer ">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
