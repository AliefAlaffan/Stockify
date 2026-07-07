@php use Illuminate\Support\Facades\Storage; @endphp
<x-app-layout>
    <x-slot name="header">Edit Produk</x-slot>

    <div class="flex items-center gap-3 mb-5">
        <a href="{{ route('products.index') }}" class="icon-btn text-steel hover:bg-canvas-alt !rounded-lg">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" d="M12.5 15l-5-5 5-5"/></svg>
        </a>
        <div>
            <p class="font-mono-data text-[11px] tracking-widest text-steel uppercase mb-0.5">Data Master / Produk</p>
            <h1 class="font-display text-xl font-semibold text-ink">Edit: {{ $product->name }}</h1>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 max-w-3xl">
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block mb-1.5 text-sm font-medium text-ink">Kategori</label>
                    <select name="category_id" class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="mt-1.5 text-sm text-rust">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block mb-1.5 text-sm font-medium text-ink">Supplier</label>
                    <select name="supplier_id" class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id', $product->supplier_id) == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                    @error('supplier_id') <p class="mt-1.5 text-sm text-rust">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block mb-1.5 text-sm font-medium text-ink">Nama Produk</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}"
                        class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
                    @error('name') <p class="mt-1.5 text-sm text-rust">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block mb-1.5 text-sm font-medium text-ink">SKU</label>
                    <input type="text" name="sku" value="{{ old('sku', $product->sku) }}"
                        class="bg-canvas-alt/60 border border-gray-200 text-ink font-mono-data text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
                    @error('sku') <p class="mt-1.5 text-sm text-rust">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block mb-1.5 text-sm font-medium text-ink">Deskripsi</label>
                <textarea name="description" rows="3"
                    class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block mb-1.5 text-sm font-medium text-ink">Harga Beli</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-steel text-sm">Rp</span>
                        <input type="number" step="0.01" name="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}"
                            class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 pl-9 transition-colors">
                    </div>
                    @error('purchase_price') <p class="mt-1.5 text-sm text-rust">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block mb-1.5 text-sm font-medium text-ink">Harga Jual</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-steel text-sm">Rp</span>
                        <input type="number" step="0.01" name="selling_price" value="{{ old('selling_price', $product->selling_price) }}"
                            class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 pl-9 transition-colors">
                    </div>
                    @error('selling_price') <p class="mt-1.5 text-sm text-rust">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block mb-1.5 text-sm font-medium text-ink">Stok Minimum</label>
                    <input type="number" name="minimum_stock" value="{{ old('minimum_stock', $product->minimum_stock) }}"
                        class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
                    @error('minimum_stock') <p class="mt-1.5 text-sm text-rust">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block mb-1.5 text-sm font-medium text-ink">Gambar Produk</label>
                <label id="drop-zone" class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-gray-200 rounded-2xl cursor-pointer bg-canvas-alt/40 hover:bg-canvas-alt/70 hover:border-brand/40 transition-colors overflow-hidden">
                    <div id="drop-zone-content" class="flex flex-col items-center justify-center pt-5 pb-6 pointer-events-none">
                        @if ($product->image)
                            <img src="{{ Storage::url($product->image) }}" class="w-16 h-16 object-cover rounded-xl border border-gray-200 mb-2">
                            <p class="text-sm text-ink-soft"><span class="font-medium">Klik untuk ganti</span> gambar produk</p>
                        @else
                            <svg class="w-8 h-8 mb-2 text-steel-light" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="text-sm text-steel"><span class="font-medium text-ink-soft">Klik untuk upload</span> gambar produk</p>
                        @endif
                    </div>
                    <input id="image-input" type="file" name="image" accept="image/*" class="hidden" />
                </label>
                @error('image') <p class="mt-1.5 text-sm text-rust">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-2 pt-3 border-t border-gray-100">
                <a href="{{ route('products.index') }}" class="px-4 py-2.5 text-sm font-medium text-ink-soft bg-canvas-alt rounded-xl hover:bg-gray-200 transition-colors">Batal</a>
                <button type="submit" class="btn-primary px-5 py-2.5 text-sm font-semibold text-white rounded-xl">Update Produk</button>
            </div>
        </form>
    </div>

    <script>
        const imageInput = document.getElementById('image-input');
        const dropZoneContent = document.getElementById('drop-zone-content');
        imageInput.addEventListener('change', () => {
            if (imageInput.files.length > 0) {
                const file = imageInput.files[0];
                const reader = new FileReader();
                reader.onload = (e) => {
                    dropZoneContent.innerHTML = `
                        <img src="${e.target.result}" class="w-16 h-16 object-cover rounded-xl border border-gray-200 mb-2">
                        <p class="text-sm font-medium text-ink-soft">${file.name}</p>
                        <p class="text-xs text-brand-dark mt-0.5">Klik untuk ganti gambar</p>
                    `;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>