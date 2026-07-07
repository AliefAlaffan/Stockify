<x-app-layout>
    <x-slot name="header">Atribut Produk</x-slot>

    <div class="flex items-center gap-3 mb-5">
        <a href="{{ route('products.show', $product->id) }}" class="icon-btn text-steel hover:bg-canvas-alt !rounded-lg">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" d="M12.5 15l-5-5 5-5"/></svg>
        </a>
        <div>
            <p class="font-mono-data text-[11px] tracking-widest text-steel uppercase mb-0.5">Data Master / Produk / Atribut</p>
            <h1 class="font-display text-xl font-semibold text-ink">{{ $product->name }}</h1>
        </div>
    </div>

    @if (session('success'))
        <div class="flex items-center gap-2.5 p-4 mb-5 text-sm text-brand-dark rounded-2xl bg-brand/8 border border-brand/15 animate-fade-up" role="alert">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <!-- Form Tambah -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 sticky top-20">
                <div class="flex items-center gap-2 mb-4">
                    <div class="icon-badge w-9 h-9 !rounded-lg bg-brand/10">
                        <svg class="w-4 h-4 text-brand-dark" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h2 class="font-display font-semibold text-ink text-sm">Tambah Atribut</h2>
                </div>
                <form action="{{ route('products.attributes.store', $product->id) }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block mb-1.5 text-xs font-medium text-ink-soft uppercase tracking-wide">Nama Atribut</label>
                        <input type="text" name="name" placeholder="cth: Warna" required
                            class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
                    </div>
                    <div>
                        <label class="block mb-1.5 text-xs font-medium text-ink-soft uppercase tracking-wide">Nilai</label>
                        <input type="text" name="value" placeholder="cth: Merah" required
                            class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
                    </div>
                    @error('name') <p class="text-sm text-rust">{{ $message }}</p> @enderror
                    @error('value') <p class="text-sm text-rust">{{ $message }}</p> @enderror
                    <button type="submit" class="btn-primary w-full px-4 py-2.5 text-sm font-semibold text-white rounded-xl">
                        Tambah Atribut
                    </button>
                </form>
            </div>
        </div>

        <!-- Daftar Atribut -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                @if ($attributes->count() > 0)
                    <div class="divide-y divide-gray-50">
                        @foreach ($attributes as $attribute)
                            <div class="flex flex-row flex-nowrap items-center gap-3 p-4 hover:bg-canvas-alt/40 transition-colors">
                                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-freight/10 flex-shrink-0">
                                    <svg class="w-4 h-4 text-freight" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M9 4.5H5.5a1 1 0 00-1 1V9m0 0l5.3 5.3a1 1 0 001.4 0l3.8-3.8a1 1 0 000-1.4L9.2 3.8"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0 overflow-hidden">
                                    <p class="text-xs text-steel uppercase tracking-wide truncate">{{ $attribute->name }}</p>
                                    <p class="font-medium text-ink text-sm truncate">{{ $attribute->value }}</p>
                                </div>
                                <div class="flex flex-row flex-shrink-0 items-center gap-1">
                                    <button type="button"
                                        data-modal-target="modal-edit-attribute"
                                        data-modal-toggle="modal-edit-attribute"
                                        onclick="fillEditAttributeModal({{ $attribute->id }}, '{{ addslashes($attribute->name) }}', '{{ addslashes($attribute->value) }}')"
                                        class="icon-btn text-freight hover:bg-freight/10" title="Edit">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M13.5 3.5a1.914 1.914 0 012.706 2.706L6.5 15.914 3 16.5l.586-3.5 9.914-9.5z"/></svg>
                                    </button>
                                    <button type="button"
                                        data-modal-target="modal-delete-attribute"
                                        data-modal-toggle="modal-delete-attribute"
                                        onclick="document.getElementById('form-delete-attribute').action = '{{ route('products.attributes.destroy', [$product->id, $attribute->id]) }}'; document.getElementById('delete-attribute-name').textContent = '{{ addslashes($attribute->name) }}: {{ addslashes($attribute->value) }}'"
                                        class="icon-btn text-rust hover:bg-rust/10" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M4 6h12M8 6V4.5A1.5 1.5 0 019.5 3h1A1.5 1.5 0 0112 4.5V6m2 0v9.5A1.5 1.5 0 0112.5 17h-5A1.5 1.5 0 016 15.5V6h8z"/></svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
                        <div class="empty-icon bg-canvas-alt mb-4">
                            <svg class="w-8 h-8 text-steel-light" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 2l2.4 7.2H22l-6 4.6 2.3 7.2-6.3-4.5L5.7 21l2.3-7.2-6-4.6h7.6z"/></svg>
                        </div>
                        <p class="font-medium text-ink mb-1">Belum ada atribut</p>
                        <p class="text-sm text-steel">Tambahkan atribut seperti ukuran, warna, atau berat lewat form di samping.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="modal-edit-attribute" tabindex="-1" aria-hidden="true" class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center bg-ink/20 modal-backdrop">
        <div class="modal-panel relative w-full max-w-md">
            <div class="relative bg-white rounded-2xl shadow-xl">
                <div class="flex items-center justify-between p-5 border-b border-gray-100">
                    <h3 class="font-display text-lg font-semibold text-ink">Edit Atribut</h3>
                    <button type="button" data-modal-hide="modal-edit-attribute" class="icon-btn text-steel hover:bg-canvas-alt">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                    </button>
                </div>
                <form id="form-edit-attribute" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="p-5 space-y-4">
                        <div>
                            <label class="block mb-1.5 text-sm font-medium text-ink">Nama Atribut</label>
                            <input type="text" name="name" id="edit-attribute-name" required
                                class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
                        </div>
                        <div>
                            <label class="block mb-1.5 text-sm font-medium text-ink">Nilai</label>
                            <input type="text" name="value" id="edit-attribute-value" required
                                class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
                        </div>
                    </div>
                    <div class="flex items-center justify-end gap-2 p-5 border-t border-gray-100">
                        <button type="button" data-modal-hide="modal-edit-attribute" class="px-4 py-2 text-sm font-medium text-ink-soft bg-canvas-alt rounded-xl hover:bg-gray-200 transition-colors">Batal</button>
                        <button type="submit" class="btn-primary px-4 py-2 text-sm font-semibold text-white rounded-xl">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="modal-delete-attribute" tabindex="-1" aria-hidden="true" class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center bg-ink/30 modal-backdrop">
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
                    <p class="font-display font-semibold text-ink mb-1">Hapus "<span id="delete-attribute-name">atribut ini</span>"?</p>
                    <p class="text-sm text-steel mb-5">Tindakan ini tidak bisa dibatalkan.</p>
                    <form id="form-delete-attribute" action="" method="POST" class="flex gap-2">
                        @csrf
                        @method('DELETE')
                        <button type="button" data-modal-hide="modal-delete-attribute" class="flex-1 px-4 py-2.5 text-sm font-medium text-ink-soft bg-canvas-alt rounded-xl hover:bg-gray-200 transition-colors">Batal</button>
                        <button type="submit" class="flex-1 px-4 py-2.5 text-sm font-semibold text-white bg-rust rounded-xl hover:bg-rust/90 transition-colors shadow-sm shadow-rust/30">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function fillEditAttributeModal(id, name, value) {
            document.getElementById('edit-attribute-name').value = name;
            document.getElementById('edit-attribute-value').value = value;
            document.getElementById('form-edit-attribute').action = `/products/{{ $product->id }}/attributes/${id}`;
        }
    </script>
</x-app-layout>