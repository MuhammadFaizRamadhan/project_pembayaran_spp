<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

<div class="flex min-h-screen">
    <!-- Sidebar -->
    @include('components.sidebar_admin')

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <!-- Header Action Bar -->
        <div class="flex justify-between items-center mb-6">
            <div class="text-2xl font-semibold text-gray-800">Data Siswa</div>
            
            <div class="space-x-2">
                <!-- <button class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded">Delete</button> -->
                <!-- Modal Button -->
                <button onclick="openModal()" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">+ Add New</button>

            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <form method="GET" action="{{ route('siswa.index') }}" class="mb-4 pt-4 ps-4">
                <input type="text" name="keyword" placeholder="Cari NISN / Nama / Email" value="{{ request('keyword') }}"
                    class="border rounded px-3 py-2 w-64">
                <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded">Cari</button>
            </form>
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                    <tr>
                        <th class="px-6 py-3">NISN</th>
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Alamat</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswa as $s)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-6 py-4 text-center">{{ $s->NISN }}</td>
                        <td class="px-6 py-4 text-center">{{ $s->nama }}</td>
                        <td class="px-6 py-4 text-center">{{ $s->alamat }}</td>
                        <td class="px-6 py-4 text-center">{{ $s->email }}</td>
                        <td class="px-6 py-4 text-center space-x-2">
                            <button type="button" 
                                class="bg-blue-500 text-white hover:text-blue-900 p-2 font-medium rounded"
                                onclick="openEditModal({{ $s->id }}, '{{ $s->NISN }}', '{{ $s->nama }}', '{{ $s->alamat }}', '{{ $s->email }}')">
                                Edit
                            </button>
                            <form action="{{ route('siswa.destroy', $s->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus siswa ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 p-2 text-white hover:text-red-900 font-medium rounded">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Modal Form -->
            <div id="modalForm" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
                    <h2 class="text-xl font-semibold mb-4">Tambah Siswa</h2>
                    <form id="siswaForm" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="_method" value="POST">
                        <input type="hidden" name="id" id="form_id">
                        
                        <!-- NISN -->
                        <div class="mb-4">
                            <label class="block text-gray-700">NISN</label>
                            <input type="text" name="NISN" id="form_nisn" required class="w-full border rounded p-2">
                        </div>

                        <!-- Nama -->
                        <div class="mb-4">
                            <label class="block text-gray-700">Nama</label>
                            <input type="text" name="nama" id="form_nama" required class="w-full border rounded p-2">
                        </div>

                        <!-- Alamat -->
                        <div class="mb-4">
                            <label class="block text-gray-700">Alamat</label>
                            <input type="text" name="alamat" id="form_alamat" required class="w-full border rounded p-2">
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label class="block text-gray-700">Email</label>
                            <input type="email" name="email" id="form_email" required class="w-full border rounded p-2">
                        </div>

                        <!-- Password -->
                        <div class="mb-4" id="password_field">
                            <label class="block text-gray-700">Password</label>
                            <input type="password" name="password" id="form_password" class="w-full border rounded p-2">
                        </div>

                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
                        </div>
                    </form>
                    <button onclick="closeModal()" class="absolute top-2 right-3 text-xl">&times;</button>
                </div>
            </div>

        </div>
    </main>
</div>

<script>
    function openModal() {
        resetForm();
        document.getElementById('modalForm').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modalForm').classList.add('hidden');
    }

    function resetForm() {
        document.getElementById('siswaForm').action = "{{ route('siswa.store') }}";
        document.getElementById('_method').value = "POST";
        document.getElementById('form_id').value = "";
        document.getElementById('form_nisn').value = "";
        document.getElementById('form_nama').value = "";
        document.getElementById('form_alamat').value = "";
        document.getElementById('form_email').value = "";
        document.getElementById('form_password').required = true;
        document.getElementById('form_password').value = "";
        document.getElementById('password_field').style.display = 'block';
    }

    function openEditModal(id, nisn, nama, alamat, email) {
        document.getElementById('modalForm').classList.remove('hidden');
        document.getElementById('siswaForm').action = `/dashboard/data_siswa/${id}`;
        document.getElementById('_method').value = "PUT";
        document.getElementById('form_id').value = id;
        document.getElementById('form_nisn').value = nisn;
        document.getElementById('form_nama').value = nama;
        document.getElementById('form_alamat').value = alamat;
        document.getElementById('form_email').value = email;
        document.getElementById('form_password').required = false;
        document.getElementById('form_password').value = "";
        document.getElementById('password_field').style.display = 'none';
    }
</script>


</body>
</html>
