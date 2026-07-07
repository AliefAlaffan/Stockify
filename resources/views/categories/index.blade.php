<x-app-layout>
    <x-slot name="header">Kategori</x-slot>

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
            <h1 class="font-display text-xl font-semibold text-ink">Kategori Produk</h1>
        </div>
        <button type="button" data-modal-target="modal-add-category" data-modal-toggle="modal-add-category"
            class="btn-primary flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white rounded-xl">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
            </svg>
            Tambah Kategori
        </button>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        @if ($categories->count() > 0)
            <table class="w-full text-sm text-left">
                <thead class="bg-canvas-alt/70 text-[11px] text-steel uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3.5 font-semibold">Nama</th>
                        <th class="px-6 py-3.5 font-semibold">Deskripsi</th>
                        <th class="px-6 py-3.5 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach ($categories as $category)
                        <tr class="table-row hover:bg-canvas-alt/40">
                            <td class="px-6 py-4">
                                <span class="font-medium text-ink">{{ $category->name }}</span>
                            </td>
                            <td class="px-6 py-4 text-ink-soft">{{ $category->description ?? '—' }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center gap-1">
                                    <button type="button"
                                        data-modal-target="modal-edit-category"
                                        data-modal-toggle="modal-edit-category"
                                        onclick="fillEditCategoryModal({{ $category->id }}, '{{ addslashes($category->name) }}', '{{ addslashes($category->description ?? '') }}')"
                                        class="icon-btn text-freight hover:bg-freight/10" title="Edit">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M13.5 3.5a1.914 1.914 0 012.706 2.706L6.5 15.914 3 16.5l.586-3.5 9.914-9.5z"/></svg>
                                    </button>
                                    <button type="button"
                                        data-modal-target="modal-delete-category"
                                        data-modal-toggle="modal-delete-category"
                                        onclick="document.getElementById('form-delete-category').action = '{{ route('categories.destroy', $category->id) }}'; document.getElementById('delete-category-name').textContent = '{{ addslashes($category->name) }}'"
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
                    <svg class="w-8 h-8 text-steel-light" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v8a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/></svg>
                </div>
                <p class="font-medium text-ink mb-1">Belum ada kategori</p>
                <p class="text-sm text-steel mb-4">Kategori membantu mengelompokkan produk di gudang kamu.</p>
                <button type="button" data-modal-target="modal-add-category" data-modal-toggle="modal-add-category"
                    class="btn-primary px-4 py-2 text-sm font-semibold text-white rounded-xl">
                    Tambah Kategori Pertama
                </button>
            </div>
        @endif
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
                            <svg class="w-6 h-6 text-rust" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" d="M4 6h12M8 6V4.5A1.5 1.5 0 019.5 3h1A1.5 1.5 0 0112 4.5V6m2 0v9.5A1.5 1.5 0 0112.5 17h-5A1.5 1.5 0 016 15.5V6h8z"/>
                            </svg>
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
</x-app-layout>