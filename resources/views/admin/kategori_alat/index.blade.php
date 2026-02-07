@extends('layouts.admin')

@section('title', 'kategori alat')

@section('content')

    <div class="p-4 md:p-6 overflow-x-hidden pt-28">
        <div class="bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 p-4 rounded-lg shadow-md dark:shadow-lg">
            <h2 class="text-center text-xl font-bold mb-4 text-gray-800 dark:text-white">Kategori Management</h2>
            <div class="flex flex-wrap justify-end gap-2">
                <a href="{{ route('admin.kategorialat.create') }}">
                    <button
                        class="bg-blue-500 text-white cursor-pointer px-3 py-1.5 text-sm md:px-4 md:py-2 md:text-base rounded-md hover:bg-blue-600">
                        Create Data
                    </button>
                </a>
            </div>
            {{-- ini nanti di ganti aja ya --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="overflow-x-auto mt-4">
                <table id="datatable" class="w-full border border-gray-300 text-xs md:text-sm dark:border-gray-600">
                    <thead class="bg-gray-200 text-gray-800 dark:bg-slate-700 dark:text-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-2 py-1 md:px-4 md:py-2">Nama Kategori</th>
                            <th class="border border-gray-300 px-2 py-1 md:px-4 md:py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($category as $row)
                            <tr>
                                <td class="border border-gray-300 px-2 py-1 md:px-4 md:py-2">{{ $row->name_kategori }}</td>
                                <td class="border border-gray-300 px-2 py-1 md:px-4 md:py-2 text-center">
                                    <div class="flex justify-center space-x-1 md:space-x-2">
                                        <a href="{{ route('admin.kategori.edit', $row->slug) }}"
                                            class="px-2 py-1 text-yellow-600 border border-yellow-600 rounded-full hover:bg-yellow-100 flex items-center gap-1 text-xs md:text-sm">
                                            <i class="fas fa-edit"></i> <span class="hidden sm:inline">Edit</span>
                                        </a>

                                        <form action="{{ route('admin.kategori.destroy', $row->slug) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class=" px-2 py-1 cursor-pointer text-red-600 border border-red-600 rounded-full hover:bg-red-100 flex items-center gap-1"
                                                data-title="{{ $row->name_kategori }}">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#datatable').DataTable({
                    pageLength: 10,
                    lengthMenu: [5, 10, 25, 50],
                    ordering: true,
                    searching: true,
                    responsive: true,

                    dom: "<'flex flex-wrap justify-between items-center mb-4'<'flex items-center gap-2'l><'flex items-center gap-2'f>>" +
                        "<'overflow-x-auto't>" +
                        "<'flex flex-wrap justify-between items-center mt-4'<'text-sm'i><'pagination'p>>",

                    language: {
                        search: "",
                        searchPlaceholder: "Cari data...",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ – _END_ dari _TOTAL_ data",
                        paginate: {
                            previous: "←",
                            next: "→"
                        }
                    },

                    drawCallback: function() {
                        // style select
                        $('select').addClass(
                            'border border-gray-300 rounded-md px-2 py-1 text-sm focus:ring focus:ring-blue-300'
                        );

                        // style search input
                        $('input[type="search"]').addClass(
                            'border border-gray-300 rounded-md px-3 py-1 text-sm focus:ring focus:ring-blue-300'
                        );
                    }
                });
            });
        </script>
    @endpush

@endsection
