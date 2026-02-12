<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Peminjaman</title>

    <style>
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .sub-title {
            text-align: center;
            margin-bottom: 20px;
            font-size: 13px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background: #f2f2f2;
        }

        table,
        th,
        td {
            border: 1px solid #ccc;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 11px;
        }
    </style>
</head>

<body>

    <h2>LAPORAN PEMINJAMAN ALAT</h2>
    <div class="sub-title">
        ARSA - Aplikasi Rekapitulasi Sarana Alat
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Nama Alat</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($peminjaman as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->user->name ?? '-' }}</td>
                    <td>
                        @foreach ($item->detail as $detail)
                            {{ $detail->alat->nama_alat ?? '-' }} <br>
                        @endforeach
                    </td>
                    <td>{{ $item->tanggal_pengajuan }}</td>
                    <td>{{ $item->pengembalian->tanggal_pengembalian_sebenarnya ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ date('d M Y') }}
    </div>

</body>

</html>
