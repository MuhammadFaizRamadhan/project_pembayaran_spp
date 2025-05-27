<aside class="w-64 h-screen fixed left-0 top-0 bg-white shadow-md overflow-y-auto">
    <div class="p-6 border-b flex items-center gap-3">
        <img src="{{ asset('images/logo_smam_3_bungah_new.jpg') }}" alt="Logo" class="w-10 h-10 object-contain">
        <h1 class="text-l font-bold text-blue-500">SMA Muhammadiyah 3 Gresik</h1>
    </div>
    <nav class="mt-6">
        <a href="/dashboard/user" class="block px-6 py-3 text-gray-700 hover:bg-blue-100">Dashboard</a>
        <a href="{{ route('user.profile') }}" class="block px-6 py-3 text-gray-700 hover:bg-blue-100">Profile</a>
        <a href="/user/tagihan_user" class="block px-6 py-3 text-gray-700 hover:bg-blue-100">Tagihan</a>
        <a href="/user/riwayat_transaksi_user" class="block px-6 py-3 text-gray-700 hover:bg-blue-100">Riwayat Transaksi</a>
    </nav>
    <form method="POST" action="/logout" class="px-6 mt-6">
        @csrf
        <button type="submit" class="w-full px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600">Logout</button>
    </form>
</aside>
