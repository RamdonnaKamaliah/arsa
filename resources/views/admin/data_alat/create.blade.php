@extends('layouts.admin')

@section('title', 'create data alat')

@section('content')

    <div class="pt-1">
        <div class="flex justify-center items-center min-h-[80vh] py-6 px-4">
            <div class="w-full max-w-5xl min-h-100 bg-white dark:bg-slate-800 p-6 rounded-lg shadow-lg">
                <div class="mb-4">
                    <a href="{{ route('admin.data-alat.index') }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </a>
                </div>


                <!-- Judul -->
                <h2 class="text-center text-2xl font-bold text-gray-800 mb-6 dark:text-white">Create Data Alat</h2>

                <!-- Form -->
                <form action="{{ route('admin.data-alat.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Input Nama alat -->
                    <div class="pt-10 mb-4">
                        <label for="nama_alat" class="block text-gray-700 font-semibold mb-2 dark:text-gray-300">
                            Nama Alat<span class="text-red-500">*</span>
                        </label>

                        <input type="text" id="nama_alat" name="nama_alat" placeholder="Input nama alat"
                            value="{{ old('nama_alat') }}" @class([
                                'w-full p-3 rounded-lg transition',
                                'border border-red-500 focus:ring-red-400 focus:border-red-500' => $errors->has(
                                    'nama_alat'),
                                'border border-gray-300 focus:ring-blue-400 focus:border-blue-500' => !$errors->has(
                                    'nama_alat'),
                            ])>
                        @error('nama_alat')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                    </div>
                    
                    <!-- Input Kategori -->
                    <div class="pt-10 mb-4">
                        <label for="id_kategori" class="block text-gray-700 font-semibold mb-2 dark:text-gray-300">
                            Kategori Alat<span class="text-red-500">*</span>
                        </label>

                        <select name="id_kategori" id="id_kategori"
                            @class([
                                'w-full p-3 rounded-lg transition',
                                'border border-red-500 focus:ring-red-400 focus:border-red-500' => $errors->has(
                                    'id_kategori'),
                                'border border-gray-300 focus:ring-blue-400 focus:border-blue-500' => !$errors->has(
                                    'id_kategori'),
                            ])>
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategori as $item)
                                <option value="{{ $item->id }}" {{ old('id_kategori') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_kategori')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Input Stok -->
                    <div class="pt-10 mb-4">
                        <label for="stok" class="block text-gray-700 font-semibold mb-2 dark:text-gray-300">
                            Stok<span class="text-red-500">*</span>
                        </label>

                        <input type="number" id="stok" name="stok" placeholder="Input stok"
                            value="{{ old('stok') }}" @class([
                                'w-full p-3 rounded-lg transition',
                                'border border-red-500 focus:ring-red-400 focus:border-red-500' => $errors->has(
                                    'stok'),
                                'border border-gray-300 focus:ring-blue-400 focus:border-blue-500' => !$errors->has(
                                    'stok'),
                            ])>
                        @error('stok')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Input Foto -->
                    <div class="pt-1 mb-4">
                        <label for="foto_alat" class="block text-gray-700 font-semibold mb-2 dark:text-gray-300">
                            Foto Alat
                        </label>

                        <input type="file" id="foto_alat" name="foto_alat"
                            @class([
                                'w-full p-3 rounded-lg transition',
                                'border border-red-500 focus:ring-red-400 focus:border-red-50  ert' => $errors->has(
                                    'foto_alat'),
                                'border border-gray-30  ert focus:ring-blue   ert focus:border-blue   ert' => !$errors->has(
                                    'foto_alat'),
                            ])>
                        @error('foto_alat')
                            <p class="text-red   ert text-sm mt   ert">{{ $message }}</p>
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
