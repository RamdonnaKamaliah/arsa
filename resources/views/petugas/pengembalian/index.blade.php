@extends('layouts.petugas')

@section('title', 'Pengembalian Alat')

@section('content')

    <h1 class="text-2xl font-bold mb-6">Daftar Pengembalian</h1>

    <div class="space-y-4">

        @forelse($pengembalian as $p)
            <div class="bg-white shadow rounded-2xl p-5 flex justify-between items-center">

                {{-- Info --}}
                <div>
                    <h2 class="font-bold text-lg">
                        {{ $p->user->name }}
                    </h2>

                    <p class="text-sm text-gray-500">
                        Pengambilan: {{ $p->tanggal_pengambilan_sebenarnya }}
                    </p>

                    <p class="text-sm text-gray-500">
                        Rencana Kembali: {{ $p->tanggal_pengembalian_rencana }}
                    </p>

                    @if (now()->gt($p->tanggal_pengembalian_rencana))
                        <span class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full">
                            TERLAMBAT
                        </span>
                    @endif
                </div>

                {{-- Button --}}
                <button onclick="openReturnModal({{ $p->id }})"
                    class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700">
                    Scan & Kembalikan
                </button>

            </div>
        @empty
            <div class="text-gray-500 text-center py-10">
                Tidak ada data pengembalian
            </div>
        @endforelse

    </div>


    {{-- Modal Pengembalian --}}
    <div id="returnModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

        <div class="bg-white w-96 rounded-2xl p-6 relative">

            <button onclick="closeReturnModal()" class="absolute top-3 right-3 text-gray-500 hover:text-black">
                ✕
            </button>

            <h2 class="text-lg font-bold mb-4 text-center">
                Verifikasi Pengembalian
            </h2>

            {{-- Scan Section --}}
            <div id="reader" class="w-72 mx-auto mb-4"></div>

            <form method="POST" action="#" class="space-y-3">
                @csrf

                <input type="hidden" name="peminjaman_id" id="return_peminjaman_id">
                <input type="hidden" name="qr_result" id="qr_result">

                <div>
                    <label class="text-sm">Kondisi Alat</label>
                    <select name="kondisi_kembali" class="w-full border rounded-lg p-2 mt-1">
                        <option value="baik">Baik</option>
                        <option value="rusak">Rusak</option>
                        <option value="hilang">Hilang</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm">Catatan (opsional)</label>
                    <textarea name="catatan" class="w-full border rounded-lg p-2 mt-1" rows="2"></textarea>
                </div>

                <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-xl hover:bg-green-700">
                    Konfirmasi Pengembalian
                </button>
            </form>

        </div>
    </div>


    <script src="https://unpkg.com/html5-qrcode"></script>

    <script>
        let html5QrCode;

        function openReturnModal(id) {
            document.getElementById('returnModal').classList.remove('hidden');
            document.getElementById('returnModal').classList.add('flex');
            document.getElementById('return_peminjaman_id').value = id;

            html5QrCode = new Html5Qrcode("reader");

            html5QrCode.start({
                    facingMode: "environment"
                }, {
                    fps: 10,
                    qrbox: 220
                },
                qrCodeMessage => {
                    document.getElementById('qr_result').value = qrCodeMessage;
                    html5QrCode.stop();
                }
            );
        }

        function closeReturnModal() {
            if (html5QrCode) html5QrCode.stop();
            document.getElementById('returnModal').classList.add('hidden');
            document.getElementById('returnModal').classList.remove('flex');
        }
    </script>

@endsection
