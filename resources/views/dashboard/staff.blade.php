<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    <div class="mb-6">
        <p class="font-mono-data text-[11px] tracking-widest text-steel uppercase mb-1">Staff Gudang</p>
        <h1 class="font-display text-2xl font-semibold text-ink">Tugas Hari Ini, {{ auth()->user()->name }}</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div class="card-elevated animate-fade-up bg-white rounded-xl border border-gray-100 overflow-hidden" style="animation-delay: 0ms">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="icon-badge bg-depot/15">
                        <svg class="w-5 h-5 text-depot" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V3a1 1 0 012 0v9.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div>
                        <h2 class="font-display font-semibold text-ink">Perlu Diperiksa</h2>
                        <p class="text-xs text-steel">Barang masuk menunggu konfirmasi</p>
                    </div>
                </div>
                <span class="font-display text-2xl font-bold text-depot">{{ $pendingIncoming->count() }}</span>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse ($pendingIncoming->take(5) as $trx)
                    <a href="{{ route('stock-transactions.confirm.incoming') }}" class="task-row flex items-center justify-between p-4 group">
                        <div>
                            <p class="text-sm font-medium text-ink">{{ $trx->product->name ?? '-' }}</p>
                            <p class="text-xs text-steel mt-0.5">{{ $trx->quantity }} unit — {{ $trx->user->name ?? '-' }}</p>
                        </div>
                        <svg class="w-4 h-4 text-steel-light group-hover:text-depot group-hover:translate-x-0.5 transition-all" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    </a>
                @empty
                    <p class="text-sm text-steel-light text-center py-8">Tidak ada tugas — semua beres ✓</p>
                @endforelse
            </div>
            @if($pendingIncoming->count() > 0)
                <a href="{{ route('stock-transactions.confirm.incoming') }}" class="block text-center text-xs font-medium text-depot py-3 bg-canvas-alt/50 hover:bg-canvas-alt transition-colors">Lihat semua →</a>
            @endif
        </div>

        <div class="card-elevated animate-fade-up bg-white rounded-xl border border-gray-100 overflow-hidden" style="animation-delay: 80ms">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="icon-badge bg-rust/15">
                        <svg class="w-5 h-5 text-rust" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V17a1 1 0 01-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div>
                        <h2 class="font-display font-semibold text-ink">Perlu Disiapkan</h2>
                        <p class="text-xs text-steel">Barang keluar menunggu dikirim</p>
                    </div>
                </div>
                <span class="font-display text-2xl font-bold text-rust">{{ $pendingOutgoing->count() }}</span>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse ($pendingOutgoing->take(5) as $trx)
                    <a href="{{ route('stock-transactions.confirm.outgoing') }}" class="task-row flex items-center justify-between p-4 group">
                        <div>
                            <p class="text-sm font-medium text-ink">{{ $trx->product->name ?? '-' }}</p>
                            <p class="text-xs text-steel mt-0.5">{{ $trx->quantity }} unit — {{ $trx->user->name ?? '-' }}</p>
                        </div>
                        <svg class="w-4 h-4 text-steel-light group-hover:text-rust group-hover:translate-x-0.5 transition-all" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    </a>
                @empty
                    <p class="text-sm text-steel-light text-center py-8">Tidak ada tugas — semua beres ✓</p>
                @endforelse
            </div>
            @if($pendingOutgoing->count() > 0)
                <a href="{{ route('stock-transactions.confirm.outgoing') }}" class="block text-center text-xs font-medium text-rust py-3 bg-canvas-alt/50 hover:bg-canvas-alt transition-colors">Lihat semua →</a>
            @endif
        </div>
    </div>
</x-app-layout>