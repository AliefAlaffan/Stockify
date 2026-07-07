<x-app-layout>
    <x-slot name="header">Catat Barang Masuk</x-slot>

    <div class="flex items-center gap-3 mb-5">
        <a href="{{ route('stock-transactions.in.index') }}" class="icon-btn text-steel hover:bg-canvas-alt !rounded-lg">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" d="M12.5 15l-5-5 5-5"/></svg>
        </a>
        <div>
            <p class="font-mono-data text-[11px] tracking-widest text-steel uppercase mb-0.5">Operasi / Barang Masuk</p>
            <h1 class="font-display text-xl font-semibold text-ink">Catat Penerimaan Barang</h1>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 max-w-lg">
        <div class="flex items-center gap-2 mb-5 pb-5 border-b border-gray-100">
            <div class="icon-badge w-9 h-9 !rounded-lg bg-brand/10">
                <svg class="w-4 h-4 text-brand-dark" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V3a1 1 0 012 0v9.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
            </div>
            <p class="text-sm text-steel">Transaksi akan berstatus <span class="font-semibold text-amber-dark">Pending</span> sampai dikonfirmasi Staff Gudang.</p>
        </div>

        <form action="{{ route('stock-transactions.in.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block mb-1.5 text-sm font-medium text-ink">Produk</label>
                <select name="product_id" class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
                    <option value="">— Pilih Produk —</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }} ({{ $product->sku }})</option>
                    @endforeach
                </select>
                @error('product_id') <p class="mt-1.5 text-sm text-rust">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block mb-1.5 text-sm font-medium text-ink">Jumlah</label>
                <input type="number" name="quantity" min="1" value="{{ old('quantity') }}"
                    class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
                @error('quantity') <p class="mt-1.5 text-sm text-rust">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block mb-1.5 text-sm font-medium text-ink">Tanggal</label>
                <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}"
                    class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
                @error('date') <p class="mt-1.5 text-sm text-rust">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block mb-1.5 text-sm font-medium text-ink">Catatan</label>
                <textarea name="notes" rows="3"
                    class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">{{ old('notes') }}</textarea>
            </div>
            <div class="flex justify-end gap-2 pt-3 border-t border-gray-100">
                <a href="{{ route('stock-transactions.in.index') }}" class="px-4 py-2.5 text-sm font-medium text-ink-soft bg-canvas-alt rounded-xl hover:bg-gray-200 transition-colors">Batal</a>
                <button type="submit" class="btn-primary px-5 py-2.5 text-sm font-semibold text-white rounded-xl">Simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>