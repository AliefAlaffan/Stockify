@php use Illuminate\Support\Facades\Storage; @endphp
<x-app-layout>
    <x-slot name="header">Detail Produk</x-slot>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 max-w-2xl">
        <div class="flex gap-5">
            @if ($product->image)
                <img src="{{ Storage::url($product->image) }}" class="w-28 h-28 object-cover rounded-lg border flex-shrink-0">
            @else
                <div class="w-28 h-28 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 text-sm flex-shrink-0">Tidak ada gambar</div>
            @endif
            <div>
                <h3 class="text-xl font-semibold text-gray-900">{{ $product->name }}</h3>
                <span class="inline-block mt-1 px-2 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded">{{ $product->sku }}</span>
                <p class="mt-2 text-sm text-gray-500">{{ $product->description ?? 'Tidak ada deskripsi' }}</p>
            </div>
        </div>

        <dl class="grid grid-cols-2 gap-4 mt-6 text-sm">
            <div>
                <dt class="text-gray-500">Kategori</dt>
                <dd class="font-medium text-gray-900">{{ $product->category->name ?? '-' }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Supplier</dt>
                <dd class="font-medium text-gray-900">{{ $product->supplier->name ?? '-' }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Harga Beli</dt>
                <dd class="font-medium text-gray-900">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Harga Jual</dt>
                <dd class="font-medium text-gray-900">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Stok Minimum</dt>
                <dd class="font-medium text-gray-900">{{ $product->minimum_stock }}</dd>
            </div>
        </dl>

        <div class="mt-6 pt-4 border-t">
            <div class="flex items-center justify-between mb-3">
                <h4 class="font-semibold text-gray-800">Atribut Produk</h4>
                <a href="{{ route('products.attributes.index', $product->id) }}" class="text-sm text-blue-600 hover:underline">Kelola Atribut →</a>
            </div>
            <div class="flex flex-wrap gap-2">
                @forelse ($product->attributes as $attr)
                    <span class="px-2.5 py-1 text-xs font-medium text-blue-700 bg-blue-50 rounded-full">{{ $attr->name }}: {{ $attr->value }}</span>
                @empty
                    <span class="text-sm text-gray-400">Belum ada atribut</span>
                @endforelse
            </div>
        </div>

        <a href="{{ route('products.index') }}" class="inline-block mt-6 text-sm text-gray-600 hover:underline">← Kembali ke Daftar Produk</a>
    </div>
</x-app-layout>