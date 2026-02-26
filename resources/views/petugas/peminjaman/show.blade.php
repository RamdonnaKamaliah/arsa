@extends('layouts.petugas')

@section('title', 'Detail Peminjaman')

@section('content')

    <div class="w-full p-2 min-h-screen">
        <div class="bg-white shadow-xl rounded-2xl p-8 mx-auto">

            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('petugas.peminjaman.index') }}"
                    class="inline-flex items-center text-blue-600 hover:text-blue-800 transition">
                    <i class="fas fa-arrow-left mr-2 text-lg"></i> Kembali
                </a>
            </div>

            <!-- Info Peminjaman -->
            <div class="mb-6 border-b pb-4">
                <h2 class="text-xl font-bold mb-2">Informasi Peminjaman</h2>
                {{-- <p><span class="font-semibold">Nama:</span> {{ $peminjaman->id_user>name }}</p> --}}
                <p><span class="font-semibold">Tanggal Ambil:</span> {{ $peminjaman->tanggal_pengambilan_rencana }}</p>
                <p><span class="font-semibold">Tanggal Kembali:</span> {{ $peminjaman->tanggal_pengembalian_rencana }}</p>
                <p>
                    <span class="font-semibold">Status:</span>
                    <span
                        class="px-2 py-1 rounded text-xs
                    @if ($peminjaman->status == 'pending') bg-yellow-100 text-yellow-700
                    @elseif($peminjaman->status == 'disetujui') bg-green-100 text-green-700
                    @elseif($peminjaman->status == 'dipinjam') bg-blue-100 text-blue-700
                    @elseif($peminjaman->status == 'epired') bg-blue-100 text-blue-700
                    @else bg-gray-100 text-gray-700 @endif">
                        {{ strtoupper($peminjaman->status) }}
                    </span>
                </p>
            </div>

            <!-- Daftar Alat -->
            <div>
                <h2 class="text-xl font-bold mb-4">Daftar Alat Dipinjam</h2>

                <div class="space-y-3">
                    @foreach ($peminjaman->detail as $detail)
                        <div class="flex justify-between items-center bg-gray-50 rounded-xl p-4">

                            <div>
                                <p class="font-semibold text-lg">
                                    {{ $detail->alat->nama_alat }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    Kode: {{ $detail->alat->kode_barang }} | Jumlah: {{ $detail->jumlah }}
                                </p>

                                @if ($detail->sudah_diambil)
                                    <span class="text-green-600 text-xs font-semibold">✔ Sudah diambil</span>
                                @else
                                    <span class="text-yellow-600 text-xs font-semibold">Menunggu pengambilan</span>
                                @endif
                            </div>

                            <!-- Tombol Scan -->
                            @if (!$detail->sudah_diambil && $peminjaman->status == 'disetujui')
                                <button onclick="openScanModal('{{ $peminjaman->id }}', '{{ $detail->alat->kode_barang }}')"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700">
                                    Scan QR
                                </button>

                            
                            @endif

                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <!-- Modal Scan -->
    <div id="scanModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 w-96 relative">

            <button onclick="closeScanModal()" class="absolute top-3 right-3 text-gray-500 hover:text-black">
                ✕
            </button>

            <h2 class="text-lg font-bold mb-4 text-center">
                Scan QR Barang
            </h2>

            <input type="hidden" id="peminjaman_id">
            <input type="hidden" id="kode_barang">

            <div id="reader" class="w-72 mx-auto mb-4"></div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        let html5QrCode;

        function openScanModal(peminjamanId, kodeBarang) {
            document.getElementById('scanModal').classList.remove('hidden');
            document.getElementById('scanModal').classList.add('flex');

            document.getElementById('peminjaman_id').value = peminjamanId;
            document.getElementById('kode_barang').value = kodeBarang;

            html5QrCode = new Html5Qrcode("reader");

            html5QrCode.start({
                    facingMode: "environment"
                }, {
                    fps: 10,
                    qrbox: 220
                },
                qrCodeMessage => {
                    html5QrCode.stop();
                    submitScan(qrCodeMessage);
                }
            );
        }

        function submitScan(result) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('petugas.peminjaman.scan.verify') }}";

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = "{{ csrf_token() }}";

            const pid = document.createElement('input');
            pid.type = 'hidden';
            pid.name = 'peminjaman_id';
            pid.value = document.getElementById('peminjaman_id').value;

            const qr = document.createElement('input');
            qr.type = 'hidden';
            qr.name = 'qr_result';
            qr.value = result;

            form.appendChild(csrf);
            form.appendChild(pid);
            form.appendChild(qr);

            document.body.appendChild(form);
            form.submit();
        }

        function closeScanModal() {
            if (html5QrCode) html5QrCode.stop();
            document.getElementById('scanModal').classList.add('hidden');
            document.getElementById('scanModal').classList.remove('flex');
        }
    </script>

@endsection
