<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rekap Pembayaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

<div class="flex min-h-screen">
    @include('components.sidebar_admin')

    <main class="flex-1 ml-64 p-8">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Rekap Pembayaran Siswa</h1>

        <form method="GET" action="{{ route('admin.rekap_pembayaran') }}" class="mb-4 flex flex-wrap items-center gap-4">
            <select name="bulan" class="border border-gray-300 px-3 py-2 rounded">
                <option value="">Pilih Bulan</option>
                @foreach($bulanList as $b)
                    <option value="{{ $b }}" {{ request('bulan') == $b ? 'selected' : '' }}>{{ $b }}</option>
                @endforeach
            </select>

            <select name="tahun" class="border border-gray-300 px-3 py-2 rounded">
                <option value="">Pilih Tahun</option>
                @php
                    $currentYear = date('Y');
                    for ($year = $currentYear; $year >= 2020; $year--) {
                        echo "<option value='$year'" . (request('tahun') == $year ? ' selected' : '') . ">$year</option>";
                    }
                @endphp
            </select>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Filter</button>

            <a href="{{ route('admin.rekap_pembayaran.pdf', ['bulan' => request('bulan'), 'tahun' => request('tahun')]) }}"
            class="ml-auto bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                Export PDF
            </a>
        </form>

        {{-- TABEL 2: Rekap Per Siswa --}}
        <div class="overflow-x-auto bg-white p-6 rounded shadow-md">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Detail Pembayaran per Siswa</h2>
            <table class="min-w-full text-sm text-gray-700 border">
                <thead class="bg-gray-200 text-gray-700 text-xs uppercase">
                    <tr>
                        <th class="px-4 py-2 border text-left">Nama</th>
                        @foreach($bulanList as $bulan)
                            <th class="px-4 py-2 border text-center">{{ $bulan }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($rekapSiswa as $nama => $pembayaran)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $nama }}</td>
                            @foreach($bulanList as $bulan)
                                <td class="px-4 py-2 border text-center text-red-600">
                                    {{ $pembayaran[$bulan] ? $pembayaran[$bulan] . '.00' : '' }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{-- TABEL 1: Rekap Total per Bulan --}}
        <div class="overflow-x-auto bg-white p-6 rounded shadow-md mb-10">
            <table class="min-w-full text-sm text-gray-700 border">
                <thead class="bg-gray-200 text-gray-700 text-xs uppercase">
                    <tr>
                        <th class="px-4 py-2 border">Bulan</th>
                        <th class="px-4 py-2 border">Tahun</th>
                        <th class="px-4 py-2 border">Jumlah Siswa</th>
                        <th class="px-4 py-2 border text-green-700">Sudah Lunas</th>
                        <th class="px-4 py-2 border text-red-700">Belum Dibayar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rekap as $item)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $item->bulan }}</td>
                            <td class="px-4 py-2 border">{{ $item->tahun }}</td>
                            <td class="px-4 py-2 border text-center">{{ $item->total }}</td>
                            <td class="px-4 py-2 border text-center text-green-600">{{ $item->lunas }}</td>
                            <td class="px-4 py-2 border text-center text-red-600">{{ $item->belum_dibayar }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </main>
</div>

</body>
</html>
