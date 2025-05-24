<aside class="fixed top-0 left-0 h-full w-64 bg-white shadow-md z-40">
    <div class="p-6 border-b flex items-center gap-3">
        <img src="{{ asset('images/logo_smam_3_bungah_new.jpg') }}" alt="Logo" class="w-10 h-10 object-contain">
        <h1 class="text-l font-bold text-blue-700 leading-tight">SMA Muhammadiyah 3 Bungah</h1>
    </div>
    <nav class="mt-6">
        <a href="/dashboard/admin" class="block px-6 py-3 text-gray-700 hover:bg-blue-100">Dashboard</a>
        <a href="{{ route('admin.profile') }}" class="block px-6 py-3 text-gray-700 hover:bg-blue-100">Profile</a>
        <a href="/admin/data_pembayaran" class="block px-6 py-3 text-gray-700 hover:bg-blue-100">Data Pembayaran</a>
        <a href="/admin/riwayat_transaksi" class="block px-6 py-3 text-gray-700 hover:bg-blue-100">Transaksi</a>
        <a href="/admin/data_siswa" class="block px-6 py-3 text-gray-700 hover:bg-blue-100">Data Siswa</a>
    </nav>
    <form method="POST" action="/logout" class="px-6 mt-6">
        @csrf
        <button type="submit" class="w-full px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600">Logout</button>
    </form>
</aside>
