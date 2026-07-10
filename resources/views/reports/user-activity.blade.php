<x-app-layout>
    <x-slot name="header">Laporan Aktivitas Pengguna</x-slot>

    <div class="flex items-center gap-3 mb-5">
        <a href="{{ route('reports.index') }}" class="icon-btn text-steel hover:bg-canvas-alt !rounded-lg">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" d="M12.5 15l-5-5 5-5"/></svg>
        </a>
        <div>
            <p class="font-mono-data text-[11px] tracking-widest text-steel uppercase mb-0.5">Laporan · Khusus Admin</p>
            <h1 class="font-display text-xl font-semibold text-ink">Aktivitas Pengguna</h1>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-5">
        <form action="{{ route('reports.user-activity') }}" method="GET" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[160px]">
                <label class="block mb-1.5 text-xs font-medium text-ink-soft uppercase tracking-wide">Pengguna</label>
                <select name="user_id" class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
                    <option value="">Semua Pengguna</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->role }})</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-[140px]">
                <label class="block mb-1.5 text-xs font-medium text-ink-soft uppercase tracking-wide">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}"
                    class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
            </div>
            <div class="flex-1 min-w-[140px]">
                <label class="block mb-1.5 text-xs font-medium text-ink-soft uppercase tracking-wide">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}"
                    class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
            </div>
            <div class="flex items-center gap-2">
                <button type="submit" class="btn-primary px-4 py-2.5 text-sm font-semibold text-white rounded-xl">Terapkan</button>
                <a href="{{ route('reports.user-activity.export.pdf', request()->query()) }}"
                    class="flex items-center gap-1.5 px-4 py-2.5 text-sm font-medium text-ink-soft bg-canvas-alt rounded-xl hover:bg-gray-200 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M10 3v10m0 0l-3.5-3.5M10 13l3.5-3.5M4 15v1a2 2 0 002 2h8a2 2 0 002-2v-1"/></svg>
                    PDF
                </a>
                <a href="{{ route('reports.user-activity.export.excel', request()->query()) }}"
                    class="flex items-center gap-1.5 px-4 py-2.5 text-sm font-medium text-ink-soft bg-canvas-alt rounded-xl hover:bg-gray-200 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M4 4h9l3 3v9a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/></svg>
                    Excel
                </a>
            </div>
        </form>
    </div>

    <!-- List Aktivitas -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        @if ($activities->count() > 0)
            <div class="divide-y divide-gray-50">
                @foreach ($activities as $activity)
                    <div class="flex items-start gap-4 p-4 hover:bg-canvas-alt/30 transition-colors">
                        <div class="flex items-center justify-center w-10 h-10 rounded-lg flex-shrink-0 mt-0.5
                            {{ $activity->action === 'stock_opname' ? 'bg-amber/10' : 'bg-freight/10' }}">
                            @if ($activity->action === 'stock_opname')
                                <svg class="w-4 h-4 text-amber-dark" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M9 17V7m6 10V7M4 21h16a1 1 0 001-1V4a1 1 0 00-1-1H4a1 1 0 00-1 1v16a1 1 0 001 1z"/></svg>
                            @else
                                <svg class="w-4 h-4 text-freight" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M13.5 6.5a3.5 3.5 0 11-7 0 3.5 3.5 0 017 0zM3.5 17.25c0-3.176 2.91-5.75 6.5-5.75s6.5 2.574 6.5 5.75"/></svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-ink">
                                <span class="font-semibold">{{ $activity->user->name ?? 'Pengguna tidak diketahui' }}</span>
                                {{ $activity->description }}
                            </p>

                            @if ($activity->changes)
                                <div class="mt-2 flex flex-wrap gap-1.5">
                                    @foreach ($activity->changes as $field => $change)
                                        @if (is_array($change) && array_key_exists('from', $change))
                                            <span class="text-[11px] px-2 py-1 bg-canvas-alt text-ink-soft rounded-md">
                                                <span class="font-medium">{{ ucwords(str_replace('_', ' ', $field)) }}:</span>
                                                {{ Str::limit($change['from'] ?? '—', 25) }} → {{ Str::limit($change['to'] ?? '—', 25) }}
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            @endif

                            <p class="text-xs text-steel-light mt-1.5">{{ $activity->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $activities->links() }}
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
                <div class="empty-icon bg-canvas-alt mb-4">
                    <svg class="w-8 h-8 text-steel-light" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="font-medium text-ink mb-1">Tidak ada aktivitas</p>
                <p class="text-sm text-steel">Coba ubah filter pengguna atau rentang tanggal.</p>
            </div>
        @endif
    </div>
</x-app-layout>