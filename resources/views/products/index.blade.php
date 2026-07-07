@php use Illuminate\Support\Facades\Storage; @endphp
<x-app-layout>
    <x-slot name="header">Produk</x-slot>

    @if (session('success'))
        <div class="flex items-center gap-2.5 p-4 mb-5 text-sm text-brand-dark rounded-2xl bg-brand/8 border border-brand/15 animate-fade-up" role="alert">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="flex items-center justify-between mb-5">
        <div>
            <p class="font-mono-data text-[11px] tracking-widest text-steel uppercase mb-1">Data Master</p>
            <h1 class="font-display text-xl font-semibold text-ink">Produk</h1>
        </div>
        <a href="{{ route('products.create') }}"
            class="btn-primary flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white rounded-xl">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
            </svg>
            Tambah Produk
        </a>
    </div>

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
                        <th class="px-6 py-3.5 font-semibold">Min. Stok</th>
                        <th class="px-6 py-3.5 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach ($products as $product)
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
        @else
            <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
                <div class="empty-icon bg-canvas-alt mb-4">
                    <svg class="w-8 h-8 text-steel-light" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm4 4a2 2 0 100-4 2 2 0 000 4zm10 8l-5-5-3 3-2-2-4 4"/></svg>
                </div>
                <p class="font-medium text-ink mb-1">Belum ada produk</p>
                <p class="text-sm text-steel mb-4">Tambahkan produk pertama untuk mulai mengelola stok gudang.</p>
                <a href="{{ route('products.create') }}" class="btn-primary px-4 py-2 text-sm font-semibold text-white rounded-xl">
                    Tambah Produk Pertama
                </a>
            </div>
        @endif
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="modal-delete-product" tabindex="-1" aria-hidden="true" class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center bg-ink/30 modal-backdrop">
        <div class="modal-panel relative w-full max-w-[22rem]">
            <div class="relative bg-white rounded-2xl shadow-2xl text-center overflow-hidden">
                <div class="p-6 pt-7">
                    <div class="relative w-14 h-14 mx-auto mb-4">
                        <span class="absolute inset-0 rounded-full bg-rust/15 animate-ping-slow"></span>
                        <div class="relative w-14 h-14 rounded-full bg-rust/10 flex items-center justify-center">
                            <svg class="w-6 h-6 text-rust" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" d="M4 6h12M8 6V4.5A1.5 1.5 0 019.5 3h1A1.5 1.5 0 0112 4.5V6m2 0v9.5A1.5 1.5 0 0112.5 17h-5A1.5 1.5 0 016 15.5V6h8z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="font-display font-semibold text-ink mb-1">Hapus "<span id="delete-product-name">produk ini</span>"?</p>
                    <p class="text-sm text-steel mb-5">Data & riwayat terkait tidak bisa dikembalikan.</p>
                    <form id="form-delete-product" action="" method="POST" class="flex gap-2">
                        @csrf
                        @method('DELETE')
                        <button type="button" data-modal-hide="modal-delete-product" class="flex-1 px-4 py-2.5 text-sm font-medium text-ink-soft bg-canvas-alt rounded-xl hover:bg-gray-200 transition-colors">Batal</button>
                        <button type="submit" class="flex-1 px-4 py-2.5 text-sm font-semibold text-white bg-rust rounded-xl hover:bg-rust/90 transition-colors shadow-sm shadow-rust/30">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>