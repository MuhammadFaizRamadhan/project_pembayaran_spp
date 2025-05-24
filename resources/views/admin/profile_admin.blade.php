<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

<div class="flex min-h-screen">
    <!-- Sidebar -->
    @include('components.sidebar_admin')

    <!-- Main Content -->
    <main class="flex-1  ml-64 p-8 relative">
        <!-- Flash Message -->
        @if(session('success'))
            <div id="successAlert" class="absolute top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg shadow z-50 transition-all duration-300">
                <strong>Sukses!</strong> {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div id="errorAlert" class="absolute top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg shadow z-50 transition-all duration-300">
                <strong>Gagal!</strong> {{ session('error') }}
            </div>
        @endif

        <div class="bg-white p-8 rounded-2xl shadow max-w-4xl mx-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Personal Information</h2>

            <form action="{{ route('admin.updateProfile') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- NIP and Name -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-medium">NIP</label>
                        <input type="text" name="nip" value="{{ $admin->NIP }}" readonly
                               class="w-full mt-1 p-3 rounded-lg border bg-gray-100 cursor-not-allowed" />
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium">Nama</label>
                        <input type="text" name="nama" value="{{ $admin->nama }}"
                               class="w-full mt-1 p-3 rounded-lg border" required />
                    </div>
                </div>

                <!-- Email with "Verified" badge -->
                <div>
                    <label class="block text-gray-700 font-medium">Email</label>
                    <div class="relative">
                        <input type="email" name="email" value="{{ $admin->email }}"
                               class="w-full mt-1 p-3 rounded-lg border pr-20" required />
                    </div>
                </div>

                <!-- Alamat -->
                <div>
                    <label class="block text-gray-700 font-medium">Alamat</label>
                    <input type="text" name="alamat" value="{{ $admin->alamat }}"
                           class="w-full mt-1 p-3 rounded-lg border" required />
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-4 pt-4">
                    <button type="submit"
                            class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>

<!-- Auto-hide flash message -->
<script>
    setTimeout(() => {
        const successAlert = document.getElementById('successAlert');
        const errorAlert = document.getElementById('errorAlert');
        if (successAlert) successAlert.style.display = 'none';
        if (errorAlert) errorAlert.style.display = 'none';
    }, 3000); // hilang dalam 3 detik
</script>

</body>
</html>
