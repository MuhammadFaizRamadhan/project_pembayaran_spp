<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

<div class="flex min-h-screen">
    <!-- Sidebar -->
    @include('components.sidebar_admin')

    <!-- Main Content -->
    <main class="flex-1 ml-64 p-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">Hi, {{ $admin->nama }}</h2>
                <p class="text-sm text-gray-500">Senin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            </div>
            <a href="{{ route('admin.profile') }}">
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 bg-purple-600 text-white rounded-full flex items-center justify-center text-lg font-bold">
                    {{ strtoupper(substr($admin->nama, 0, 2)) }}
                </div>
                <span>{{ $admin->nama }}</span>
            </div>
            </a>
        </div>
        <!-- Banner dengan Gambar dan Teks -->
        <div class="relative mb-8 rounded-xl overflow-hidden shadow">
            <img src="{{ asset('images/banner_smam_3_bungah.jpg') }}" alt="Banner Sekolah" class="w-full h-64 object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                <h2 class="text-white text-3xl md:text-4xl font-bold">SMA MUHAMMADIYAH 3 BUNGAH</h2>
            </div>
        </div>
        <!-- Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-yellow-400 text-white p-6 rounded-xl shadow text-center">
                <div class="text-lg font-semibold">{{ $totalSiswa }}</div>
                <div class="text-sm">Total Siswa</div>
            </div>
            <div class="bg-purple-600 text-white p-6 rounded-xl shadow text-center">
                <div class="text-lg font-semibold">{{ $totalLunas }}</div>
                <div class="text-sm">Total Pembayaran Lunas</div>
            </div>
            <div class="bg-pink-400 text-white p-6 rounded-xl shadow text-center">
                <div class="text-lg font-semibold">{{ $totalBelumBayar }}</div>
                <div class="text-sm">Total Pembayaran Belum Dibayar</div>
            </div>
            <div class="bg-blue-300 text-white p-6 rounded-xl shadow text-center">
                <div class="text-lg font-semibold">{{ $totalTransaksi }}</div>
                <div class="text-sm">Total Transaksi</div>
            </div>
        </div>

        <!-- Info Box -->
        <div class="bg-white p-6 rounded-xl shadow mb-10">
            <h3 class="text-xl font-semibold mb-2 text-gray-800">Informasi Admin</h3>
            <p><strong>NIP:</strong> {{ $admin->NIP }}</p>
            <p><strong>Email:</strong> {{ $admin->email }}</p>
            <p><strong>Alamat:</strong> {{ $admin->alamat }}</p>
        </div>

        <!-- Tabel Riwayat Transaksi -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-xl font-semibold mb-4 text-gray-800">Riwayat Transaksi</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-gray-700">
                    <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Nama Siswa</th>
                            <th class="px-4 py-3">Bulan</th>
                            <th class="px-4 py-3">Tahun</th>
                            <th class="px-4 py-3">Tagihan</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Bukti Bayar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksis as $transaksi)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-3 text-center">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 text-center">{{ $transaksi->siswa->nama }}</td>
                                <td class="px-4 py-3 text-center">{{ $transaksi->dataPembayaran->bulan ?? '-' }}</td>
                                <td class="px-4 py-3 text-center">{{ $transaksi->dataPembayaran->tahun ?? '-' }}</td>
                                <td class="px-4 py-3 text-center">Rp {{ number_format($transaksi->dataPembayaran->tagihan ?? 0, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-center capitalize">{{ $transaksi->dataPembayaran->status ?? '-' }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if($transaksi->bukti_bayar)
                                        <a href="{{ asset('storage/' . $transaksi->bukti_bayar) }}" target="_blank" class="bg-blue-500 text-white hover:text-blue-900 p-2 rounded">Lihat Bukti</a>
                                    @else
                                        <span class="text-gray-500 italic">Tidak tersedia</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-gray-500">Belum ada transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

</body>
</html>
