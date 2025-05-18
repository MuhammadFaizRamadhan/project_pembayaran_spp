<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Smk Malang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-white">
    <div class="flex max-w-4xl w-full shadow-xl rounded-xl overflow-hidden border border-gray-200">
        <!-- Left Side (Marketing message) -->
        <div class="w-1/2 bg-black text-white flex flex-col justify-center p-10">
            <h2 class="text-3xl font-bold mb-4">Everytime<br>Everywhere<br>Everymoment.</h2>
            <div class="h-32 w-20 mt-6 bg-gradient-to-t from-orange-500 to-transparent rounded-xl"></div>
        </div>

        <!-- Right Side (Login Form) -->
        <div class="w-1/2 p-10 bg-white">
            <div class="mb-6">
                <div class="w-8 h-8 bg-orange-500 rounded-full mb-2"></div>
                <h2 class="text-2xl font-bold">Welcome to </h2>
                <p class="text-gray-500 text-sm">SMK Malang — Let’s get started</p>
            </div>

            @if(session('error'))
                <p class="text-red-600 text-sm mb-4">{{ session('error') }}</p>
            @endif

            <form method="POST" action="/login" class="space-y-5">
                @csrf
                <div>
                    <label for="id_login" class="text-sm font-medium">NIP atau NISN</label>
                    <input type="text" name="id_login" id="id_login" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>

                <div>
                    <label for="password" class="text-sm font-medium">Password</label>
                    <input type="password" name="password" id="password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>

                <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 rounded-md transition">
                    Login
                </button>
            </form>

            <!-- <p class="mt-4 text-sm text-center text-gray-600">
                Already have account? <a href="/login" class="text-orange-500 hover:underline">Login</a>
            </p> -->
        </div>
    </div>
</body>
</html>
