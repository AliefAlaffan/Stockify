<x-app-layout>
    <x-slot name="header">Dashboard Manajer Gudang</x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
            <p class="text-sm text-gray-500">Produk Stok Menipis</p>
            <p class="text-2xl font-bold text-red-600 mt-1">{{ $lowStockProducts->count() }}</p>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
            <p class="text-sm text-gray-500">Barang Masuk Hari Ini</p>
            <p class="text-2xl font-bold text-green-600 mt-1">{{ $incomingToday }}</p>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
            <p class="text-sm text-gray-500">Barang Keluar Hari Ini</p>
            <p class="text-2xl font-bold text-blue-600 mt-1">{{ $outgoingToday }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Produk dengan Stok Menipis</h2>
            <p class="text-sm text-gray-500 mt-1">Stok saat ini sudah berada di bawah atau sama dengan stok minimum</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Produk</th>
                        <th class="px-6 py-3">SKU</th>
                        <th class="px-6 py-3">Stok Saat Ini</th>
                        <th class="px-6 py-3">Stok Minimum</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lowStockProducts as $product)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $product->name }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded">{{ $product->sku }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-xs font-medium text-red-800 bg-red-100 rounded-full">{{ $product->current_stock }}</span>
                            </td>
                            <td class="px-6 py-4">{{ $product->minimum_stock }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-400">Semua stok aman 🎉</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>