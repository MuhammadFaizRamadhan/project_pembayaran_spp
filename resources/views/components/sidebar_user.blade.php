<aside class="w-64 bg-white shadow-md">
    <div class="p-6 border-b">
        <h1 class="text-2xl font-bold text-orange-700">SMK Malang</h1>
    </div>
    <nav class="mt-6">
        <a href="/dashboard/admin" class="block px-6 py-3 text-gray-700 hover:bg-orange-100">Dashboard</a>
        <a href="/admin/data_pembayaran" class="block px-6 py-3 text-gray-700 hover:bg-orange-100">Tagihan</a>
        <!-- <a href="/admin/data_siswa" class="block px-6 py-3 text-gray-700 hover:bg-orange-100">Riwayat Transaksi</a> -->
        <a href="{{ route('user.profile') }}" class="block px-6 py-3 text-gray-700 hover:bg-orange-100">Profile</a>
    </nav>
    <form method="POST" action="/logout" class="px-6 mt-6">
        @csrf
        <button type="submit" class="w-full px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600">Logout</button>
    </form>
</aside>
