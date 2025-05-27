<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard user</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

<div class="flex min-h-screen">
    <!-- Sidebar -->
    @include('components.sidebar_user')

    <!-- Main Content -->
    <main class="flex-1 p-10 ml-64 p-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">Hi, {{ $user->nama }}</h2>
                <p class="text-sm text-gray-500">Senin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            </div>
            <a href="{{ route('user.profile') }}">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-purple-600 text-white rounded-full flex items-center justify-center text-lg font-bold">
                        {{ strtoupper(substr($user->nama, 0, 2)) }}
                    </div>
                    <span>{{ $user->nama }}</span>
                </div>
            </a>
        </div>

        <!-- Overview Cards -->
        <!-- <div class="grid grid-cols-4 gap-4 mb-8">
            <div class="bg-yellow-400 text-white p-6 rounded-xl shadow text-center">
                <div class="text-lg font-semibold">83%</div>
                <div class="text-sm">Open Rate</div>
            </div>
            <div class="bg-purple-600 text-white p-6 rounded-xl shadow text-center">
                <div class="text-lg font-semibold">77%</div>
                <div class="text-sm">Complete</div>
            </div>
            <div class="bg-pink-400 text-white p-6 rounded-xl shadow text-center">
                <div class="text-lg font-semibold">91</div>
                <div class="text-sm">Unique Views</div>
            </div>
            <div class="bg-blue-300 text-white p-6 rounded-xl shadow text-center">
                <div class="text-lg font-semibold">126</div>
                <div class="text-sm">Total Views</div>
            </div>
        </div> -->

        <!-- Banner dengan Gambar dan Teks -->
        <div class="relative mb-8 rounded-xl overflow-hidden shadow">
            <img src="{{ asset('images/banner_smam_3_bungah.jpg') }}" alt="Banner Sekolah" class="w-full h-64 object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                <h2 class="text-white text-3xl md:text-4xl font-bold">SMA MUHAMMADIYAH 3 GRESIK</h2>
            </div>
        </div>

        <!-- Info Box -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-xl font-semibold mb-2 text-gray-800">Informasi Siswa</h3>
            <p><strong>NISN:</strong> {{ $user->NISN }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Alamat:</strong> {{ $user->alamat }}</p>
        </div>

        <!-- Tabel Tagihan Belum Dibayar -->
        <div class="bg-white p-6 rounded-xl shadow mt-8">
            <h3 class="text-xl font-semibold mb-4 text-gray-800">Tagihan Belum Dibayar</h3>
            
            @if($tagihanBelumBayar->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-gray-700">
                        <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Bulan</th>
                                <th class="px-4 py-3">Tahun</th>
                                <th class="px-4 py-3">Tagihan</th>
                                <th class="px-4 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tagihanBelumBayar as $tagihan)
                                <tr class="border-t hover:bg-gray-50">
                                    <td class="px-4 py-3 text-center">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3 text-center">{{ $tagihan->bulan }}</td>
                                    <td class="px-4 py-3 text-center">{{ $tagihan->tahun }}</td>
                                    <td class="px-4 py-3 text-center">Rp {{ number_format($tagihan->tagihan, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-center capitalize">{{ $tagihan->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 italic">Tidak ada tagihan yang perlu dibayar.</p>
            @endif
        </div>

    </main>
</div>

</body>
</html>
