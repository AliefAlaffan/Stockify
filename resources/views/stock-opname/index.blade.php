<x-app-layout>
    <x-slot name="header">Stock Opname</x-slot>

    @if (session('success'))
        <div class="flex items-center gap-2.5 p-4 mb-5 text-sm text-brand-dark rounded-2xl bg-brand/8 border border-brand/15 animate-fade-up" role="alert">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="mb-5">
        <p class="font-mono-data text-[11px] tracking-widest text-steel uppercase mb-1">Operasi</p>
        <h1 class="font-display text-xl font-semibold text-ink">Penyesuaian Stok Fisik</h1>
        <p class="text-sm text-steel mt-1">Masukkan hasil hitung fisik gudang — sistem otomatis mencatat penyesuaian jika ada selisih.</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-canvas-alt/70 text-[11px] text-steel uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3.5 font-semibold">Produk</th>
                    <th class="px-6 py-3.5 font-semibold">SKU</th>
                    <th class="px-6 py-3.5 font-semibold">Stok Sistem</th>
                    <th class="px-6 py-3.5 font-semibold">Jumlah Fisik</th>
                    <th class="px-6 py-3.5 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($products as $product)
                    <tr class="hover:bg-canvas-alt/40 transition-colors">
                        <td class="px-6 py-3.5 font-medium text-ink">{{ $product->name }}</td>
                        <td class="px-6 py-3.5">
                            <span class="font-mono-data text-xs px-2 py-1 bg-canvas-alt text-ink-soft rounded-md">{{ $product->sku }}</span>
                        </td>
                        <td class="px-6 py-3.5">
                            <span class="font-mono-data font-semibold text-ink">{{ $product->current_stock }}</span>
                        </td>
                        <td class="px-6 py-3.5">
                            <form action="{{ route('stock-opname.store') }}" method="POST" class="flex items-center gap-2" id="opname-form-{{ $product->id }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="date" value="{{ date('Y-m-d') }}">
                                <input type="number" name="physical_count" min="0" required
                                    placeholder="{{ $product->current_stock }}"
                                    class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-lg focus:ring-2 focus:ring-brand/30 focus:border-brand w-24 p-2 transition-colors">
                        </td>
                        <td class="px-6 py-3.5 text-right">
                                <button type="submit" class="btn-primary px-3.5 py-2 text-xs font-semibold text-white rounded-lg">Simpan</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center text-steel">Belum ada produk untuk diopname.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>