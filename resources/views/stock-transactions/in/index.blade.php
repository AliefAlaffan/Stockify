<x-app-layout>
    <x-slot name="header">Barang Masuk</x-slot>

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
            <p class="font-mono-data text-[11px] tracking-widest text-steel uppercase mb-1">Operasi</p>
            <h1 class="font-display text-xl font-semibold text-ink">Riwayat Barang Masuk</h1>
        </div>
        <a href="{{ route('stock-transactions.in.create') }}" class="btn-primary flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white rounded-xl">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/></svg>
            Catat Barang Masuk
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        @if ($transactions->count() > 0)
            <table class="w-full text-sm text-left">
                <thead class="bg-canvas-alt/70 text-[11px] text-steel uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3.5 font-semibold">Tanggal</th>
                        <th class="px-6 py-3.5 font-semibold">Produk</th>
                        <th class="px-6 py-3.5 font-semibold">Jumlah</th>
                        <th class="px-6 py-3.5 font-semibold">Dicatat oleh</th>
                        <th class="px-6 py-3.5 font-semibold">Status</th>
                        <th class="px-6 py-3.5 font-semibold">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach ($transactions as $trx)
                        <tr class="hover:bg-canvas-alt/40 transition-colors">
                            <td class="px-6 py-4 text-ink-soft font-mono-data text-xs">{{ \Carbon\Carbon::parse($trx->date)->format('d M Y') }}</td>
                            <td class="px-6 py-4 font-medium text-ink">{{ $trx->product->name ?? '—' }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 font-mono-data text-sm font-semibold text-brand-dark">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V3a1 1 0 012 0v9.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    {{ $trx->quantity }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-ink-soft">{{ $trx->user->name ?? '—' }}</td>
                            <td class="px-6 py-4">
                                @if ($trx->status === 'Pending')
                                    <span class="stock-tag bg-amber/12 text-amber-dark"><span class="stock-tag-dot bg-amber-dark"></span>Pending</span>
                                @elseif ($trx->status === 'Diterima')
                                    <span class="stock-tag bg-brand/12 text-brand-dark"><span class="stock-tag-dot bg-brand"></span>Diterima</span>
                                @else
                                    <span class="stock-tag bg-rust/12 text-rust"><span class="stock-tag-dot bg-rust"></span>Ditolak</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-steel">{{ $trx->notes ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
                <div class="empty-icon bg-canvas-alt mb-4">
                    <svg class="w-8 h-8 text-steel-light" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                </div>
                <p class="font-medium text-ink mb-1">Belum ada transaksi barang masuk</p>
                <p class="text-sm text-steel mb-4">Catat penerimaan barang pertama kamu.</p>
                <a href="{{ route('stock-transactions.in.create') }}" class="btn-primary px-4 py-2 text-sm font-semibold text-white rounded-xl">Catat Sekarang</a>
            </div>
        @endif
    </div>
</x-app-layout>