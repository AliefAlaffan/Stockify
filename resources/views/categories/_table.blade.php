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
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $categories->links() }}
        </div>
    @else
        <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
            <div class="empty-icon bg-canvas-alt mb-4">
                <svg class="w-8 h-8 text-steel-light" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v8a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/></svg>
            </div>
            <p class="font-medium text-ink mb-1">
                {{ request('search') ? 'Tidak ada kategori yang cocok' : 'Belum ada kategori' }}
            </p>
            <p class="text-sm text-steel mb-4">
                {{ request('search') ? 'Coba kata kunci lain.' : 'Kategori membantu mengelompokkan produk di gudang kamu.' }}
            </p>
            @unless (request('search'))
                <button type="button" data-modal-target="modal-add-category" data-modal-toggle="modal-add-category"
                    class="btn-primary px-4 py-2 text-sm font-semibold text-white rounded-xl">
                    Tambah Kategori Pertama
                </button>
            @endunless
        </div>
    @endif
</div>