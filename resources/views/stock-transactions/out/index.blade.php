<x-app-layout>
    <x-slot name="header">Barang Keluar</x-slot>

    @if (session('success'))
        <div class="flex items-center gap-2.5 p-4 mb-5 text-sm text-brand-dark rounded-2xl bg-brand/8 border border-brand/15 animate-fade-up" role="alert">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="flex items-center justify-between mb-5">
        <div>
            <p class="font-mono-data text-[11px] tracking-widest text-steel uppercase mb-1">Operasi</p>
            <h1 class="font-display text-xl font-semibold text-ink">Riwayat Barang Keluar</h1>
        </div>
        <a href="{{ route('stock-transactions.out.create') }}" class="btn-primary flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white rounded-xl">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/></svg>
            Catat Barang Keluar
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
                                <span class="inline-flex items-center gap-1 font-mono-data text-sm font-semibold text-rust">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V17a1 1 0 01-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                                    {{ $trx->quantity }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-ink-soft">{{ $trx->user->name ?? '—' }}</td>
                            <td class="px-6 py-4">
                                @if ($trx->status === 'Pending')
                                    <span class="stock-tag bg-amber/12 text-amber-dark"><span class="stock-tag-dot bg-amber-dark"></span>Pending</span>
                                @elseif ($trx->status === 'Dikeluarkan')
                                    <span class="stock-tag bg-brand/12 text-brand-dark"><span class="stock-tag-dot bg-brand"></span>Dikeluarkan</span>
                                @else
                                    <span class="stock-tag bg-canvas-alt text-steel"><span class="stock-tag-dot bg-steel"></span>{{ $trx->status }}</span>
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
                    <svg class="w-8 h-8 text-steel-light" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/></svg>
                </div>
                <p class="font-medium text-ink mb-1">Belum ada transaksi barang keluar</p>
                <p class="text-sm text-steel mb-4">Catat pengeluaran barang pertama kamu.</p>
                <a href="{{ route('stock-transactions.out.create') }}" class="btn-primary px-4 py-2 text-sm font-semibold text-white rounded-xl">Catat Sekarang</a>
            </div>
        @endif
    </div>
</x-app-layout>