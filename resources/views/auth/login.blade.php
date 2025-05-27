<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - SMA Muhammadiyah 3 Bungah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-white">
    <div class="flex max-w-4xl w-full shadow-xl rounded-xl overflow-hidden border border-gray-200">
        <!-- Left Side (Gambar) -->
        <div class="w-1/2">
            <img src="{{ asset('images/banner_login.jpg') }}" alt="Login Banner" class="w-full h-full object-cover">
        </div>

        <!-- Right Side (Login Form) -->
        <div class="w-1/2 p-10 bg-white">
            <div class="mb-6">
                <div class="w-8 h-8 bg-blue-500 rounded-full mb-2"></div>
                <h2 class="text-2xl font-bold">Welcome to </h2>
                <p class="text-gray-500 text-sm">SMA Muhammadiyah 3 Gresik</p>
            </div>

            @if(session('error'))
                <p class="text-red-600 text-sm mb-4">{{ session('error') }}</p>
            @endif

            <form method="POST" action="/login" class="space-y-5">
                @csrf
                <div>
                    <label for="id_login" class="text-sm font-medium">NIP atau NISN</label>
                    <input type="text" name="id_login" id="id_login" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="password" class="text-sm font-medium">Password</label>
                    <input type="password" name="password" id="password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded-md transition">
                    Login
                </button>
            </form>
        </div>
    </div>
</body>
</html>
