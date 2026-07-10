@php use Illuminate\Support\Facades\Storage; @endphp

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    @if ($products->count() > 0)
        <table class="w-full text-sm text-left">
            <thead class="bg-canvas-alt/70 text-[11px] text-steel uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3.5 font-semibold">Produk</th>
                    <th class="px-6 py-3.5 font-semibold">SKU</th>
                    <th class="px-6 py-3.5 font-semibold">Kategori</th>
                    <th class="px-6 py-3.5 font-semibold">Supplier</th>
                    <th class="px-6 py-3.5 font-semibold">Harga Jual</th>
                    <th class="px-6 py-3.5 font-semibold">Stok</th>
                    <th class="px-6 py-3.5 font-semibold">Min. Stok</th>
                    <th class="px-6 py-3.5 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach ($products as $product)
                    @php
                        $stock = $product->current_stock ?? 0;
                        if ($stock <= 0) {
                            $stockPill = 'pill-brick';
                        } elseif ($stock <= $product->minimum_stock) {
                            $stockPill = 'pill-gold';
                        } else {
                            $stockPill = 'pill-emerald';
                        }
                    @endphp
                    <tr class="table-row hover:bg-canvas-alt/40">
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-3">
                                @if ($product->image)
                                    <img src="{{ Storage::url($product->image) }}" class="w-11 h-11 object-cover rounded-xl border border-gray-100 flex-shrink-0">
                                @else
                                    <div class="w-11 h-11 rounded-xl bg-canvas-alt flex items-center justify-center text-steel-light flex-shrink-0">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm4 4a2 2 0 100-4 2 2 0 000 4zm10 8l-5-5-3 3-2-2-4 4"/></svg>
                                    </div>
                                @endif
                                <span class="font-medium text-ink">{{ $product->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-3.5">
                            <span class="font-mono-data text-xs px-2 py-1 bg-canvas-alt text-ink-soft rounded-md">{{ $product->sku }}</span>
                        </td>
                        <td class="px-6 py-3.5 text-ink-soft">{{ $product->category->name ?? '—' }}</td>
                        <td class="px-6 py-3.5 text-ink-soft">{{ $product->supplier->name ?? '—' }}</td>
                        <td class="px-6 py-3.5 font-medium text-ink">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-3.5">
                            <span class="pill {{ $stockPill }}">
                                {{ $stock }}
                            </span>
                        </td>
                        <td class="px-6 py-3.5 text-ink-soft">{{ $product->minimum_stock }}</td>
                        <td class="px-6 py-3.5 text-right">
                            <div class="inline-flex items-center gap-1">
                                <a href="{{ route('products.show', $product->id) }}" class="icon-btn text-steel hover:bg-canvas-alt" title="Detail">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M1.5 10S4.5 4 10 4s8.5 6 8.5 6-3 6-8.5 6-8.5-6-8.5-6z"/><circle cx="10" cy="10" r="2.2" stroke="currentColor" stroke-width="1.6"/></svg>
                                </a>
                                <a href="{{ route('products.edit', $product->id) }}" class="icon-btn text-freight hover:bg-freight/10" title="Edit">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M13.5 3.5a1.914 1.914 0 012.706 2.706L6.5 15.914 3 16.5l.586-3.5 9.914-9.5z"/></svg>
                                </a>
                                <button type="button"
                                    data-modal-target="modal-delete-product"
                                    data-modal-toggle="modal-delete-product"
                                    onclick="document.getElementById('form-delete-product').action = '{{ route('products.destroy', $product->id) }}'; document.getElementById('delete-product-name').textContent = '{{ addslashes($product->name) }}'"
                                    class="icon-btn text-rust hover:bg-rust/10" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M4 6h12M8 6V4.5A1.5 1.5 0 019.5 3h1A1.5 1.5 0 0112 4.5V6m2 0v9.5A1.5 1.5 0 0112.5 17h-5A1.5 1.5 0 016 15.5V6h8z"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $products->links() }}
        </div>
    @else
        <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
            <div class="empty-icon bg-canvas-alt mb-4">
                <svg class="w-8 h-8 text-steel-light" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm4 4a2 2 0 100-4 2 2 0 000 4zm10 8l-5-5-3 3-2-2-4 4"/></svg>
            </div>
            <p class="font-medium text-ink mb-1">
                {{ request('search') ? 'Tidak ada produk yang cocok' : 'Belum ada produk' }}
            </p>
            <p class="text-sm text-steel mb-4">
                {{ request('search') ? 'Coba kata kunci lain.' : 'Tambahkan produk pertama untuk mulai mengelola stok gudang.' }}
            </p>
            @unless (request('search'))
                <a href="{{ route('products.create') }}" class="btn-primary px-4 py-2 text-sm font-semibold text-white rounded-xl">
                    Tambah Produk Pertama
                </a>
            @endunless
        </div>
    @endif
</div>