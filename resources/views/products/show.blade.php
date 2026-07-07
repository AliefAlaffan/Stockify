@php use Illuminate\Support\Facades\Storage; @endphp
<x-app-layout>
    <x-slot name="header">Detail Produk</x-slot>

    <div class="flex items-center gap-3 mb-5">
        <a href="{{ route('products.index') }}" class="icon-btn text-steel hover:bg-canvas-alt !rounded-lg">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" d="M12.5 15l-5-5 5-5"/></svg>
        </a>
        <p class="font-mono-data text-[11px] tracking-widest text-steel uppercase">Data Master / Produk / Detail</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 max-w-2xl">
        <div class="flex gap-5 items-start">
            @if ($product->image)
                <img src="{{ Storage::url($product->image) }}" class="w-24 h-24 object-cover rounded-2xl border border-gray-100 flex-shrink-0">
            @else
                <div class="w-24 h-24 rounded-2xl bg-canvas-alt flex items-center justify-center text-steel-light flex-shrink-0">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm4 4a2 2 0 100-4 2 2 0 000 4zm10 8l-5-5-3 3-2-2-4 4"/></svg>
                </div>
            @endif
            <div class="min-w-0">
                <h2 class="font-display text-xl font-semibold text-ink">{{ $product->name }}</h2>
                <span class="inline-flex mt-1.5 font-mono-data text-xs px-2 py-1 bg-canvas-alt text-ink-soft rounded-md">{{ $product->sku }}</span>
                <p class="mt-2 text-sm text-steel">{{ $product->description ?? 'Tidak ada deskripsi.' }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-6 pt-6 border-t border-gray-100">
            <div>
                <p class="text-xs text-steel uppercase tracking-wide mb-1">Kategori</p>
                <p class="font-medium text-ink text-sm">{{ $product->category->name ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs text-steel uppercase tracking-wide mb-1">Supplier</p>
                <p class="font-medium text-ink text-sm">{{ $product->supplier->name ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs text-steel uppercase tracking-wide mb-1">Stok Minimum</p>
                <p class="font-medium text-ink text-sm">{{ $product->minimum_stock }} unit</p>
            </div>
            <div>
                <p class="text-xs text-steel uppercase tracking-wide mb-1">Harga Beli</p>
                <p class="font-medium text-ink text-sm">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-xs text-steel uppercase tracking-wide mb-1">Harga Jual</p>
                <p class="font-medium text-brand-dark text-sm">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-display font-semibold text-ink text-sm">Atribut Produk</h3>
                <a href="{{ route('products.attributes.index', $product->id) }}" class="text-sm text-brand-dark font-medium hover:underline">Kelola Atribut →</a>
            </div>
            <div class="flex flex-wrap gap-2">
                @forelse ($product->attributes as $attr)
                    <span class="stock-tag bg-canvas-alt text-ink-soft">
                        <span class="stock-tag-dot bg-freight"></span>
                        {{ $attr->name }}: {{ $attr->value }}
                    </span>
                @empty
                    <p class="text-sm text-steel-light">Belum ada atribut ditambahkan.</p>
                @endforelse
            </div>
        </div>

        <div class="flex gap-2 mt-6 pt-6 border-t border-gray-100">
            <a href="{{ route('products.edit', $product->id) }}" class="btn-primary flex-1 text-center px-4 py-2.5 text-sm font-semibold text-white rounded-xl">Edit Produk</a>
            <a href="{{ route('products.index') }}" class="px-4 py-2.5 text-sm font-medium text-ink-soft bg-canvas-alt rounded-xl hover:bg-gray-200 transition-colors">Kembali</a>
        </div>
    </div>
</x-app-layout>