<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Pembayaran Siswa</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #999;
            padding: 6px 10px;
            text-align: center;
        }
        th {
            background-color: #e2e8f0;
        }
        .text-green {
            color: green;
        }
        .text-red {
            color: red;
        }
    </style>
</head>
<body>

    <h2>Rekap Pembayaran Siswa</h2>

    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Jumlah Siswa</th>
                <th class="text-green">Sudah Lunas</th>
                <th class="text-red">Belum Dibayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekap as $item)
                <tr>
                    <td>{{ $item->bulan }}</td>
                    <td>{{ $item->tahun }}</td>
                    <td>{{ $item->total }}</td>
                    <td class="text-green">{{ $item->lunas }}</td>
                    <td class="text-red">{{ $item->belum_dibayar }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
