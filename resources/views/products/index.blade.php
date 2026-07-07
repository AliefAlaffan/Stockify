<x-app-layout>
    <x-slot name="header">Produk</x-slot>

    @if (session('success'))
        <div class="flex items-center gap-2.5 p-4 mb-5 text-sm text-brand-dark rounded-2xl bg-brand/8 border border-brand/15 animate-fade-up" role="alert">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('import_summary'))
        <div class="flex items-start gap-2.5 p-4 mb-5 text-sm rounded-2xl {{ session('import_errors') ? 'text-amber-dark bg-amber/8 border border-amber/15' : 'text-brand-dark bg-brand/8 border border-brand/15' }} animate-fade-up" role="alert">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" d="M10 6v4m0 4h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <p class="font-medium">{{ session('import_summary') }}</p>
                @if (session('import_errors'))
                    <ul class="mt-2 space-y-1 text-xs list-disc list-inside">
                        @foreach (session('import_errors') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    @endif

    <div class="flex items-center justify-between mb-5">
        <div>
            <p class="font-mono-data text-[11px] tracking-widest text-steel uppercase mb-1">Data Master</p>
            <h1 class="font-display text-xl font-semibold text-ink">Produk</h1>
        </div>
       <div class="flex items-center justify-between mb-5">
    <div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('products.export', request()->only('search')) }}"
                    class="flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-ink-soft bg-canvas-alt rounded-xl hover:bg-gray-200 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M10 3v10m0 0l-3.5-3.5M10 13l3.5-3.5M4 15v1a2 2 0 002 2h8a2 2 0 002-2v-1"/></svg>
                    Export
                </a>
                <button type="button" data-modal-target="modal-import-product" data-modal-toggle="modal-import-product"
                    class="flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-ink-soft bg-canvas-alt rounded-xl hover:bg-gray-200 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M10 13V3m0 0L6.5 6.5M10 3l3.5 3.5M4 15v1a2 2 0 002 2h8a2 2 0 002-2v-1"/></svg>
                    Import
                </button>
                <a href="{{ route('products.create') }}"
                    class="btn-primary flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white rounded-xl">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/></svg>
                    Tambah Produk
                </a>
            </div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="relative mb-5 max-w-sm">
        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-steel-light pointer-events-none" fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" d="M17.5 17.5l-3.6-3.6m1.9-4.65a6.55 6.55 0 11-13.1 0 6.55 6.55 0 0113.1 0z"/>
        </svg>
        <input type="text" id="search-input" value="{{ request('search') }}"
            placeholder="Cari nama produk atau SKU..."
            class="bg-white border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full pl-10 pr-9 py-2.5 transition-colors">
        <button type="button" id="search-clear"
            class="absolute right-3 top-1/2 -translate-y-1/2 text-steel-light hover:text-steel {{ request('search') ? '' : 'hidden' }}">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
        </button>
    </div>

    <div id="table-container">
        @include('products._table', ['products' => $products])
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="modal-delete-product" tabindex="-1" aria-hidden="true" class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center bg-ink/30 modal-backdrop">
        <div class="modal-panel relative w-full max-w-[22rem]">
            <div class="relative bg-white rounded-2xl shadow-2xl text-center overflow-hidden">
                <div class="p-6 pt-7">
                    <div class="relative w-14 h-14 mx-auto mb-4">
                        <span class="absolute inset-0 rounded-full bg-rust/15 animate-ping-slow"></span>
                        <div class="relative w-14 h-14 rounded-full bg-rust/10 flex items-center justify-center">
                            <svg class="w-6 h-6 text-rust" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" d="M4 6h12M8 6V4.5A1.5 1.5 0 019.5 3h1A1.5 1.5 0 0112 4.5V6m2 0v9.5A1.5 1.5 0 0112.5 17h-5A1.5 1.5 0 016 15.5V6h8z"/></svg>
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

    <!-- Modal Import -->
    <div id="modal-import-product" tabindex="-1" aria-hidden="true" class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center bg-ink/20 modal-backdrop">
        <div class="modal-panel relative w-full max-w-md">
            <div class="relative bg-white rounded-2xl shadow-xl">
                <div class="flex items-center justify-between p-5 border-b border-gray-100">
                    <h3 class="font-display text-lg font-semibold text-ink">Import Produk</h3>
                    <button type="button" data-modal-hide="modal-import-product" class="icon-btn text-steel hover:bg-canvas-alt">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                    </button>
                </div>

                <div class="p-5 space-y-4">
                    <div class="flex items-start gap-2.5 p-3 bg-canvas-alt/60 rounded-xl">
                        <svg class="w-4 h-4 text-steel flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" d="M10 6v4m0 4h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-xs text-steel leading-relaxed">
                            Produk dengan SKU yang sudah ada akan <strong>diperbarui</strong>, SKU baru akan <strong>ditambahkan</strong>. Kategori & supplier yang belum ada akan otomatis dibuat.
                        </p>
                    </div>

                    <a href="{{ route('products.import.template') }}" class="flex items-center gap-2 text-sm font-medium text-brand-dark hover:underline">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M10 3v10m0 0l-3.5-3.5M10 13l3.5-3.5M4 15v1a2 2 0 002 2h8a2 2 0 002-2v-1"/></svg>
                        Download Template Excel
                    </a>

                    <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label class="block mb-1.5 text-sm font-medium text-ink">Pilih File (.xlsx, .xls, .csv)</label>
                        <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                            class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-brand/10 file:text-brand-dark">
                        @error('file') <p class="mt-1.5 text-sm text-rust">{{ $message }}</p> @enderror

                        <div class="flex items-center justify-end gap-2 pt-4 mt-4 border-t border-gray-100">
                            <button type="button" data-modal-hide="modal-import-product" class="px-4 py-2 text-sm font-medium text-ink-soft bg-canvas-alt rounded-xl hover:bg-gray-200 transition-colors">Batal</button>
                            <button type="submit" class="btn-primary px-4 py-2 text-sm font-semibold text-white rounded-xl">Upload & Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('components.live-search-script', ['baseUrl' => route('products.index')])
</x-app-layout>