<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tagihan Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

<div class="flex min-h-screen">
    @include('components.sidebar_user')

    <main class="flex-1 ml-64 p-8">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Tagihan Anda</h1>

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

        {{-- Tabel Tagihan --}}
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            {{-- Filter Form --}}
        <form method="GET" action="{{ route('tagihan.index') }}" class="mb-6 flex gap-4 items-end p-3">
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
                    @php $no = 1; @endphp
                    @forelse($tagihans as $tagihan)
                        @if($tagihan->status !== 'lunas')
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-3 text-center">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 text-center">{{ $user->nama }}</td>
                                <td class="px-4 py-3 text-center">{{ $tagihan->bulan }}</td>
                                <td class="px-4 py-3 text-center">{{ $tagihan->tahun }}</td>
                                <td class="px-4 py-3 text-center">Rp {{ number_format($tagihan->tagihan, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-center capitalize">{{ $tagihan->status }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if($tagihan->status === 'belum dibayar')
                                        <button onclick="openBayarModal({{ $tagihan->id }}, '{{ $tagihan->tagihan }}')" class="bg-green-500 text-white hover:text-green-900 p-2 rounded">Bayar</button>
                                    @elseif($tagihan->status === 'proses')
                                        @if($tagihan->transaksi && $tagihan->transaksi->bukti_bayar)
                                            <a href="{{ asset('storage/' . $tagihan->transaksi->bukti_bayar) }}" target="_blank" class="bg-blue-500 text-white hover:text-blue-900 p-2 rounded">Lihat Bukti</a>
                                        @else
                                            <span class="text-gray-500 italic">Menunggu verifikasi</span>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-500">Tidak ada tagihan untuk periode ini.</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </main>

</div>

<!-- Modal Bayar -->
<div id="modalBayar" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
        <h2 class="text-xl font-semibold mb-4">Form Pembayaran</h2>
        <form id="bayarForm" method="POST" action="{{ route('tagihan.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_data_pembayaran" id="modal_tagihan_id">
            <input type="hidden" name="tgl_transaksi" value="{{ now()->toDateString() }}">

            <div class="mb-4">
                <label class="block text-gray-700">Total Pembayaran</label>
                <input type="number" name="total_pembayaran" id="modal_total_pembayaran" class="w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Upload Bukti Bayar</label>
                <input type="file" name="bukti_bayar" accept=".jpg,.png,.pdf" class="w-full border rounded p-2" required>
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeBayarModal()" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Kirim</button>
            </div>
        </form>
        <button onclick="closeBayarModal()" class="absolute top-2 right-3 text-xl">&times;</button>
    </div>
</div>

<script>
    function openBayarModal(tagihanId, totalTagihan) {
        document.getElementById('modal_tagihan_id').value = tagihanId;
        document.getElementById('modal_total_pembayaran').value = totalTagihan;
        document.getElementById('modalBayar').classList.remove('hidden');
    }

    function closeBayarModal() {
        document.getElementById('modalBayar').classList.add('hidden');
    }
</script>
</body>
</html>
