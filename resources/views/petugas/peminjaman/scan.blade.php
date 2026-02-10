@extends('layouts.petugas')

@section('title', 'Scan QR Peminjaman')

@section('content')
    <h1 class="text-xl font-bold mb-4">Scan QR Peminjaman</h1>

    <div id="reader" class="w-80 mx-auto"></div>

    <form id="scanForm" action="{{ route('petugas.peminjaman.scan.verify') }}" method="POST">
        @csrf
        <input type="hidden" name="qr_result" id="qr_result">
        <input type="hidden" name="peminjaman_id" value="{{ $peminjaman->id }}">
    </form>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        const html5QrCode = new Html5Qrcode("reader");

        html5QrCode.start({
                facingMode: "environment"
            }, {
                fps: 10,
                qrbox: 250
            },
            qrCodeMessage => {
                document.getElementById('qr_result').value = qrCodeMessage;
                html5QrCode.stop();
                document.getElementById('scanForm').submit();
            }
        );
    </script>
@endsection
