<x-app-layout>
    <x-slot name="header">Laporan Stok Barang</x-slot>

    <div class="flex items-center gap-3 mb-5">
        <a href="{{ route('reports.index') }}" class="icon-btn text-steel hover:bg-canvas-alt !rounded-lg">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" d="M12.5 15l-5-5 5-5"/></svg>
        </a>
        <div>
            <p class="font-mono-data text-[11px] tracking-widest text-steel uppercase mb-0.5">Laporan</p>
            <h1 class="font-display text-xl font-semibold text-ink">Stok Barang</h1>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-5">
        <form action="{{ route('reports.stock') }}" method="GET" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[160px]">
                <label class="block mb-1.5 text-xs font-medium text-ink-soft uppercase tracking-wide">Kategori</label>
                <select name="category_id" class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-[140px]">
                <label class="block mb-1.5 text-xs font-medium text-ink-soft uppercase tracking-wide">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}"
                    class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
            </div>
            <div class="flex-1 min-w-[140px]">
                <label class="block mb-1.5 text-xs font-medium text-ink-soft uppercase tracking-wide">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}"
                    class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
            </div>
            <div class="flex items-center gap-2">
                <button type="submit" class="btn-primary px-4 py-2.5 text-sm font-semibold text-white rounded-xl">Terapkan</button>
                <a href="{{ route('reports.stock.export.pdf', request()->query()) }}"
                    class="flex items-center gap-1.5 px-4 py-2.5 text-sm font-medium text-ink-soft bg-canvas-alt rounded-xl hover:bg-gray-200 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M10 3v10m0 0l-3.5-3.5M10 13l3.5-3.5M4 15v1a2 2 0 002 2h8a2 2 0 002-2v-1"/></svg>
                    PDF
                </a>
                <a href="{{ route('reports.stock.export.excel', request()->query()) }}"
                    class="flex items-center gap-1.5 px-4 py-2.5 text-sm font-medium text-ink-soft bg-canvas-alt rounded-xl hover:bg-gray-200 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M4 4h9l3 3v9a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/></svg>
                    Excel
                </a>
            </div>
        </form>
    </div>

    <!-- Ringkasan -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-5">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
            <p class="text-xs text-steel uppercase tracking-wide mb-1">Total Produk</p>
            <p class="font-display text-2xl font-semibold text-ink">{{ $summary['total_products'] }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
            <p class="text-xs text-steel uppercase tracking-wide mb-1">Total Unit Stok</p>
            <p class="font-display text-2xl font-semibold text-ink">{{ number_format($summary['total_units']) }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
            <p class="text-xs text-steel uppercase tracking-wide mb-1">Nilai Stok (Beli)</p>
            <p class="font-display text-2xl font-semibold text-ink">Rp {{ number_format($summary['total_value'], 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-rust/15 bg-rust/5 shadow-sm p-4">
            <p class="text-xs text-rust uppercase tracking-wide mb-1">Stok Menipis</p>
            <p class="font-display text-2xl font-semibold text-rust">{{ $summary['low_stock_count'] }}</p>
        </div>
    </div>

    <!-- Tabel -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        @if ($products->count() > 0)
            <table class="w-full text-sm text-left">
                <thead class="bg-canvas-alt/70 text-[11px] text-steel uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3.5 font-semibold">Produk</th>
                        <th class="px-6 py-3.5 font-semibold">Kategori</th>
                        <th class="px-6 py-3.5 font-semibold">Masuk (periode)</th>
                        <th class="px-6 py-3.5 font-semibold">Keluar (periode)</th>
                        <th class="px-6 py-3.5 font-semibold">Stok Akhir</th>
                        <th class="px-6 py-3.5 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach ($products as $product)
                        <tr class="hover:bg-canvas-alt/40 transition-colors">
                            <td class="px-6 py-3.5">
                                <p class="font-medium text-ink">{{ $product->name }}</p>
                                <span class="font-mono-data text-xs text-steel-light">{{ $product->sku }}</span>
                            </td>
                            <td class="px-6 py-3.5 text-ink-soft">{{ $product->category->name ?? '—' }}</td>
                            <td class="px-6 py-3.5">
                                <span class="font-mono-data text-sm font-semibold text-brand-dark">+{{ $product->period_in }}</span>
                            </td>
                            <td class="px-6 py-3.5">
                                <span class="font-mono-data text-sm font-semibold text-rust">-{{ $product->period_out }}</span>
                            </td>
                            <td class="px-6 py-3.5">
                                <span class="font-mono-data font-semibold text-ink">{{ $product->current_stock }}</span>
                            </td>
                            <td class="px-6 py-3.5">
                                @if ($product->current_stock <= $product->minimum_stock)
                                    <span class="stock-tag bg-rust/12 text-rust"><span class="stock-tag-dot bg-rust"></span>Menipis</span>
                                @else
                                    <span class="stock-tag bg-brand/12 text-brand-dark"><span class="stock-tag-dot bg-brand"></span>Aman</span>
                                @endif
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
                    <svg class="w-8 h-8 text-steel-light" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M9 17V7m6 10V7M4 21h16a1 1 0 001-1V4a1 1 0 00-1-1H4a1 1 0 00-1 1v16a1 1 0 001 1z"/></svg>
                </div>
                <p class="font-medium text-ink mb-1">Tidak ada data</p>
                <p class="text-sm text-steel">Coba ubah filter kategori atau rentang tanggal.</p>
            </div>
        @endif
    </div>
</x-app-layout>