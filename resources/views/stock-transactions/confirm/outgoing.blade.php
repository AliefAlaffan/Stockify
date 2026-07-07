<x-app-layout>
    <x-slot name="header">Konfirmasi Barang Keluar</x-slot>

    @if (session('success'))
        <div class="flex items-center gap-2.5 p-4 mb-5 text-sm text-brand-dark rounded-2xl bg-brand/8 border border-brand/15 animate-fade-up" role="alert">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="flex items-center gap-2.5 p-4 mb-5 text-sm text-rust rounded-2xl bg-rust/8 border border-rust/15 animate-fade-up" role="alert">
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <div class="mb-5">
        <p class="font-mono-data text-[11px] tracking-widest text-steel uppercase mb-1">Operasi</p>
        <h1 class="font-display text-xl font-semibold text-ink">Barang Keluar yang Perlu Disiapkan</h1>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        @if ($transactions->count() > 0)
            <div class="divide-y divide-gray-50">
                @foreach ($transactions as $trx)
                    <div class="flex items-center gap-4 p-5 hover:bg-canvas-alt/30 transition-colors">
                        <div class="icon-badge w-11 h-11 !rounded-xl bg-rust/10 flex-shrink-0">
                            <svg class="w-5 h-5 text-rust" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V17a1 1 0 01-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-ink text-sm">{{ $trx->product->name ?? '—' }}</p>
                            <p class="text-xs text-steel mt-0.5">
                                <span class="font-mono-data font-semibold text-ink-soft">{{ $trx->quantity }} unit</span>
                                · {{ \Carbon\Carbon::parse($trx->date)->format('d M Y') }} · dicatat {{ $trx->user->name ?? '—' }}
                            </p>
                            @if($trx->notes)
                                <p class="text-xs text-steel-light mt-1 italic">"{{ $trx->notes }}"</p>
                            @endif
                        </div>
                        <form action="{{ route('stock-transactions.confirm.outgoing.update', $trx->id) }}" method="POST" class="flex-shrink-0">
                            @csrf @method('PUT')
                            <button type="submit" onclick="return confirm('Konfirmasi barang sudah disiapkan & dikirim?')"
                                class="btn-primary px-4 py-2 text-xs font-semibold text-white rounded-lg">Sudah Dikeluarkan</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
                <div class="empty-icon bg-brand/10 mb-4">
                    <svg class="w-8 h-8 text-brand" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
                <p class="font-medium text-ink mb-1">Semua sudah disiapkan</p>
                <p class="text-sm text-steel">Tidak ada barang keluar yang menunggu konfirmasi.</p>
            </div>
        @endif
    </div>
</x-app-layout>