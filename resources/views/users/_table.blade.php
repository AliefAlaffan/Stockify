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