<x-app-layout>
    <x-slot name="header">Stock Opname</x-slot>

    @if (session('success'))
        <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Penyesuaian Stok Fisik</h2>
            <p class="text-sm text-gray-500 mt-1">Masukkan jumlah hasil hitung fisik gudang. Sistem akan otomatis mencatat penyesuaian jika ada selisih.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Produk</th>
                        <th class="px-6 py-3">SKU</th>
                        <th class="px-6 py-3">Stok Sistem</th>
                        <th class="px-6 py-3">Jumlah Fisik</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $product->name }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded">{{ $product->sku }}</span>
                            </td>
                            <td class="px-6 py-4">{{ $product->current_stock }}</td>
                            <td class="px-6 py-4">
                                <form action="{{ route('stock-opname.store') }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="date" value="{{ date('Y-m-d') }}">
                                    <input type="number" name="physical_count" min="0" required
                                        placeholder="{{ $product->current_stock }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-28 p-2">
                            </td>
                            <td class="px-6 py-4 text-right">
                                    <button type="submit" class="px-3 py-1.5 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">Simpan</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada produk</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>