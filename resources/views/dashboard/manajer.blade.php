<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    @php
        $greeting = match(true) { now()->hour < 11 => 'Selamat pagi', now()->hour < 15 => 'Selamat siang', now()->hour < 19 => 'Selamat sore', default => 'Selamat malam' };
        $sorted = $lowStockProducts->sortBy(fn($p) => $p->minimum_stock > 0 ? $p->current_stock / $p->minimum_stock : 0);
    @endphp

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <div>
            <p class="font-mono-data text-[11px] tracking-widest text-steel uppercase mb-1">Manajer Gudang</p>
            <h1 class="font-display text-2xl font-semibold text-ink">{{ $greeting }}, {{ auth()->user()->name }}</h1>
        </div>
        @if($pendingCount > 0)
            <span class="stock-tag bg-amber/12 text-amber-dark w-fit">
                <span class="stock-tag-dot bg-amber-dark"></span>
                {{ $pendingCount }} transaksi menunggu konfirmasi
            </span>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div class="bento-card stat-card stat-rust animate-fade-up bg-white p-5 rounded-2xl border border-gray-100" style="animation-delay: 0ms">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-steel uppercase tracking-wide">Stok Menipis</p>
                    <p class="font-display text-3xl font-bold text-rust mt-2"><span class="stat-count" data-target="{{ $lowStockProducts->count() }}">0</span></p>
                </div>
                <div class="icon-badge bg-rust/15 {{ $lowStockProducts->count() > 0 ? 'icon-badge-pulse ring-rust' : '' }}">
                    <svg class="w-5 h-5 text-rust relative" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l6.28 11.184c.75 1.334-.213 2.985-1.742 2.985H3.72c-1.53 0-2.493-1.65-1.743-2.985L8.257 3.1zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-.25-6.25a.75.75 0 00-1.5 0v3.5a.75.75 0 001.5 0v-3.5z" clip-rule="evenodd"></path></svg>
                </div>
            </div>
        </div>
        <div class="bento-card stat-card stat-depot animate-fade-up bg-white p-5 rounded-2xl border border-gray-100" style="animation-delay: 60ms">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-steel uppercase tracking-wide">Masuk Hari Ini</p>
                    <p class="font-display text-3xl font-bold text-depot mt-2"><span class="stat-count" data-target="{{ $incomingToday }}">0</span></p>
                </div>
                <div class="icon-badge bg-depot/15"><svg class="w-5 h-5 text-depot" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V3a1 1 0 012 0v9.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg></div>
            </div>
            <a href="{{ route('stock-transactions.in.create') }}" class="flex items-center gap-1 text-xs font-medium text-depot mt-3 hover:underline">Catat baru <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg></a>
        </div>
        <div class="bento-card stat-card stat-freight animate-fade-up bg-white p-5 rounded-2xl border border-gray-100" style="animation-delay: 120ms">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-steel uppercase tracking-wide">Keluar Hari Ini</p>
                    <p class="font-display text-3xl font-bold text-freight mt-2"><span class="stat-count" data-target="{{ $outgoingToday }}">0</span></p>
                </div>
                <div class="icon-badge bg-freight/15"><svg class="w-5 h-5 text-freight" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V17a1 1 0 01-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></div>
            </div>
            <a href="{{ route('stock-transactions.out.create') }}" class="flex items-center gap-1 text-xs font-medium text-freight mt-3 hover:underline">Catat baru <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg></a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
        <div class="lg:col-span-2 bento-card animate-fade-up bg-white rounded-2xl border border-gray-100 overflow-hidden" style="animation-delay: 180ms">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <p class="font-mono-data text-[10px] tracking-widest text-steel uppercase">Perlu Perhatian</p>
                    <h2 class="font-display font-semibold text-ink mt-0.5">Produk dengan Stok Menipis</h2>
                </div>
                @if($lowStockProducts->count() > 0)
                    <a href="{{ route('stock-opname.index') }}" class="btn-primary flex-shrink-0 px-3.5 py-2 text-xs font-semibold text-white rounded-lg">Stock Opname</a>
                @endif
            </div>
            <div class="divide-y divide-gray-100 max-h-[22rem] overflow-y-auto sidebar-scroll">
                @forelse ($sorted as $product)
                    @php
                        $ratio = $product->minimum_stock > 0 ? min(100, ($product->current_stock / $product->minimum_stock) * 100) : 0;
                        $severity = $ratio <= 0 ? 'bg-rust' : ($ratio < 50 ? 'bg-amber' : 'bg-amber-dark');
                    @endphp
                    <div class="p-5 flex items-center gap-4 hover:bg-canvas-alt/60 transition-colors">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1.5">
                                <p class="font-medium text-ink text-sm truncate">{{ $product->name }}</p>
                                <span class="stock-tag bg-canvas-alt text-steel flex-shrink-0">{{ $product->sku }}</span>
                            </div>
                            <div class="progress-track w-full max-w-xs">
                                <div class="progress-bar {{ $severity }} progress-animated" data-width="{{ $ratio }}" style="width: 0%"></div>
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="font-display text-lg font-bold text-ink">{{ $product->current_stock }}<span class="text-steel-light text-sm font-normal"> / {{ $product->minimum_stock }}</span></p>
                            <p class="text-[11px] text-steel-light uppercase tracking-wide">stok / minimum</p>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <div class="empty-icon bg-brand/10 mx-auto mb-3"><svg class="w-8 h-8 text-brand" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></div>
                        <p class="font-medium text-ink mb-1">Semua stok dalam kondisi aman</p>
                        <p class="text-sm text-steel">Tidak ada produk di bawah batas minimum.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="bento-card animate-fade-up bg-white p-5 rounded-2xl border border-gray-100" style="animation-delay: 240ms">
            <p class="font-mono-data text-[10px] tracking-widest text-steel uppercase">Kesehatan Stok</p>
            <h3 class="font-display font-semibold text-ink mt-0.5 mb-5">Ringkasan Cepat</h3>
            <div class="flex flex-col items-center">
                <div class="relative w-32 h-32">
                    <svg class="w-full h-full -rotate-90" viewBox="0 0 120 120">
                        <circle cx="60" cy="60" r="52" stroke="#EEF1F4" stroke-width="12" fill="none"/>
                        <circle id="healthRing" class="donut-ring" cx="60" cy="60" r="52" stroke="#C1440E" stroke-width="12" fill="none" stroke-linecap="round" stroke-dasharray="326.7" stroke-dashoffset="326.7"/>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="font-display text-xl font-bold text-ink" id="healthPercent">0%</span>
                        <span class="text-[9px] text-steel uppercase tracking-wide">bermasalah</span>
                    </div>
                </div>
                <div class="w-full mt-5 space-y-2.5">
                    <div class="flex items-center justify-between text-sm">
                        <span class="flex items-center gap-2 text-ink-soft"><span class="w-2 h-2 rounded-full bg-rust"></span>Stok menipis</span>
                        <span class="font-semibold text-ink">{{ $lowStockProducts->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="flex items-center gap-2 text-ink-soft"><span class="w-2 h-2 rounded-full bg-canvas-alt border border-gray-200"></span>Stok aman</span>
                        <span class="font-semibold text-ink">{{ max(0, $totalAllProducts - $lowStockProducts->count()) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaksi terbaru -->
    <div class="bento-card animate-fade-up bg-white rounded-2xl border border-gray-100 overflow-hidden" style="animation-delay: 300ms">
        <div class="p-5 border-b border-gray-100">
            <p class="font-mono-data text-[10px] tracking-widest text-steel uppercase">Terbaru</p>
            <h3 class="font-display font-semibold text-ink mt-0.5">Transaksi Terkini</h3>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse ($recentTransactions as $trx)
                <div class="flex items-center gap-4 p-4 hover:bg-canvas-alt/40 transition-colors">
                    <div class="icon-badge w-9 h-9 !rounded-lg {{ $trx->type === 'Masuk' ? 'bg-depot/12' : 'bg-rust/10' }} flex-shrink-0">
                        <svg class="w-4 h-4 {{ $trx->type === 'Masuk' ? 'text-depot' : 'text-rust' }}" fill="currentColor" viewBox="0 0 20 20">
                            @if($trx->type === 'Masuk')
                                <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V3a1 1 0 012 0v9.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            @else
                                <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V17a1 1 0 01-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            @endif
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-ink truncate">{{ $trx->product->name ?? '-' }} <span class="text-steel-light font-normal">· {{ $trx->quantity }} unit</span></p>
                        <p class="text-xs text-steel">{{ $trx->user->name ?? '-' }} · {{ $trx->created_at->diffForHumans() }}</p>
                    </div>
                    @if($trx->status === 'Pending')
                        <span class="stock-tag bg-amber/12 text-amber-dark flex-shrink-0"><span class="stock-tag-dot bg-amber-dark"></span>Pending</span>
                    @else
                        <span class="stock-tag bg-brand/12 text-brand-dark flex-shrink-0"><span class="stock-tag-dot bg-brand"></span>{{ $trx->status }}</span>
                    @endif
                </div>
            @empty
                <p class="text-sm text-steel-light text-center py-8">Belum ada transaksi</p>
            @endforelse
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function animateCount(el, target, duration) {
                duration = duration || 1100;
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

            setTimeout(function () {
                document.querySelectorAll('.progress-animated').forEach(function (bar) {
                    bar.style.width = bar.dataset.width + '%';
                });
            }, 150);

            var lowCount = {{ $lowStockProducts->count() }};
            var totalCount = {{ $totalAllProducts > 0 ? $totalAllProducts : 1 }};
            var pct = Math.round((lowCount / totalCount) * 100);
            var circumference = 326.7;
            setTimeout(function () {
                document.getElementById('healthRing').style.strokeDashoffset = circumference - (pct / 100) * circumference;
                document.getElementById('healthPercent').textContent = pct + '%';
            }, 250);
        });
    </script>
</x-app-layout>