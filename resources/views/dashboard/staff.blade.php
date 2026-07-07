<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    @php
        $greeting = match(true) { now()->hour < 11 => 'Selamat pagi', now()->hour < 15 => 'Selamat siang', now()->hour < 19 => 'Selamat sore', default => 'Selamat malam' };
        $totalPending = $pendingIncoming->count() + $pendingOutgoing->count();
    @endphp

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <div>
            <p class="font-mono-data text-[11px] tracking-widest text-steel uppercase mb-1">Staff Gudang</p>
            <h1 class="font-display text-2xl font-semibold text-ink">{{ $greeting }}, {{ auth()->user()->name }}</h1>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
        <!-- Completion ring -->
        <div class="bento-card animate-fade-up bg-white p-5 rounded-2xl border border-gray-100 flex flex-col items-center justify-center" style="animation-delay: 0ms">
            <p class="font-mono-data text-[10px] tracking-widest text-steel uppercase mb-3 self-start">Progres Hari Ini</p>
            <div class="relative w-28 h-28">
                <svg class="w-full h-full -rotate-90" viewBox="0 0 120 120">
                    <circle cx="60" cy="60" r="52" stroke="#EEF1F4" stroke-width="12" fill="none"/>
                    <circle id="completionRing" class="ring-progress" cx="60" cy="60" r="52" stroke="#2FA84F" stroke-width="12" fill="none" stroke-linecap="round" stroke-dasharray="326.7" stroke-dashoffset="326.7"/>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="font-display text-xl font-bold text-ink" id="completionPercent">0%</span>
                    <span class="text-[9px] text-steel uppercase tracking-wide">selesai</span>
                </div>
            </div>
            <p class="text-xs text-steel mt-3 text-center">{{ $completedToday->count() }} tugas diselesaikan hari ini</p>
        </div>

        <!-- Perlu diperiksa -->
        <div class="bento-card animate-fade-up bg-white rounded-2xl border border-gray-100 overflow-hidden" style="animation-delay: 60ms">
            <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="icon-badge w-9 h-9 !rounded-lg bg-depot/15 {{ $pendingIncoming->count() > 0 ? 'icon-badge-pulse ring-amber' : '' }}">
                        <svg class="w-4 h-4 text-depot relative" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V3a1 1 0 012 0v9.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                    </div>
                    <p class="font-display font-semibold text-ink text-sm">Perlu Diperiksa</p>
                </div>
                <span class="font-display text-xl font-bold text-depot"><span class="stat-count" data-target="{{ $pendingIncoming->count() }}">0</span></span>
            </div>
            <div class="divide-y divide-gray-50 max-h-40 overflow-y-auto sidebar-scroll">
                @forelse ($pendingIncoming->take(4) as $trx)
                    <a href="{{ route('stock-transactions.confirm.incoming') }}" class="task-row flex items-center justify-between p-3.5 group">
                        <p class="text-sm font-medium text-ink truncate">{{ $trx->product->name ?? '-' }}</p>
                        <span class="font-mono-data text-xs text-steel flex-shrink-0">{{ $trx->quantity }}u</span>
                    </a>
                @empty
                    <p class="text-xs text-steel-light text-center py-6">Tidak ada tugas</p>
                @endforelse
            </div>
        </div>

        <!-- Perlu disiapkan -->
        <div class="bento-card animate-fade-up bg-white rounded-2xl border border-gray-100 overflow-hidden" style="animation-delay: 120ms">
            <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="icon-badge w-9 h-9 !rounded-lg bg-rust/10 {{ $pendingOutgoing->count() > 0 ? 'icon-badge-pulse ring-rust' : '' }}">
                        <svg class="w-4 h-4 text-rust relative" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V17a1 1 0 01-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    </div>
                    <p class="font-display font-semibold text-ink text-sm">Perlu Disiapkan</p>
                </div>
                <span class="font-display text-xl font-bold text-rust"><span class="stat-count" data-target="{{ $pendingOutgoing->count() }}">0</span></span>
            </div>
            <div class="divide-y divide-gray-50 max-h-40 overflow-y-auto sidebar-scroll">
                @forelse ($pendingOutgoing->take(4) as $trx)
                    <a href="{{ route('stock-transactions.confirm.outgoing') }}" class="task-row flex items-center justify-between p-3.5 group">
                        <p class="text-sm font-medium text-ink truncate">{{ $trx->product->name ?? '-' }}</p>
                        <span class="font-mono-data text-xs text-steel flex-shrink-0">{{ $trx->quantity }}u</span>
                    </a>
                @empty
                    <p class="text-xs text-steel-light text-center py-6">Tidak ada tugas</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Detail list lengkap -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
        <div class="bento-card animate-fade-up bg-white rounded-2xl border border-gray-100 overflow-hidden" style="animation-delay: 180ms">
            <div class="p-5 border-b border-gray-100"><h2 class="font-display font-semibold text-ink">Detail Barang Masuk</h2></div>
            <div class="divide-y divide-gray-50">
                @forelse ($pendingIncoming->take(5) as $trx)
                    <a href="{{ route('stock-transactions.confirm.incoming') }}" class="task-row flex items-center justify-between p-4 group">
                        <div class="flex items-center gap-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-dark flex-shrink-0"></span>
                            <div><p class="text-sm font-medium text-ink">{{ $trx->product->name ?? '-' }}</p><p class="text-xs text-steel mt-0.5">{{ $trx->quantity }} unit — {{ $trx->user->name ?? '-' }}</p></div>
                        </div>
                        <svg class="w-4 h-4 text-steel-light group-hover:text-depot group-hover:translate-x-0.5 transition-all flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    </a>
                @empty
                    <div class="p-10 text-center"><div class="empty-icon bg-brand/10 mx-auto mb-3"><svg class="w-7 h-7 text-brand" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></div><p class="text-sm text-steel">Semua beres</p></div>
                @endforelse
            </div>
        </div>
        <div class="bento-card animate-fade-up bg-white rounded-2xl border border-gray-100 overflow-hidden" style="animation-delay: 220ms">
            <div class="p-5 border-b border-gray-100"><h2 class="font-display font-semibold text-ink">Detail Barang Keluar</h2></div>
            <div class="divide-y divide-gray-50">
                @forelse ($pendingOutgoing->take(5) as $trx)
                    <a href="{{ route('stock-transactions.confirm.outgoing') }}" class="task-row flex items-center justify-between p-4 group">
                        <div class="flex items-center gap-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-rust flex-shrink-0"></span>
                            <div><p class="text-sm font-medium text-ink">{{ $trx->product->name ?? '-' }}</p><p class="text-xs text-steel mt-0.5">{{ $trx->quantity }} unit — {{ $trx->user->name ?? '-' }}</p></div>
                        </div>
                        <svg class="w-4 h-4 text-steel-light group-hover:text-rust group-hover:translate-x-0.5 transition-all flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    </a>
                @empty
                    <div class="p-10 text-center"><div class="empty-icon bg-brand/10 mx-auto mb-3"><svg class="w-7 h-7 text-brand" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></div><p class="text-sm text-steel">Semua beres</p></div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Riwayat selesai hari ini -->
    <div class="bento-card animate-fade-up bg-white rounded-2xl border border-gray-100 overflow-hidden" style="animation-delay: 260ms">
        <div class="p-5 border-b border-gray-100">
            <p class="font-mono-data text-[10px] tracking-widest text-steel uppercase">Riwayat</p>
            <h3 class="font-display font-semibold text-ink mt-0.5">Diselesaikan Hari Ini</h3>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse ($completedToday->take(6) as $trx)
                <div class="flex items-center gap-3 p-4">
                    <div class="icon-badge w-8 h-8 !rounded-lg bg-brand/10 flex-shrink-0">
                        <svg class="w-4 h-4 text-brand" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="text-sm text-ink-soft flex-1">{{ $trx->product->name ?? '-' }} <span class="font-mono-data text-xs text-steel">· {{ $trx->quantity }}u</span></p>
                    <span class="stock-tag bg-brand/10 text-brand-dark flex-shrink-0">{{ $trx->status }}</span>
                </div>
            @empty
                <p class="text-sm text-steel-light text-center py-8">Belum ada yang diselesaikan hari ini</p>
            @endforelse
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function animateCount(el, target, duration) {
                duration = duration || 1000;
                var startTime = null;
                function easeOutExpo(t) { return t === 1 ? 1 : 1 - Math.pow(2, -10 * t); }
                function step(ts) {
                    if (!startTime) startTime = ts;
                    var progress = Math.min((ts - startTime) / duration, 1);
                    el.textContent = Math.floor(easeOutExpo(progress) * target);
                    if (progress < 1) requestAnimationFrame(step);
                    else { el.textContent = target; el.classList.add('count-pop'); }
                }
                requestAnimationFrame(step);
            }
            document.querySelectorAll('.stat-count').forEach(function (el) {
                animateCount(el, parseInt(el.dataset.target, 10) || 0);
            });

            var pct = {{ $completionRatio }};
            var circumference = 326.7;
            setTimeout(function () {
                document.getElementById('completionRing').style.strokeDashoffset = circumference - (pct / 100) * circumference;
                document.getElementById('completionPercent').textContent = pct + '%';
            }, 250);
        });
    </script>
</x-app-layout>