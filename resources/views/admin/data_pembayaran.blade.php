<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Pembayaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">
<div class="flex min-h-screen">
    @include('components.sidebar_admin')

    <main class="flex-1 p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Data Pembayaran</h1>
            <button onclick="openModal()" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">+ Tambah</button>
        </div>

        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <form method="GET" class="flex items-center space-x-4 mb-4 pt-4 ps-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa..." class="border p-2 rounded w-64">
                <select name="status" class="border p-2 rounded">
                    <option value="">-- Semua Status --</option>
                    <option value="belum dibayar" {{ request('status') == 'belum dibayar' ? 'selected' : '' }}>Belum Dibayar</option>
                    <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                </select>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
            </form>

            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Nama Admin</th>
                        <th class="px-4 py-3">Nama Siswa</th>
                        <th class="px-4 py-3">Bulan</th>
                        <th class="px-4 py-3">Tahun</th>
                        <th class="px-4 py-3">Tagihan</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pembayaran as $key => $p)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-3 text-center">{{ $key + 1 }}</td>
                        <td class="px-4 py-3 text-center">{{ $p->admin->nama ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">{{ $p->siswa->nama ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">{{ $p->bulan }}</td>
                        <td class="px-4 py-3 text-center">{{ $p->tahun }}</td>
                        <td class="px-4 py-3 text-center">Rp {{ number_format($p->tagihan, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-center">{{ ucfirst($p->status) }}</td>
                        <td class="px-4 py-3 text-center space-x-2">
                            <button onclick="openEditModal({{ $p->id }}, '{{ $p->user_id }}', '{{ $p->bulan }}', '{{ $p->tahun }}', '{{ $p->tagihan }}', '{{ $p->status }}')" class="text-blue-500 hover:text-blue-700 font-medium">Edit</button>
                            <form action="{{ route('data_pembayaran.destroy', $p->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 hover:text-red-700 font-medium">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Modal Form -->
            <div id="modalForm" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
                    <h2 class="text-xl font-semibold mb-4" id="modalTitle">Tambah Pembayaran</h2>
                    <form id="pembayaranForm" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="_method" value="POST">
                        
                        <!-- User -->
                        <div class="mb-4">
                            <label class="block text-gray-700">Pilih User</label>
                            <select name="user_id" id="form_user_id" class="w-full border rounded p-2" required>
                                <option value="">-- Pilih User --</option>
                                @foreach($siswas as $siswa)
                                    <option value="{{ $siswa->id }}">{{ $siswa->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Semester -->
                        <div class="mb-4">
                            <label class="block text-gray-700">Semester</label>
                            <select name="semester" id="form_semester" class="w-full border rounded p-2" required>
                                <option value="">-- Pilih Semester --</option>
                                <option value="1">Semester 1 (Januari - Juni)</option>
                                <option value="2">Semester 2 (Juli - Desember)</option>
                            </select>
                        </div>

                        <!-- Tahun -->
                        <div class="mb-4">
                            <label class="block text-gray-700">Tahun</label>
                            <input type="number" name="tahun" id="form_tahun" required class="w-full border rounded p-2">
                        </div>

                        <!-- Tagihan -->
                        <div class="mb-4">
                            <label class="block text-gray-700">Tagihan</label>
                            <input type="number" name="tagihan" id="form_tagihan" required class="w-full border rounded p-2">
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label class="block text-gray-700">Status</label>
                            <select name="status" id="form_status" class="w-full border rounded p-2" required>
                                <option value="belum dibayar">Belum Dibayar</option>
                                <option value="lunas">Lunas</option>
                            </select>
                        </div>

                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
                        </div>
                    </form>
                    <button onclick="closeModal()" class="absolute top-2 right-3 text-xl">&times;</button>
                </div>
            </div>
            <!-- Modal Edit -->
            <div id="modalEditForm" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
                    <h2 class="text-xl font-semibold mb-4">Edit Pembayaran</h2>
                    <form id="editPembayaranForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="_method" value="PUT">

                        <input type="hidden" name="id" id="edit_id">

                        <div class="mb-4">
                            <label class="block text-gray-700">Pilih User</label>
                            <select name="user_id" id="edit_user_id" class="w-full border rounded p-2" required>
                                <option value="">-- Pilih User --</option>
                                @foreach($siswas as $siswa)
                                    <option value="{{ $siswa->id }}">{{ $siswa->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700">Bulan</label>
                            <input type="text" name="bulan" id="edit_bulan" required class="w-full border rounded p-2">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700">Tahun</label>
                            <input type="number" name="tahun" id="edit_tahun" required class="w-full border rounded p-2">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700">Tagihan</label>
                            <input type="number" name="tagihan" id="edit_tagihan" required class="w-full border rounded p-2">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700">Status</label>
                            <select name="status" id="edit_status" class="w-full border rounded p-2" required>
                                <option value="belum dibayar">Belum Dibayar</option>
                                <option value="lunas">Lunas</option>
                            </select>
                        </div>

                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
                        </div>
                    </form>
                    <button onclick="closeEditModal()" class="absolute top-2 right-3 text-xl">&times;</button>
                </div>
            </div>

        </div>
    </main>
</div>

<script>
    function openModal() {
        resetForm();
        document.getElementById('modalTitle').innerText = "Tambah Pembayaran";
        document.getElementById('modalForm').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modalForm').classList.add('hidden');
    }

    function resetForm() {
        document.getElementById('pembayaranForm').action = "{{ route('data_pembayaran.store') }}";
        document.getElementById('_method').value = "POST";
        document.getElementById('form_user_id').value = "";
        document.getElementById('form_semester').value = "";
        document.getElementById('form_tahun').value = "";
        document.getElementById('form_tagihan').value = "";
        document.getElementById('form_status').value = "belum dibayar";
    }


    function openEditModal(id, user_id, bulan, tahun, tagihan, status) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_user_id').value = user_id;
        document.getElementById('edit_bulan').value = bulan;
        document.getElementById('edit_tahun').value = tahun;
        document.getElementById('edit_tagihan').value = tagihan;
        document.getElementById('edit_status').value = status;
        document.getElementById('editPembayaranForm').action = `/admin/data_pembayaran/${id}`;
        document.getElementById('modalEditForm').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('modalEditForm').classList.add('hidden');
    }

</script>
</body>
</html>
