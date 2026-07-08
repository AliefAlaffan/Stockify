<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    @if ($suppliers->count() > 0)
        <table class="w-full text-sm text-left">
            <thead class="bg-canvas-alt/70 text-[11px] text-steel uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3.5 font-semibold">Nama</th>
                    <th class="px-6 py-3.5 font-semibold">Alamat</th>
                    <th class="px-6 py-3.5 font-semibold">Telepon</th>
                    <th class="px-6 py-3.5 font-semibold">Email</th>
                    @if (auth()->user()->role === 'Admin')  
                    <th class="px-6 py-3.5 font-semibold text-right">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach ($suppliers as $supplier)
                    <tr class="table-row hover:bg-canvas-alt/40">
                        <td class="px-6 py-4">
                            <span class="font-medium text-ink">{{ $supplier->name }}</span>
                        </td>
                        <td class="px-6 py-4 text-ink-soft max-w-xs truncate">{{ $supplier->address ?? '—' }}</td>
                        <td class="px-6 py-4 text-ink-soft font-mono-data text-xs">{{ $supplier->phone ?? '—' }}</td>
                        <td class="px-6 py-4 text-ink-soft">{{ $supplier->email ?? '—' }}</td>
                        @if (auth()->user()->role === 'Admin')
                        <td class="px-6 py-4 text-right">
                            <div class="inline-flex items-center gap-1">
                                <button type="button"
                                    data-modal-target="modal-edit-supplier"
                                    data-modal-toggle="modal-edit-supplier"
                                    onclick="fillEditSupplierModal({{ $supplier->id }}, '{{ addslashes($supplier->name) }}', '{{ addslashes($supplier->address ?? '') }}', '{{ addslashes($supplier->phone ?? '') }}', '{{ addslashes($supplier->email ?? '') }}')"
                                    class="icon-btn text-freight hover:bg-freight/10" title="Edit">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M13.5 3.5a1.914 1.914 0 012.706 2.706L6.5 15.914 3 16.5l.586-3.5 9.914-9.5z"/></svg>
                                </button>
                                <button type="button"
                                    data-modal-target="modal-delete-supplier"
                                    data-modal-toggle="modal-delete-supplier"
                                    onclick="document.getElementById('form-delete-supplier').action = '{{ route('suppliers.destroy', $supplier->id) }}'; document.getElementById('delete-supplier-name').textContent = '{{ addslashes($supplier->name) }}'"
                                    class="icon-btn text-rust hover:bg-rust/10" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M4 6h12M8 6V4.5A1.5 1.5 0 019.5 3h1A1.5 1.5 0 0112 4.5V6m2 0v9.5A1.5 1.5 0 0112.5 17h-5A1.5 1.5 0 016 15.5V6h8z"/></svg>
                                </button>
                            </div>
                        </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $suppliers->links() }}
        </div>
    @else
        <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
            <div class="empty-icon bg-canvas-alt mb-4">
                <svg class="w-8 h-8 text-steel-light" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M3 7l2-3h14l2 3M3 7v11a1 1 0 001 1h16a1 1 0 001-1V7M3 7h18M8 11h8"/></svg>
            </div>
            <p class="font-medium text-ink mb-1">
                {{ request('search') ? 'Tidak ada supplier yang cocok' : 'Belum ada supplier' }}
            </p>
            <p class="text-sm text-steel mb-4">
                {{ request('search') ? 'Coba kata kunci lain.' : 'Tambahkan supplier untuk mulai mencatat sumber barang.' }}
            </p>
            @unless (request('search'))
                <button type="button" data-modal-target="modal-add-supplier" data-modal-toggle="modal-add-supplier"
                    class="btn-primary px-4 py-2 text-sm font-semibold text-white rounded-xl">
                    Tambah Supplier Pertama
                </button>
            @endunless
        </div>
    @endif
</div>