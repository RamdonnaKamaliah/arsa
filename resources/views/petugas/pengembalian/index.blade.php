@extends('layouts.petugas')

@section('title', 'Pengembalian Alat')

@section('content')

    <h1 class="text-2xl font-bold mb-6">Daftar Pengembalian</h1>

    <div class="space-y-4">

        @forelse($pengembalian as $p)
            <div class="bg-white shadow rounded-2xl p-5 flex justify-between items-center">

                {{-- Info --}}
                <div>
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


    <div id="returnModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

        <div class="bg-white w-[420px] rounded-2xl p-6 relative shadow-xl">

            <button type="button" onclick="closeReturnModal()"
                class="absolute top-3 right-3 text-gray-500 hover:text-black text-lg">
                ✕
            </button>

            <h2 class="text-lg font-bold mb-4 text-center">
                Verifikasi Pengembalian
            </h2>

            {{-- ✅ FORM ACTION DIPERBAIKI --}}
            <form id="returnForm" method="POST" action="" enctype="multipart/form-data" class="space-y-4">

                @csrf

                <input type="hidden" name="peminjaman_id" id="return_peminjaman_id">
                <input type="hidden" name="qr_result" id="qr_result">

                {{-- ================= STEP 1 ================= --}}
                <div id="stepScan">

                    <div class="flex justify-center gap-2 mb-4">
                        <button type="button" onclick="showScan()"
                            class="px-3 py-1 bg-blue-600 text-white rounded-lg text-sm">
                            Scan
                        </button>

                        <button type="button" onclick="showUpload()" class="px-3 py-1 bg-gray-200 rounded-lg text-sm">
                            Upload
                        </button>
                    </div>

                    <div id="scanSection">
                        <div id="reader" class="w-72 mx-auto"></div>
                    </div>

                    <div id="uploadSection" class="hidden">
                        <input type="file" name="qr_file" accept="image/*" class="w-full border rounded-lg p-2 text-sm">
                    </div>

                    <button type="button" onclick="validateQR()"
                        class="w-full bg-blue-600 text-white py-2 rounded-xl mt-3">
                        Verifikasi QR
                    </button>

                </div>

                {{-- ================= STEP 2 ================= --}}
                <div id="stepForm" class="hidden">

                    <div class="bg-green-50 text-green-700 text-sm p-2 rounded-lg text-center">
                        QR Valid ✅
                    </div>

                    <div>
                        <label class="text-sm font-medium">Kondisi Alat</label>
                        <select name="kondisi_kembali" class="w-full border rounded-lg p-2 mt-1">
                            <option value="baik">Baik</option>
                            <option value="rusak">Rusak</option>
                            <option value="hilang">Hilang</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium">Catatan</label>
                        <textarea name="catatan" rows="2" class="w-full border rounded-lg p-2 mt-1" placeholder="Opsional..."></textarea>
                    </div>

                    <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-xl">
                        Konfirmasi Pengembalian
                    </button>

                </div>

            </form>
        </div>
    </div>



    <script src="https://unpkg.com/html5-qrcode"></script>

    <script>
        let html5QrCode;
        let scannedResult = null;

        function openReturnModal(id) {
            document.getElementById('returnModal').classList.remove('hidden');
            document.getElementById('returnModal').classList.add('flex');
            document.getElementById('return_peminjaman_id').value = id;

            // ✅ SET FORM ACTION SECARA DINAMIS
            document.getElementById('returnForm').action = `/petugas/pengembalian/verify/${id}`;

            resetModal();
        }

        function resetModal() {
            document.getElementById('stepScan').classList.remove('hidden');
            document.getElementById('stepForm').classList.add('hidden');
            document.getElementById('qr_result').value = '';
            scannedResult = null;
        }

        function closeReturnModal() {
            if (html5QrCode) {
                html5QrCode.stop().catch(err => console.log(err));
            }

            document.getElementById('returnModal').classList.add('hidden');
            document.getElementById('returnModal').classList.remove('flex');
        }

        function showScan() {
            document.getElementById('scanSection').classList.remove('hidden');
            document.getElementById('uploadSection').classList.add('hidden');

            html5QrCode = new Html5Qrcode("reader");

            html5QrCode.start({
                    facingMode: "environment"
                }, {
                    fps: 10,
                    qrbox: 220
                },
                (qrCodeMessage) => {
                    scannedResult = qrCodeMessage;
                    document.getElementById('qr_result').value = qrCodeMessage;
                    html5QrCode.stop();
                }
            );
        }

        function showUpload() {
            if (html5QrCode) html5QrCode.stop();

            document.getElementById('scanSection').classList.add('hidden');
            document.getElementById('uploadSection').classList.remove('hidden');
        }

        function validateQR() {
            if (!document.getElementById('qr_result').value &&
                !document.querySelector('input[name="qr_file"]').files.length) {

                alert("Scan atau upload QR terlebih dahulu!");
                return;
            }

            // tampilkan step form
            document.getElementById('stepScan').classList.add('hidden');
            document.getElementById('stepForm').classList.remove('hidden');
        }
    </script>



@endsection
