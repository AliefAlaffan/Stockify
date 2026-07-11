<x-app-layout>
    <x-slot name="header">Manajemen Pengguna</x-slot>

    @if (session('success'))
        <div class="flex items-center gap-2.5 p-4 mb-5 text-sm text-brand-dark rounded-2xl bg-brand/8 border border-brand/15 animate-fade-up" role="alert">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="flex items-center gap-2.5 p-4 mb-5 text-sm text-rust rounded-2xl bg-rust/8 border border-rust/15 animate-fade-up" role="alert">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.7" stroke-linecap="round" d="M10 6v4m0 4h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <div class="flex items-center justify-between mb-5">
        <div>
            <p class="font-mono-data text-[11px] tracking-widest text-steel uppercase mb-1">Administrasi</p>
            <h1 class="font-display text-xl font-semibold text-ink">Manajemen Pengguna</h1>
        </div>
        <a href="{{ route('users.create') }}" class="btn-primary flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white rounded-xl">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/></svg>
            Tambah Pengguna
        </a>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-5">
        <div class="flex flex-wrap items-end gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <label class="block mb-1.5 text-xs font-medium text-ink-soft uppercase tracking-wide">Cari</label>
                <svg class="absolute left-3 top-[35px] w-4 h-4 text-steel-light pointer-events-none" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" d="M17.5 17.5l-3.6-3.6m1.9-4.65a6.55 6.55 0 11-13.1 0 6.55 6.55 0 0113.1 0z"/>
                </svg>
                <input type="text" id="search-input" value="{{ request('search') }}" placeholder="Nama atau email..."
                    class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full pl-9 pr-9 p-2.5 transition-colors">
                <button type="button" id="search-clear"
                    class="absolute right-3 top-[38px] text-steel-light hover:text-steel {{ request('search') ? '' : 'hidden' }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                </button>
            </div>
            <div class="min-w-[160px]">
                <label class="block mb-1.5 text-xs font-medium text-ink-soft uppercase tracking-wide">Role</label>
                <select id="role-filter" class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
                    <option value="">Semua Role</option>
                    <option value="Admin" {{ request('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="Manajer Gudang" {{ request('role') == 'Manajer Gudang' ? 'selected' : '' }}>Manajer Gudang</option>
                    <option value="Staff Gudang" {{ request('role') == 'Staff Gudang' ? 'selected' : '' }}>Staff Gudang</option>
                </select>
            </div>
        </div>
    </div>

    <div id="table-container">
        @include('users._table', ['users' => $users])
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="modal-delete-user" tabindex="-1" aria-hidden="true" class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center bg-ink/30 modal-backdrop">
        <div class="modal-panel relative w-full max-w-[22rem]">
            <div class="relative bg-white rounded-2xl shadow-2xl text-center overflow-hidden">
                <div class="p-6 pt-7">
                    <div class="relative w-14 h-14 mx-auto mb-4">
                        <span class="absolute inset-0 rounded-full bg-rust/15 animate-ping-slow"></span>
                        <div class="relative w-14 h-14 rounded-full bg-rust/10 flex items-center justify-center">
                            <svg class="w-6 h-6 text-rust" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" d="M4 6h12M8 6V4.5A1.5 1.5 0 019.5 3h1A1.5 1.5 0 0112 4.5V6m2 0v9.5A1.5 1.5 0 0112.5 17h-5A1.5 1.5 0 016 15.5V6h8z"/></svg>
                        </div>
                    </div>
                    <p class="font-display font-semibold text-ink mb-1">Hapus pengguna "<span id="delete-user-name">ini</span>"?</p>
                    <p class="text-sm text-steel mb-5">Akun tidak bisa login lagi setelah dihapus.</p>
                    <form id="form-delete-user" action="" method="POST" class="flex gap-2">
                        @csrf
                        @method('DELETE')
                        <button type="button" data-modal-hide="modal-delete-user" class="flex-1 px-4 py-2.5 text-sm font-medium text-ink-soft bg-canvas-alt rounded-xl hover:bg-gray-200 transition-colors">Batal</button>
                        <button type="submit" class="flex-1 px-4 py-2.5 text-sm font-semibold text-white bg-rust rounded-xl hover:bg-rust/90 transition-colors shadow-sm shadow-rust/30">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Hapus Akun Admin Sendiri (butuh password) -->
<div id="modal-delete-own-admin" tabindex="-1" aria-hidden="true" class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center bg-ink/30 modal-backdrop">
    <div class="modal-panel relative w-full max-w-[24rem]">
        <div class="relative bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="p-6 pt-7 text-center">
                <div class="relative w-14 h-14 mx-auto mb-4">
                    <span class="absolute inset-0 rounded-full bg-rust/15 animate-ping-slow"></span>
                    <div class="relative w-14 h-14 rounded-full bg-rust/10 flex items-center justify-center">
                        <svg class="w-6 h-6 text-rust" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" d="M4 6h12M8 6V4.5A1.5 1.5 0 019.5 3h1A1.5 1.5 0 0112 4.5V6m2 0v9.5A1.5 1.5 0 0112.5 17h-5A1.5 1.5 0 016 15.5V6h8z"/></svg>
                    </div>
                </div>
                <p class="font-display font-semibold text-ink mb-1">Hapus akunmu secara permanen?</p>
                <p class="text-sm text-steel mb-4">Kamu akan langsung logout. Masukkan password untuk konfirmasi.</p>
            </div>
            <form action="{{ route('users.destroy', auth()->id()) }}" method="POST" class="px-6 pb-6">
                @csrf
                @method('DELETE')
                <div class="text-left mb-4">
                    <label class="block mb-1.5 text-sm font-medium text-ink">Password</label>
                    <input type="password" name="password" required autocomplete="current-password"
                        class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-rust/25 focus:border-rust block w-full p-2.5 transition-colors"
                        placeholder="••••••••">
                    @error('password', 'userDeletion') <p class="mt-1.5 text-sm text-rust">{{ $message }}</p> @enderror
                </div>
                <div class="flex gap-2">
                    <button type="button" data-modal-hide="modal-delete-own-admin" class="flex-1 px-4 py-2.5 text-sm font-medium text-ink-soft bg-canvas-alt rounded-xl hover:bg-gray-200 transition-colors">Batal</button>
                    <button type="submit" class="flex-1 px-4 py-2.5 text-sm font-semibold text-white bg-rust rounded-xl hover:bg-rust/90 transition-colors shadow-sm shadow-rust/30">Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <script>
    (function () {
        const searchInput   = document.getElementById('search-input');
        const searchClear   = document.getElementById('search-clear');
        const roleFilter    = document.getElementById('role-filter');
        const tableContainer = document.getElementById('table-container');
        const baseUrl = @json(route('users.index'));
        let debounceTimer;

        function buildUrl() {
            const params = new URLSearchParams();
            if (searchInput.value.trim()) params.set('search', searchInput.value.trim());
            if (roleFilter.value) params.set('role', roleFilter.value);
            const qs = params.toString();
            return qs ? `${baseUrl}?${qs}` : baseUrl;
        }

        function fetchResults() {
            const url = buildUrl();
            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.text())
                .then(html => {
                    tableContainer.innerHTML = html;
                    window.history.replaceState({}, '', url);
                    searchClear.classList.toggle('hidden', !searchInput.value.trim());
                })
                .catch(() => {});
        }

        searchInput.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(fetchResults, 400);
        });

        roleFilter.addEventListener('change', fetchResults);

        searchClear.addEventListener('click', () => {
            searchInput.value = '';
            fetchResults();
        });

        document.addEventListener('click', function (e) {
            const link = e.target.closest('#table-container a[href*="page="]');
            if (!link) return;
            e.preventDefault();
            fetch(link.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.text())
                .then(html => {
                    tableContainer.innerHTML = html;
                    window.history.replaceState({}, '', link.href);
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
        });
    })();
    </script>
</x-app-layout>