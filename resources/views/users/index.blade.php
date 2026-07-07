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
        <form action="{{ route('users.index') }}" method="GET" class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[200px]">
                <label class="block mb-1.5 text-xs font-medium text-ink-soft uppercase tracking-wide">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama atau email..."
                    class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
            </div>
            <div class="min-w-[160px]">
                <label class="block mb-1.5 text-xs font-medium text-ink-soft uppercase tracking-wide">Role</label>
                <select name="role" class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
                    <option value="">Semua Role</option>
                    <option value="Admin" {{ request('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="Manajer Gudang" {{ request('role') == 'Manajer Gudang' ? 'selected' : '' }}>Manajer Gudang</option>
                    <option value="Staff Gudang" {{ request('role') == 'Staff Gudang' ? 'selected' : '' }}>Staff Gudang</option>
                </select>
            </div>
            <button type="submit" class="btn-primary px-4 py-2.5 text-sm font-semibold text-white rounded-xl">Cari</button>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        @if ($users->count() > 0)
            <table class="w-full text-sm text-left">
                <thead class="bg-canvas-alt/70 text-[11px] text-steel uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3.5 font-semibold">Nama</th>
                        <th class="px-6 py-3.5 font-semibold">Email</th>
                        <th class="px-6 py-3.5 font-semibold">Role</th>
                        <th class="px-6 py-3.5 font-semibold">Bergabung</th>
                        <th class="px-6 py-3.5 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach ($users as $user)
                        <tr class="hover:bg-canvas-alt/40 transition-colors">
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center justify-center w-9 h-9 rounded-full bg-brand/10 text-brand-dark font-semibold text-sm flex-shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span class="font-medium text-ink">{{ $user->name }}</span>
                                    @if ($user->id === auth()->id())
                                        <span class="text-[10px] px-1.5 py-0.5 bg-canvas-alt text-steel rounded uppercase tracking-wide">Kamu</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-3.5 text-ink-soft">{{ $user->email }}</td>
                            <td class="px-6 py-3.5">
                                @if ($user->role === 'Admin')
                                    <span class="stock-tag bg-amber/12 text-amber-dark"><span class="stock-tag-dot bg-amber-dark"></span>Admin</span>
                                @elseif ($user->role === 'Manajer Gudang')
                                    <span class="stock-tag bg-brand/12 text-brand-dark"><span class="stock-tag-dot bg-brand"></span>Manajer Gudang</span>
                                @else
                                    <span class="stock-tag bg-freight/12 text-freight"><span class="stock-tag-dot bg-freight"></span>Staff Gudang</span>
                                @endif
                            </td>
                            <td class="px-6 py-3.5 text-steel font-mono-data text-xs">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-3.5 text-right">
                                <div class="inline-flex items-center gap-1">
                                    <a href="{{ route('users.edit', $user->id) }}" class="icon-btn text-freight hover:bg-freight/10" title="Edit">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M13.5 3.5a1.914 1.914 0 012.706 2.706L6.5 15.914 3 16.5l.586-3.5 9.914-9.5z"/></svg>
                                    </a>
                                    @php
                                        $isLastAdmin = $user->role === 'Admin' && \App\Models\User::where('role', 'Admin')->count() <= 1;
                                    @endphp

                                    @if ($user->id !== auth()->id() && !$isLastAdmin)
                                        <button type="button"
                                            data-modal-target="modal-delete-user"
                                            data-modal-toggle="modal-delete-user"
                                            onclick="document.getElementById('form-delete-user').action = '{{ route('users.destroy', $user->id) }}'; document.getElementById('delete-user-name').textContent = '{{ addslashes($user->name) }}'"
                                            class="icon-btn text-rust hover:bg-rust/10" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M4 6h12M8 6V4.5A1.5 1.5 0 019.5 3h1A1.5 1.5 0 0112 4.5V6m2 0v9.5A1.5 1.5 0 0112.5 17h-5A1.5 1.5 0 016 15.5V6h8z"/></svg>
                                        </button>
                                    @elseif ($isLastAdmin)
                                        <span class="icon-btn text-steel-light cursor-not-allowed" title="Admin terakhir tidak bisa dihapus">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M14.5 6.5l-8 8m0-8l8 8M4 6h12M8 6V4.5A1.5 1.5 0 019.5 3h1A1.5 1.5 0 0112 4.5V6m2 0v9.5A1.5 1.5 0 0112.5 17h-5A1.5 1.5 0 016 15.5V6h8z"/></svg>
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $users->links() }}
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
                <div class="empty-icon bg-canvas-alt mb-4">
                    <svg class="w-8 h-8 text-steel-light" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14c-4.4 0-8 2.2-8 5v1h16v-1c0-2.8-3.6-5-8-5z"/></svg>
                </div>
                <p class="font-medium text-ink mb-1">Tidak ada pengguna ditemukan</p>
                <p class="text-sm text-steel">Coba ubah kata kunci pencarian atau filter role.</p>
            </div>
        @endif
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
</x-app-layout>