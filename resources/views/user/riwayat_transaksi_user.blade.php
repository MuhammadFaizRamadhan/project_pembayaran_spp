<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Transaksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

<div class="flex min-h-screen">
    @include('components.sidebar_user')

    <main class="flex-1 ml-64 p-8">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Riwayat Transaksi Anda</h1>

        {{-- Flash Message --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        {{-- Tabel Riwayat --}}
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            {{-- Filter Form --}}
            <form method="GET" action="{{ route('riwayat.index') }}" class="mb-6 flex gap-4 items-end p-3">
                <div>
                    <label for="bulan" class="block text-gray-700">Bulan</label>
                    <select name="bulan" id="bulan" class="border rounded p-2">
                        <option value="">-- Semua Bulan --</option>
                        @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $bln)
                            <option value="{{ $bln }}" {{ request('bulan') == $bln ? 'selected' : '' }}>{{ $bln }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="tahun" class="block text-gray-700">Tahun</label>
                    <select name="tahun" id="tahun" class="border rounded p-2">
                        <option value="">-- Semua Tahun --</option>
                        @for($y = now()->year; $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Filter</button>
                </div>
            </form>

            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Bulan</th>
                        <th class="px-4 py-3">Tahun</th>
                        <th class="px-4 py-3">Tagihan</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tagihans as $tagihan)
                        @if($tagihan->status === 'lunas')
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-3 text-center">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 text-center">{{ $user->nama }}</td>
                                <td class="px-4 py-3 text-center">{{ $tagihan->bulan }}</td>
                                <td class="px-4 py-3 text-center">{{ $tagihan->tahun }}</td>
                                <td class="px-4 py-3 text-center">Rp {{ number_format($tagihan->tagihan, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-center capitalize">{{ $tagihan->status }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if($tagihan->transaksi && $tagihan->transaksi->bukti_bayar)
                                        <a href="{{ asset('storage/' . $tagihan->transaksi->bukti_bayar) }}" target="_blank" class="bg-blue-500 text-white hover:text-blue-900 p-2 rounded">Lihat Bukti</a>
                                    @else
                                        <span class="text-gray-500 italic">Tidak tersedia</span>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-500">Belum ada transaksi lunas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</div>

</body>
</html>
