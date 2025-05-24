<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Transaksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 font-sans antialiased" x-data="{ openModal: null }">

<div class="flex min-h-screen">
    @include('components.sidebar_admin')

    <main class="flex-1  ml-64 p-8">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Riwayat Transaksi</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <!-- Filter & Search -->
            <div class="bg-white p-4 rounded shadow mb-6">
                <form method="GET" action="{{ route('admin.riwayat_transaksi') }}" class="flex flex-wrap gap-4 items-end">
                    <div>
                        <label class="block text-sm text-gray-600">Nama Siswa</label>
                        <input type="text" name="nama" value="{{ request('nama') }}" class="border border-gray-300 rounded px-3 py-2" placeholder="Cari nama siswa...">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600">Bulan</label>
                        <select name="bulan" class="border border-gray-300 rounded px-3 py-2">
                            <option value="">Semua</option>
                            @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $bln)
                                <option value="{{ $bln }}" {{ request('bulan') == $bln ? 'selected' : '' }}>{{ $bln }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600">Tahun</label>
                        <input type="number" name="tahun" value="{{ request('tahun') }}" class="border border-gray-300 rounded px-3 py-2" placeholder="2024">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600">Status</label>
                        <select name="status" class="border border-gray-300 rounded px-3 py-2">
                            <option value="">Semua</option>
                            <option value="belum dibayar" {{ request('status') == 'belum dibayar' ? 'selected' : '' }}>Belum Dibayar</option>
                            <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                        </select>
                    </div>

                    <div>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mt-1">Filter</button>
                    </div>
                </form>
            </div>

            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Admin</th>
                        <th class="px-4 py-3">Nama Siswa</th>
                        <th class="px-4 py-3">Bulan</th>
                        <th class="px-4 py-3">Tahun</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Bukti Bayar</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $item)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-3 text-center">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 text-center">{{ $item->admin->nama }}</td>
                            <td class="px-4 py-3 text-center">{{ $item->siswa->nama }}</td>
                            <td class="px-4 py-3 text-center">{{ $item->dataPembayaran->bulan ?? '-' }}</td>
                            <td class="px-4 py-3 text-center">{{ $item->dataPembayaran->tahun ?? '-' }}</td>
                            <td class="px-4 py-3 text-center capitalize">{{ $item->dataPembayaran->status ?? '-' }}</td>
                            <td class="px-4 py-3 text-center">
                                @if($item->bukti_bayar)
                                    <a href="{{ asset('storage/' . $item->bukti_bayar) }}" target="_blank" class="bg-blue-500 text-white hover:text-blue-900 p-2 rounded">Lihat Bukti</a>
                                @else
                                    <span class="text-gray-500 italic">Tidak tersedia</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($item->dataPembayaran->status !== 'lunas')
                                    <button @click="openModal = {{ $item->id }}" class="bg-blue-500 text-white hover:text-blue-900 p-2 rounded px-3 py-1 text-sm">Edit</button>

                                    <!-- Modal -->
                                    <div x-show="openModal === {{ $item->id }}" x-cloak class="fixed z-50 inset-0 flex items-center justify-center bg-black bg-opacity-50">
                                        <div class="bg-white p-6 rounded shadow-md w-full max-w-sm" @click.away="openModal = null">
                                            <h2 class="text-lg font-semibold mb-4">Edit Status Pembayaran</h2>
                                            <form method="POST" action="{{ route('admin.riwayat_transaksi.updateStatus', $item->dataPembayaran->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-4">
                                                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                                    <select name="status" class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">
                                                        <option value="belum dibayar" {{ $item->dataPembayaran->status == 'belum dibayar' ? 'selected' : '' }}>Belum Dibayar</option>
                                                        <option value="lunas" {{ $item->dataPembayaran->status == 'lunas' ? 'selected' : '' }}>Lunas</option>
                                                    </select>
                                                </div>
                                                <div class="flex justify-end gap-2">
                                                    <button type="button" @click="openModal = null" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-gray-500">Belum ada transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</div>

</body>
</html>
