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
    <main class="flex-1 p-10">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">Hi, {{ $admin->nama }}</h2>
                <p class="text-sm text-gray-500">Senin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 bg-purple-600 text-white rounded-full flex items-center justify-center text-lg font-bold">
                    {{ strtoupper(substr($admin->nama, 0, 2)) }}
                </div>
                <span>{{ $admin->nama }}</span>
            </div>
        </div>

        <!-- Overview Cards -->
        <div class="grid grid-cols-4 gap-4 mb-8">
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
        </div>

        <!-- Info Box -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-xl font-semibold mb-2 text-gray-800">Informasi Admin</h3>
            <p><strong>NIP:</strong> {{ $admin->NIP }}</p>
            <p><strong>Email:</strong> {{ $admin->email }}</p>
            <p><strong>Alamat:</strong> {{ $admin->alamat }}</p>
        </div>
    </main>
</div>

</body>
</html>
