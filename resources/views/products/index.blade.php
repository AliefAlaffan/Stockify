@php use Illuminate\Support\Facades\Storage; @endphp
<x-app-layout>
    <x-slot name="header">Produk</x-slot>

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
            <h2 class="text-lg font-semibold text-gray-800">Daftar Produk</h2>
            <a href="{{ route('products.create') }}"
                class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-200">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                </svg>
                Tambah Produk
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Produk</th>
                        <th class="px-6 py-3">SKU</th>
                        <th class="px-6 py-3">Kategori</th>
                        <th class="px-6 py-3">Supplier</th>
                        <th class="px-6 py-3">Harga Jual</th>
                        <th class="px-6 py-3">Min. Stok</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if ($product->image)
                                        <img src="{{ Storage::url($product->image) }}" class="w-10 h-10 object-cover rounded-lg border">
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 text-xs">N/A</div>
                                    @endif
                                    <span class="font-medium text-gray-900">{{ $product->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded">{{ $product->sku }}</span>
                            </td>
                            <td class="px-6 py-4">{{ $product->category->name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $product->supplier->name ?? '-' }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">{{ $product->minimum_stock }}</td>
                            <td class="px-6 py-4 text-right">
                                <button id="dropdown-button-{{ $product->id }}" data-dropdown-toggle="dropdown-{{ $product->id }}"
                                    class="inline-flex items-center p-1.5 text-gray-500 rounded-lg hover:bg-gray-100" type="button">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                                    </svg>
                                </button>
                                <div id="dropdown-{{ $product->id }}" class="hidden z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-36 border">
                                    <ul class="py-1 text-sm text-gray-700">
                                        <li><a href="{{ route('products.show', $product->id) }}" class="block px-4 py-2 hover:bg-gray-100">Detail</a></li>
                                        <li><a href="{{ route('products.edit', $product->id) }}" class="block px-4 py-2 hover:bg-gray-100">Edit</a></li>
                                        <li>
                                            <button type="button"
                                                data-modal-target="modal-delete-product"
                                                data-modal-toggle="modal-delete-product"
                                                onclick="document.getElementById('form-delete-product').action = '{{ route('products.destroy', $product->id) }}'"
                                                class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">Hapus</button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-400">Belum ada produk</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="modal-delete-product" tabindex="-1" aria-hidden="true" class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center">
        <div class="relative w-full max-w-sm">
            <div class="relative bg-white rounded-lg shadow text-center">
                <div class="p-6">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-width="2" d="M10 6v4m0 4h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="mb-5 text-gray-600">Yakin ingin menghapus produk ini?</h3>
                    <form id="form-delete-product" action="" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" data-modal-hide="modal-delete-product" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 mr-2">Batal</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>