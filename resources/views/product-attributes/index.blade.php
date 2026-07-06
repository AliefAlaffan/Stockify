<x-app-layout>
    <x-slot name="header">Atribut Produk: {{ $product->name }}</x-slot>

    @if (session('success'))
        <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 100 19 9.5 9.5 0 000-19zm3.7 7.2l-4.4 4.4a.7.7 0 01-1 0L6.3 10a.7.7 0 111-1l1.3 1.3 3.9-3.9a.7.7 0 111 1z"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="flex items-center justify-between p-4 border-b border-gray-200">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">Daftar Atribut</h2>
                <p class="text-sm text-gray-500">Misalnya: ukuran, warna, berat</p>
            </div>
            <button type="button" data-modal-target="modal-add-attribute" data-modal-toggle="modal-add-attribute"
                class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-200">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                </svg>
                Tambah Atribut
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Nama Atribut</th>
                        <th class="px-6 py-3">Nilai</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attributes as $attribute)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $attribute->name }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-xs font-medium text-blue-700 bg-blue-50 rounded-full">{{ $attribute->value }}</span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-3">
                                <button type="button"
                                    data-modal-target="modal-edit-attribute"
                                    data-modal-toggle="modal-edit-attribute"
                                    onclick="fillEditAttributeModal({{ $attribute->id }}, '{{ addslashes($attribute->name) }}', '{{ addslashes($attribute->value) }}')"
                                    class="font-medium text-blue-600 hover:underline">Edit</button>
                                <button type="button"
                                    data-modal-target="modal-delete-attribute"
                                    data-modal-toggle="modal-delete-attribute"
                                    onclick="document.getElementById('form-delete-attribute').action = '{{ route('products.attributes.destroy', [$product->id, $attribute->id]) }}'"
                                    class="font-medium text-red-600 hover:underline">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-400">Belum ada atribut</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('products.show', $product->id) }}" class="inline-block mt-4 text-sm text-gray-600 hover:underline">← Kembali ke Detail Produk</a>

    <!-- Modal Tambah -->
    <div id="modal-add-attribute" tabindex="-1" aria-hidden="true" class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center">
        <div class="relative w-full max-w-md">
            <div class="relative bg-white rounded-lg shadow">
                <div class="flex items-center justify-between p-4 border-b rounded-t">
                    <h3 class="text-lg font-semibold text-gray-900">Tambah Atribut</h3>
                    <button type="button" data-modal-hide="modal-add-attribute" class="text-gray-400 bg-transparent hover:bg-gray-200 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
                <form action="{{ route('products.attributes.store', $product->id) }}" method="POST">
                    @csrf
                    <div class="p-4 space-y-4">
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-900">Nama Atribut</label>
                            <input type="text" name="name" placeholder="Misal: Warna" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-900">Nilai</label>
                            <input type="text" name="value" placeholder="Misal: Merah" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                    </div>
                    <div class="flex items-center justify-end p-4 border-t space-x-2">
                        <button type="button" data-modal-hide="modal-add-attribute" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100">Batal</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="modal-edit-attribute" tabindex="-1" aria-hidden="true" class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center">
        <div class="relative w-full max-w-md">
            <div class="relative bg-white rounded-lg shadow">
                <div class="flex items-center justify-between p-4 border-b rounded-t">
                    <h3 class="text-lg font-semibold text-gray-900">Edit Atribut</h3>
                    <button type="button" data-modal-hide="modal-edit-attribute" class="text-gray-400 bg-transparent hover:bg-gray-200 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
                <form id="form-edit-attribute" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="p-4 space-y-4">
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-900">Nama Atribut</label>
                            <input type="text" name="name" id="edit-attribute-name" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-900">Nilai</label>
                            <input type="text" name="value" id="edit-attribute-value" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                    </div>
                    <div class="flex items-center justify-end p-4 border-t space-x-2">
                        <button type="button" data-modal-hide="modal-edit-attribute" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100">Batal</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="modal-delete-attribute" tabindex="-1" aria-hidden="true" class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center">
        <div class="relative w-full max-w-sm">
            <div class="relative bg-white rounded-lg shadow text-center">
                <div class="p-6">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-width="2" d="M10 6v4m0 4h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="mb-5 text-gray-600">Yakin ingin menghapus atribut ini?</h3>
                    <form id="form-delete-attribute" action="" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" data-modal-hide="modal-delete-attribute" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 mr-2">Batal</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function fillEditAttributeModal(id, name, value) {
            document.getElementById('edit-attribute-name').value = name;
            document.getElementById('edit-attribute-value').value = value;
            document.getElementById('form-edit-attribute').action = `/products/{{ $product->id }}/attributes/${id}`;
        }
    </script>
</x-app-layout>