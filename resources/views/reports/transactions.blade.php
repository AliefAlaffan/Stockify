<x-app-layout>
    <x-slot name="header">Laporan Barang Masuk & Keluar</x-slot>

    <div class="flex items-center gap-3 mb-5">
        <a href="{{ route('reports.index') }}" class="icon-btn text-steel hover:bg-canvas-alt !rounded-lg">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" d="M12.5 15l-5-5 5-5"/></svg>
        </a>
        <div>
            <p class="font-mono-data text-[11px] tracking-widest text-steel uppercase mb-0.5">Laporan</p>
            <h1 class="font-display text-xl font-semibold text-ink">Barang Masuk & Keluar</h1>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-5">
        <form action="{{ route('reports.transactions') }}" method="GET" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[140px]">
                <label class="block mb-1.5 text-xs font-medium text-ink-soft uppercase tracking-wide">Jenis</label>
                <select name="type" class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
                    <option value="">Semua Jenis</option>
                    <option value="Masuk" {{ request('type') == 'Masuk' ? 'selected' : '' }}>Masuk</option>
                    <option value="Keluar" {{ request('type') == 'Keluar' ? 'selected' : '' }}>Keluar</option>
                </select>
            </div>
            <div class="flex-1 min-w-[140px]">
                <label class="block mb-1.5 text-xs font-medium text-ink-soft uppercase tracking-wide">Status</label>
                <select name="status" class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
                    <option value="">Semua Status</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Diterima" {{ request('status') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    <option value="Dikeluarkan" {{ request('status') == 'Dikeluarkan' ? 'selected' : '' }}>Dikeluarkan</option>
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
                <a href="{{ route('reports.transactions.export.pdf', request()->query()) }}"
                    class="flex items-center gap-1.5 px-4 py-2.5 text-sm font-medium text-ink-soft bg-canvas-alt rounded-xl hover:bg-gray-200 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M10 3v10m0 0l-3.5-3.5M10 13l3.5-3.5M4 15v1a2 2 0 002 2h8a2 2 0 002-2v-1"/></svg>
                    PDF
                </a>
                <a href="{{ route('reports.transactions.export.excel', request()->query()) }}"
                    class="flex items-center gap-1.5 px-4 py-2.5 text-sm font-medium text-ink-soft bg-canvas-alt rounded-xl hover:bg-gray-200 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M4 4h9l3 3v9a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/></svg>
                    Excel
                </a>
            </div>
        </form>
    </div>

    <!-- Ringkasan -->
    <div class="grid grid-cols-3 gap-4 mb-5">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
            <p class="text-xs text-steel uppercase tracking-wide mb-1">Total Masuk</p>
            <p class="font-display text-2xl font-semibold text-brand-dark">+{{ number_format($summary['total_in']) }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
            <p class="text-xs text-steel uppercase tracking-wide mb-1">Total Keluar</p>
            <p class="font-display text-2xl font-semibold text-rust">-{{ number_format($summary['total_out']) }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-amber/15 bg-amber/5 shadow-sm p-4">
            <p class="text-xs text-amber-dark uppercase tracking-wide mb-1">Menunggu Konfirmasi</p>
            <p class="font-display text-2xl font-semibold text-amber-dark">{{ $summary['pending'] }}</p>
        </div>
    </div>

    <!-- Tabel -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        @if ($transactions->count() > 0)
            <table class="w-full text-sm text-left">
                <thead class="bg-canvas-alt/70 text-[11px] text-steel uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3.5 font-semibold">Tanggal</th>
                        <th class="px-6 py-3.5 font-semibold">Jenis</th>
                        <th class="px-6 py-3.5 font-semibold">Produk</th>
                        <th class="px-6 py-3.5 font-semibold">Jumlah</th>
                        <th class="px-6 py-3.5 font-semibold">Dicatat oleh</th>
                        <th class="px-6 py-3.5 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach ($transactions as $trx)
                        <tr class="hover:bg-canvas-alt/40 transition-colors">
                            <td class="px-6 py-4 text-ink-soft font-mono-data text-xs">{{ \Carbon\Carbon::parse($trx->date)->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                @if ($trx->type === 'Masuk')
                                    <span class="stock-tag bg-brand/12 text-brand-dark"><span class="stock-tag-dot bg-brand"></span>Masuk</span>
                                @else
                                    <span class="stock-tag bg-rust/12 text-rust"><span class="stock-tag-dot bg-rust"></span>Keluar</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-medium text-ink">{{ $trx->product->name ?? '—' }}</td>
                            <td class="px-6 py-4">
                                <span class="font-mono-data text-sm font-semibold {{ $trx->type === 'Masuk' ? 'text-brand-dark' : 'text-rust' }}">
                                    {{ $trx->type === 'Masuk' ? '+' : '-' }}{{ $trx->quantity }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-ink-soft">{{ $trx->user->name ?? '—' }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColor = match($trx->status) {
                                        'Pending' => 'amber',
                                        'Diterima', 'Dikeluarkan' => 'brand',
                                        'Ditolak' => 'rust',
                                        default => 'steel',
                                    };
                                @endphp
                                <span class="stock-tag bg-{{ $statusColor }}/12 text-{{ $statusColor }}-dark">
                                    <span class="stock-tag-dot bg-{{ $statusColor }}"></span>{{ $trx->status }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $transactions->links() }}
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
                <div class="empty-icon bg-canvas-alt mb-4">
                    <svg class="w-8 h-8 text-steel-light" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M9 17V7m6 10V7M4 21h16a1 1 0 001-1V4a1 1 0 00-1-1H4a1 1 0 00-1 1v16a1 1 0 001 1z"/></svg>
                </div>
                <p class="font-medium text-ink mb-1">Tidak ada data</p>
                <p class="text-sm text-steel">Coba ubah filter jenis, status, atau rentang tanggal.</p>
            </div>
        @endif
    </div>
</x-app-layout>