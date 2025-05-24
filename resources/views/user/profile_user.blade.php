<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

<div class="flex min-h-screen">
    <!-- Sidebar -->
    @include('components.sidebar_user')

    <!-- Main Content -->
    <main class="flex-1 relative ml-64 p-8">
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
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Informasi Pribadi</h2>

            <form action="{{ route('user.updateProfile') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Foto Profil -->
                <div class="flex flex-col items-center">
                    <label class="block text-gray-700 font-medium mb-2">Foto Profil</label>
                    
                    @if ($user->foto)
                        <img src="{{ asset('storage/foto_siswa/' . basename($user->foto)) }}" alt="Foto Profil" class="w-32 h-32 object-cover mb-4 shadow">
                    @else
                        <div class="w-32 h-32 rounded-full bg-gray-300 flex items-center justify-center mb-4">
                            <span class="text-gray-600 text-sm">Tidak Ada Foto</span>
                        </div>
                    @endif

                    <input type="file" name="foto" accept="image/*" class="block text-sm text-gray-500" />
                </div>

                <!-- NISN dan Nama -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-medium">NISN</label>
                        <input type="text" name="nisn" value="{{ $user->NISN }}" readonly
                               class="w-full mt-1 p-3 rounded-lg border bg-gray-100 cursor-not-allowed" />
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium">Nama</label>
                        <input type="text" name="nama" value="{{ $user->nama }}"
                               class="w-full mt-1 p-3 rounded-lg border" required />
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-gray-700 font-medium">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}"
                           class="w-full mt-1 p-3 rounded-lg border" required />
                </div>

                <!-- Alamat -->
                <div>
                    <label class="block text-gray-700 font-medium">Alamat</label>
                    <input type="text" name="alamat" value="{{ $user->alamat }}"
                           class="w-full mt-1 p-3 rounded-lg border" required />
                </div>

                <!-- Tombol -->
                <div class="flex justify-end pt-4">
                    <button type="submit"
                            class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                        Simpan Perubahan
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
    }, 3000);
</script>

</body>
</html>
