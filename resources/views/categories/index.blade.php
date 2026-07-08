<x-app-layout>
    <x-slot name="header">Kategori</x-slot>

    @if (session('success'))
        <div class="flex items-center gap-2.5 p-4 mb-5 text-sm text-brand-dark rounded-2xl bg-brand/8 border border-brand/15 animate-fade-up" role="alert">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="flex items-center justify-between mb-5">
        <div>
            <p class="font-mono-data text-[11px] tracking-widest text-steel uppercase mb-1">Data Master</p>
            <h1 class="font-display text-xl font-semibold text-ink">Kategori Produk</h1>
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
                    Tambah Kategori
                </a>
            </div>
    </div>

    <div class="relative mb-5 max-w-sm">
        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-steel-light pointer-events-none" fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" d="M17.5 17.5l-3.6-3.6m1.9-4.65a6.55 6.55 0 11-13.1 0 6.55 6.55 0 0113.1 0z"/>
        </svg>
        <input type="text" id="search-input" value="{{ request('search') }}"
            placeholder="Cari nama atau deskripsi kategori..."
            class="bg-white border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full pl-10 pr-9 py-2.5 transition-colors">
        <button type="button" id="search-clear"
            class="absolute right-3 top-1/2 -translate-y-1/2 text-steel-light hover:text-steel {{ request('search') ? '' : 'hidden' }}">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
        </button>
    </div>

    <div id="table-container">
        @include('categories._table', ['categories' => $categories])
    </div>

    <!-- Modal Tambah -->
    <div id="modal-add-category" tabindex="-1" aria-hidden="true" class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center bg-ink/20 modal-backdrop">
        <div class="modal-panel relative w-full max-w-md">
            <div class="relative bg-white rounded-2xl shadow-xl">
                <div class="flex items-center justify-between p-5 border-b border-gray-100">
                    <h3 class="font-display text-lg font-semibold text-ink">Tambah Kategori</h3>
                    <button type="button" data-modal-hide="modal-add-category" class="icon-btn text-steel hover:bg-canvas-alt">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                    </button>
                </div>
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="p-5 space-y-4">
                        <div>
                            <label class="block mb-1.5 text-sm font-medium text-ink">Nama</label>
                            <input type="text" name="name" required
                                class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
                        </div>
                        <div>
                            <label class="block mb-1.5 text-sm font-medium text-ink">Deskripsi</label>
                            <textarea name="description" rows="3"
                                class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors"></textarea>
                        </div>
                    </div>
                    <div class="flex items-center justify-end gap-2 p-5 border-t border-gray-100">
                        <button type="button" data-modal-hide="modal-add-category" class="px-4 py-2 text-sm font-medium text-ink-soft bg-canvas-alt rounded-xl hover:bg-gray-200 transition-colors">Batal</button>
                        <button type="submit" class="btn-primary px-4 py-2 text-sm font-semibold text-white rounded-xl">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="modal-edit-category" tabindex="-1" aria-hidden="true" class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center bg-ink/20 modal-backdrop">
        <div class="modal-panel relative w-full max-w-md">
            <div class="relative bg-white rounded-2xl shadow-xl">
                <div class="flex items-center justify-between p-5 border-b border-gray-100">
                    <h3 class="font-display text-lg font-semibold text-ink">Edit Kategori</h3>
                    <button type="button" data-modal-hide="modal-edit-category" class="icon-btn text-steel hover:bg-canvas-alt">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                    </button>
                </div>
                <form id="form-edit-category" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="p-5 space-y-4">
                        <div>
                            <label class="block mb-1.5 text-sm font-medium text-ink">Nama</label>
                            <input type="text" name="name" id="edit-category-name" required
                                class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
                        </div>
                        <div>
                            <label class="block mb-1.5 text-sm font-medium text-ink">Deskripsi</label>
                            <textarea name="description" id="edit-category-description" rows="3"
                                class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors"></textarea>
                        </div>
                    </div>
                    <div class="flex items-center justify-end gap-2 p-5 border-t border-gray-100">
                        <button type="button" data-modal-hide="modal-edit-category" class="px-4 py-2 text-sm font-medium text-ink-soft bg-canvas-alt rounded-xl hover:bg-gray-200 transition-colors">Batal</button>
                        <button type="submit" class="btn-primary px-4 py-2 text-sm font-semibold text-white rounded-xl">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="modal-delete-category" tabindex="-1" aria-hidden="true" class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center bg-ink/30 modal-backdrop">
        <div class="modal-panel relative w-full max-w-[22rem]">
            <div class="relative bg-white rounded-2xl shadow-2xl text-center overflow-hidden">
                <div class="p-6 pt-7">
                    <div class="relative w-14 h-14 mx-auto mb-4">
                        <span class="absolute inset-0 rounded-full bg-rust/15 animate-ping-slow"></span>
                        <div class="relative w-14 h-14 rounded-full bg-rust/10 flex items-center justify-center">
                            <svg class="w-6 h-6 text-rust" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" d="M4 6h12M8 6V4.5A1.5 1.5 0 019.5 3h1A1.5 1.5 0 0112 4.5V6m2 0v9.5A1.5 1.5 0 0112.5 17h-5A1.5 1.5 0 016 15.5V6h8z"/></svg>
                        </div>
                    </div>
                    <p class="font-display font-semibold text-ink mb-1">Hapus "<span id="delete-category-name">kategori ini</span>"?</p>
                    <p class="text-sm text-steel mb-5">Data yang dihapus tidak bisa dikembalikan.</p>
                    <form id="form-delete-category" action="" method="POST" class="flex gap-2">
                        @csrf
                        @method('DELETE')
                        <button type="button" data-modal-hide="modal-delete-category" class="flex-1 px-4 py-2.5 text-sm font-medium text-ink-soft bg-canvas-alt rounded-xl hover:bg-gray-200 transition-colors">Batal</button>
                        <button type="submit" class="flex-1 px-4 py-2.5 text-sm font-semibold text-white bg-rust rounded-xl hover:bg-rust/90 transition-colors shadow-sm shadow-rust/30">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function fillEditCategoryModal(id, name, description) {
            document.getElementById('edit-category-name').value = name;
            document.getElementById('edit-category-description').value = description;
            document.getElementById('form-edit-category').action = `/categories/${id}`;
        }
    </script>

    @include('components.live-search-script', ['baseUrl' => route('categories.index')])
</x-app-layout>