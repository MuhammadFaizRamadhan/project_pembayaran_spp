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
    <main class="flex-1  ml-64 p-8">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-200 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-200 text-red-800 rounded">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- Header Action Bar -->
        <div class="flex justify-between items-center mb-6">
            <div class="text-2xl font-semibold text-gray-800">Data Siswa</div>
            
            <div class="space-x-2">
                <!-- <button class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded">Delete</button> -->
                <!-- Modal Button -->
                <!-- Tombol Tambah -->
                <button onclick="openAddModal()" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">+ Add New</button>
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
                        <th class="px-6 py-3">Foto</th>
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
                        <td class="px-6 py-4 text-center">
                            @if($s->foto)
                                <img src="{{ asset('storage/' . $s->foto) }}" alt="Foto" class="w-12 h-12 rounded-full object-cover mx-auto">
                            @else
                                <span>-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center space-x-2">
                            <!-- Tombol Edit -->
                            <button type="button" 
                                class="bg-blue-500 text-white hover:text-blue-900 p-2 font-medium rounded"
                                onclick="openEditModal(
                                    {{ $s->id }},
                                    '{{ $s->NISN }}',
                                    '{{ $s->nama }}',
                                    '{{ $s->alamat }}',
                                    '{{ $s->email }}',
                                    '{{ $s->foto ? asset('storage/' . $s->foto) : '' }}'
                                )">
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

            <!-- Modal Tambah data -->
            <div id="modalAdd" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
                    <h2 class="text-xl font-semibold mb-4">Tambah Siswa</h2>
                    <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700">NISN</label>
                            <input type="text" name="NISN" required class="w-full border rounded p-2">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Nama</label>
                            <input type="text" name="nama" required class="w-full border rounded p-2">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Alamat</label>
                            <input type="text" name="alamat" required class="w-full border rounded p-2">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Email</label>
                            <input type="email" name="email" required class="w-full border rounded p-2">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Password</label>
                            <input type="password" name="password" required class="w-full border rounded p-2">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Foto</label>
                            <input type="file" name="foto" accept="image/*" class="w-full border rounded p-2">
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="closeAddModal()" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
                        </div>
                    </form>
                    <button onclick="closeAddModal()" class="absolute top-2 right-3 text-xl">&times;</button>
                </div>
            </div>

            <!-- Modal Edit data -->
            <div id="modalEdit" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
                    <h2 class="text-xl font-semibold mb-4">Edit Siswa</h2>
                    <form id="editForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-gray-700">NISN</label>
                            <input type="text" name="NISN" id="edit_nisn" required class="w-full border rounded p-2">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Nama</label>
                            <input type="text" name="nama" id="edit_nama" required class="w-full border rounded p-2">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Alamat</label>
                            <input type="text" name="alamat" id="edit_alamat" required class="w-full border rounded p-2">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Email</label>
                            <input type="email" name="email" id="edit_email" required class="w-full border rounded p-2">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Foto Baru</label>
                            <input type="file" name="foto" id="edit_foto" accept="image/*" class="w-full border rounded p-2">
                        </div>
                        <div class="mb-4" id="preview_container_edit" style="display: none;">
                            <label class="block text-gray-700">Foto Saat Ini</label>
                            <img id="foto_preview_edit" src="" alt="Preview Foto" class="w-20 h-20 object-cover rounded border">
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
                        </div>
                    </form>
                    <button onclick="closeEditModal()" class="absolute top-2 right-3 text-xl">&times;</button>
                </div>
            </div>


            <!-- Modal Form -->
            <div id="modalForm" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
                    <h2 class="text-xl font-semibold mb-4">Tambah Siswa</h2>
                    <form id="siswaForm" method="POST" enctype="multipart/form-data">
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

                        <!-- Foto -->
                        <div class="mb-4">
                            <label class="block text-gray-700">Foto</label>
                            <input type="file" name="foto" id="form_foto" accept="image/*" class="w-full border rounded p-2">
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
    const storeUrl = "{{ route('siswa.store') }}";
    function openModal() {
        resetForm();
        document.getElementById('modalForm').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modalForm').classList.add('hidden');
    }

    function resetForm() {
        document.getElementById('siswaForm').action = storeUrl;
        document.getElementById('_method').value = "POST";
        document.getElementById('form_id').value = "";
        document.getElementById('form_nisn').value = "";
        document.getElementById('form_nama').value = "";
        document.getElementById('form_alamat').value = "";
        document.getElementById('form_email').value = "";
        document.getElementById('form_password').required = true;
        document.getElementById('form_password').value = "";
        document.getElementById('password_field').style.display = 'block';
        document.getElementById('form_foto').value = '';
        document.getElementById('preview_container').style.display = 'none';


    }

    function openEditModal(id, nisn, nama, alamat, email, fotoUrl) {
        const form = document.getElementById('editForm');
        form.action = `/admin/data_siswa/${id}`;

        document.getElementById('edit_nisn').value = nisn;
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_alamat').value = alamat;
        document.getElementById('edit_email').value = email;

        if (fotoUrl) {
            document.getElementById('foto_preview_edit').src = fotoUrl;
            document.getElementById('preview_container_edit').style.display = 'block';
        } else {
            document.getElementById('preview_container_edit').style.display = 'none';
        }

        document.getElementById('modalEdit').classList.remove('hidden');
    }
    function closeEditModal() {
        document.getElementById('modalEdit').classList.add('hidden');
    }
    function openAddModal() {
        document.getElementById('modalAdd').classList.remove('hidden');
    }

    function closeAddModal() {
        document.getElementById('modalAdd').classList.add('hidden');
    }

</script>

</body>
</html>
