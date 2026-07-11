<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    @php $greeting = match(true) { now()->hour < 11 => 'Selamat pagi', now()->hour < 15 => 'Selamat siang', now()->hour < 19 => 'Selamat sore', default => 'Selamat malam' }; @endphp

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <div>
            <p class="font-mono-data text-[11px] tracking-widest text-steel uppercase mb-1">Ringkasan Operasional</p>
            <h1 class="font-display text-2xl font-semibold text-ink">{{ $greeting }}, {{ auth()->user()->name }}</h1>
        </div>
        <div class="flex items-center gap-2">
            @if($lowStockCount > 0)
                <a href="{{ route('dashboard') }}" class="stock-tag bg-rust/10 text-rust">
                    <span class="stock-tag-dot bg-rust"></span>
                    {{ $lowStockCount }} produk stok menipis
                </a>
            @endif
            <span class="stock-tag bg-brand/8 text-brand-dark">
                <span class="stock-tag-dot bg-brand status-dot"></span>
                Sistem normal
            </span>
        </div>
    </div>

    <!-- Row 1: Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div class="bento-card stat-card animate-fade-up bg-white p-5 rounded-2xl border border-gray-100" style="animation-delay: 0ms">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-steel uppercase tracking-wide">Total Produk</p>
                    <p class="font-display text-3xl font-bold text-ink mt-2"><span class="stat-count" data-target="{{ $totalProducts }}">0</span></p>
                </div>
                <div class="icon-badge bg-brand/12">
                    <svg class="w-5 h-5 text-brand-dark" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path></svg>
                </div>
            </div>
            <a href="{{ route('products.index') }}" class="flex items-center gap-1 text-xs font-medium text-brand-dark mt-3 hover:underline">
                Lihat semua produk
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
            </a>
        </div>

        <div class="bento-card stat-card stat-depot animate-fade-up bg-white p-5 rounded-2xl border border-gray-100" style="animation-delay: 60ms">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-steel uppercase tracking-wide">Total Kategori</p>
                    <p class="font-display text-3xl font-bold text-depot mt-2"><span class="stat-count" data-target="{{ $totalCategories }}">0</span></p>
                </div>
                <div class="icon-badge bg-depot/15">
                    <svg class="w-5 h-5 text-depot" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 3a1 1 0 000 2v10a2 2 0 002 2h10a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H5a1 1 0 000 2z" clip-rule="evenodd"></path></svg>
                </div>
            </div>
            <a href="{{ route('categories.index') }}" class="flex items-center gap-1 text-xs font-medium text-depot mt-3 hover:underline">
                Lihat semua kategori
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
            </a>
        </div>

        <div class="bento-card stat-card stat-rust animate-fade-up bg-white p-5 rounded-2xl border border-gray-100" style="animation-delay: 120ms">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-steel uppercase tracking-wide">Total Supplier</p>
                    <p class="font-display text-3xl font-bold text-rust mt-2"><span class="stat-count" data-target="{{ $totalSuppliers }}">0</span></p>
                </div>
                <div class="icon-badge bg-rust/15">
                    <svg class="w-5 h-5 text-rust" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 00-1 1v9a2 2 0 002 2h.05a2.5 2.5 0 014.9 0h4.1a2.5 2.5 0 014.9 0H18a1 1 0 001-1v-4.19a1 1 0 00-.293-.707l-2.81-2.81A1 1 0 0015.19 7H14V5a1 1 0 00-1-1H3z"></path></svg>
                </div>
            </div>
            <a href="{{ route('suppliers.index') }}" class="flex items-center gap-1 text-xs font-medium text-rust mt-3 hover:underline">
                Lihat semua supplier
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
            </a>
        </div>
    </div>

    <!-- Row 2: Chart (2col) + Activity (1col) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
        <div class="lg:col-span-2 bento-card animate-fade-up bg-white p-5 rounded-2xl border border-gray-100" style="animation-delay: 180ms">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <p class="font-mono-data text-[10px] tracking-widest text-steel uppercase">7 Hari Terakhir</p>
                    <h3 class="font-display font-semibold text-ink mt-0.5">Arus Barang</h3>
                </div>
                <div class="flex items-center gap-4 text-xs">
                    <span class="flex items-center gap-1.5 text-steel"><span class="w-2 h-2 rounded-full bg-depot"></span>Masuk</span>
                    <span class="flex items-center gap-1.5 text-steel"><span class="w-2 h-2 rounded-full bg-rust"></span>Keluar</span>
                </div>
            </div>
            <canvas id="stockChart" height="110"></canvas>
        </div>

        <div class="bento-card animate-fade-up bg-white p-5 rounded-2xl border border-gray-100" style="animation-delay: 240ms">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="font-mono-data text-[10px] tracking-widest text-steel uppercase">Live Feed</p>
                    <h3 class="font-display font-semibold text-ink mt-0.5">Aktivitas</h3>
                </div>
                <span class="relative flex w-2 h-2">
                    <span class="animate-ping-slow absolute inline-flex h-full w-full rounded-full bg-brand opacity-60"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-brand"></span>
                </span>
            </div>
            <ul class="space-y-4 max-h-72 overflow-y-auto sidebar-scroll pr-1">
                @forelse ($recentActivity as $activity)
                    <li class="timeline-item relative pl-5">
                        <span class="timeline-dot absolute left-0 top-1.5 w-[11px] h-[11px] rounded-full border-2 border-white ring-2 {{ $activity->type === 'Masuk' ? 'bg-depot ring-depot/20' : 'bg-rust ring-rust/20' }}"></span>
                        <p class="text-sm text-ink-soft leading-snug">
                            <span class="font-semibold text-ink">{{ $activity->user->name ?? '-' }}</span>
                            {{ $activity->type === 'Masuk' ? 'mencatat barang masuk' : 'mencatat barang keluar' }}
                            <span class="font-mono-data text-xs bg-canvas-alt px-1.5 py-0.5 rounded">{{ $activity->product->name ?? '-' }}</span>
                        </p>
                        <p class="text-xs text-steel-light mt-0.5">{{ $activity->created_at->diffForHumans() }}</p>
                    </li>
                @empty
                    <li class="text-sm text-steel-light text-center py-6">Belum ada aktivitas</li>
                @endforelse
            </ul>
        </div>
    </div>

    <!-- Row 3: Distribusi Kategori + Rasio Transaksi + Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="bento-card animate-fade-up bg-white p-5 rounded-2xl border border-gray-100" style="animation-delay: 300ms">
            <p class="font-mono-data text-[10px] tracking-widest text-steel uppercase mb-0.5">Distribusi</p>
            <h3 class="font-display font-semibold text-ink mb-4">Produk per Kategori</h3>
            <div class="space-y-3.5">
                @forelse ($topCategories as $i => $cat)
                    @php $pct = $totalProducts > 0 ? round(($cat['count'] / $totalProducts) * 100) : 0; @endphp
                    <div>
                        <div class="flex items-center justify-between mb-1.5 text-sm">
                            <span class="text-ink-soft font-medium">{{ $cat['name'] }}</span>
                            <span class="font-mono-data text-xs text-steel">{{ $cat['count'] }}</span>
                        </div>
                        <div class="mini-bar-track">
                            <div class="mini-bar-fill category-bar" data-width="{{ $pct }}" style="width:0%; background: {{ ['#2FA84F','#1E5AA8','#E8A33D','#C1440E','#5B6B79'][$i % 5] }}"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-steel-light text-center py-6">Belum ada data kategori</p>
                @endforelse
            </div>
        </div>

        <div class="bento-card animate-fade-up bg-white p-5 rounded-2xl border border-gray-100 flex flex-col items-center" style="animation-delay: 340ms">
            <p class="font-mono-data text-[10px] tracking-widest text-steel uppercase mb-0.5 self-start">Rasio</p>
            <h3 class="font-display font-semibold text-ink mb-4 self-start">Masuk vs Keluar</h3>
            <div class="relative w-32 h-32">
                <svg class="w-full h-full -rotate-90" viewBox="0 0 120 120">
                    <circle cx="60" cy="60" r="52" stroke="#EEF1F4" stroke-width="14" fill="none"/>
                    <circle id="ratioRing" class="donut-ring" cx="60" cy="60" r="52" stroke="#2FA84F" stroke-width="14" fill="none" stroke-linecap="round" stroke-dasharray="326.7" stroke-dashoffset="326.7"/>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="font-display text-xl font-bold text-ink" id="ratioPercent">0%</span>
                    <span class="text-[9px] text-steel uppercase tracking-wide">masuk</span>
                </div>
            </div>
            <div class="flex items-center gap-4 mt-4 text-xs">
                <span class="flex items-center gap-1.5 text-steel"><span class="w-2 h-2 rounded-full bg-brand"></span>Masuk ({{ $totalIncoming }})</span>
                <span class="flex items-center gap-1.5 text-steel"><span class="w-2 h-2 rounded-full bg-canvas-alt border border-gray-300"></span>Keluar ({{ $totalOutgoing }})</span>
            </div>
        </div>

        <div class="bento-card animate-fade-up bg-white p-5 rounded-2xl border border-gray-100" style="animation-delay: 380ms">
            <p class="font-mono-data text-[10px] tracking-widest text-steel uppercase mb-0.5">Akses Cepat</p>
            <h3 class="font-display font-semibold text-ink mb-4">Aksi Umum</h3>
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('products.create') }}" class="quick-tile flex flex-col items-center text-center gap-2 p-3.5 rounded-xl border border-gray-100">
                    <div class="icon-badge w-9 h-9 !rounded-lg bg-brand/10"><svg class="w-4 h-4 text-brand-dark" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/></svg></div>
                    <span class="text-[11px] font-medium text-ink-soft leading-tight">Tambah Produk</span>
                </a>
                <a href="{{ route('categories.index') }}" class="quick-tile flex flex-col items-center text-center gap-2 p-3.5 rounded-xl border border-gray-100">
                    <div class="icon-badge w-9 h-9 !rounded-lg bg-freight/10"><svg class="w-4 h-4 text-freight" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 3a1 1 0 000 2v10a2 2 0 002 2h10a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H5a1 1 0 000 2z" clip-rule="evenodd"/></svg></div>
                    <span class="text-[11px] font-medium text-ink-soft leading-tight">Kelola Kategori</span>
                </a>
                <a href="{{ route('suppliers.index') }}" class="quick-tile flex flex-col items-center text-center gap-2 p-3.5 rounded-xl border border-gray-100">
                    <div class="icon-badge w-9 h-9 !rounded-lg bg-amber/12"><svg class="w-4 h-4 text-amber-dark" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 00-1 1v9a2 2 0 002 2h.05a2.5 2.5 0 014.9 0h4.1a2.5 2.5 0 014.9 0H18a1 1 0 001-1v-4.19a1 1 0 00-.293-.707l-2.81-2.81A1 1 0 0015.19 7H14V5a1 1 0 00-1-1H3z"/></svg></div>
                    <span class="text-[11px] font-medium text-ink-soft leading-tight">Kelola Supplier</span>
                </a>
                <a href="{{ route('reports.index') }}" class="quick-tile flex flex-col items-center text-center gap-2 p-3.5 rounded-xl border border-gray-100">
                    <div class="icon-badge w-9 h-9 !rounded-lg bg-steel/10"><svg class="w-4 h-4 text-steel" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V4z" clip-rule="evenodd"/></svg></div>
                    <span class="text-[11px] font-medium text-ink-soft leading-tight">Lihat Laporan</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Row 4: Top Produk + Nilai Inventori + Performa Supplier -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-4">

        <!-- Top 5 Produk Terlaris -->
        <div class="bento-card animate-fade-up bg-white rounded-2xl border border-gray-100 overflow-hidden" style="animation-delay: 420ms">
            <div class="p-5 border-b border-gray-100">
                <p class="font-mono-data text-[10px] tracking-widest text-steel uppercase">Terlaris</p>
                <h3 class="font-display font-semibold text-ink mt-0.5">Top 5 Produk</h3>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse ($topProducts as $i => $product)
                    <div class="flex items-center gap-3 p-4">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-canvas-alt text-ink-soft text-xs font-semibold flex-shrink-0">{{ $i + 1 }}</span>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-ink truncate">{{ $product['name'] }}</p>
                            <div class="mini-bar-track mt-1.5">
                                <div class="mini-bar-fill" style="width: {{ round(($product['total_out'] / $maxSold) * 100) }}%; background: #C1440E;"></div>
                            </div>
                        </div>
                        <span class="font-mono-data text-xs font-semibold text-ink flex-shrink-0">{{ $product['total_out'] }} pcs</span>
                    </div>
                @empty
                    <p class="text-sm text-steel-light text-center py-8">Belum ada data penjualan</p>
                @endforelse
            </div>
        </div>

        <!-- Nilai Total Inventori -->
        <div class="bento-card animate-fade-up bg-white p-5 rounded-2xl border border-gray-100 flex flex-col justify-center items-center text-center" style="animation-delay: 460ms">
            <div class="icon-badge bg-brand/12 mb-3">
                <svg class="w-5 h-5 text-brand-dark" fill="currentColor" viewBox="0 0 20 20"><path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/></svg>
            </div>
            <p class="text-xs font-medium text-steel uppercase tracking-wide">Nilai Total Inventori</p>
            <p class="font-display text-2xl font-bold text-ink mt-2">Rp {{ number_format($totalInventoryValue, 0, ',', '.') }}</p>
            <p class="text-xs text-steel-light mt-1">Berdasarkan harga beli × stok saat ini</p>
        </div>

        <!-- Performa Supplier -->
        <div class="bento-card animate-fade-up bg-white rounded-2xl border border-gray-100 overflow-hidden" style="animation-delay: 500ms">
            <div class="p-5 border-b border-gray-100">
                <p class="font-mono-data text-[10px] tracking-widest text-steel uppercase">Sumber Barang</p>
                <h3 class="font-display font-semibold text-ink mt-0.5">Performa Supplier</h3>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse ($supplierPerformance as $supplier)
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-1.5">
                            <p class="text-sm font-medium text-ink truncate">{{ $supplier['name'] }}</p>
                            <span class="font-mono-data text-xs text-steel flex-shrink-0">{{ $supplier['total_supplied'] }} pcs</span>
                        </div>
                        <div class="mini-bar-track">
                            <div class="mini-bar-fill" style="width: {{ round(($supplier['total_supplied'] / $maxSupplied) * 100) }}%; background: #1E5AA8;"></div>
                        </div>
                        <p class="text-[11px] text-steel-light mt-1">{{ $supplier['transaction_count'] }} transaksi</p>
                    </div>
                @empty
                    <p class="text-sm text-steel-light text-center py-8">Belum ada data supplier</p>
                @endforelse
            </div>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
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

            setTimeout(function () {
                document.querySelectorAll('.category-bar').forEach(function (bar) {
                    bar.style.width = bar.dataset.width + '%';
                });
            }, 200);

            var totalIn = {{ $totalIncoming }};
            var totalOut = {{ $totalOutgoing }};
            var totalTrx = totalIn + totalOut;
            var pct = totalTrx > 0 ? Math.round((totalIn / totalTrx) * 100) : 50;
            var circumference = 326.7;
            setTimeout(function () {
                document.getElementById('ratioRing').style.strokeDashoffset = circumference - (pct / 100) * circumference;
                document.getElementById('ratioPercent').textContent = pct + '%';
            }, 300);

            var ctx = document.getElementById('stockChart');
            var gradientMasuk = ctx.getContext('2d').createLinearGradient(0, 0, 0, 220);
            gradientMasuk.addColorStop(0, 'rgba(47,168,79,0.25)');
            gradientMasuk.addColorStop(1, 'rgba(47,168,79,0)');
            var gradientKeluar = ctx.getContext('2d').createLinearGradient(0, 0, 0, 220);
            gradientKeluar.addColorStop(0, 'rgba(193,68,14,0.2)');
            gradientKeluar.addColorStop(1, 'rgba(193,68,14,0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode(array_column($chartData, 'date')) !!},
                    datasets: [
                        { label: 'Barang Masuk', data: {!! json_encode(array_column($chartData, 'masuk')) !!}, borderColor: '#2FA84F', backgroundColor: gradientMasuk, fill: true, tension: 0.4, pointRadius: 3, pointHoverRadius: 5, pointBackgroundColor: '#2FA84F', borderWidth: 2.5 },
                        { label: 'Barang Keluar', data: {!! json_encode(array_column($chartData, 'keluar')) !!}, borderColor: '#C1440E', backgroundColor: gradientKeluar, fill: true, tension: 0.4, pointRadius: 3, pointHoverRadius: 5, pointBackgroundColor: '#C1440E', borderWidth: 2.5 }
                    ]
                },
                options: {
                    responsive: true,
                    interaction: { mode: 'index', intersect: false },
                    plugins: { legend: { display: false }, tooltip: { backgroundColor: '#122A4E', padding: 10, cornerRadius: 10, titleFont: { family: 'Space Grotesk', size: 12 }, bodyFont: { family: 'Inter', size: 12 } } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#EEF1F4' }, ticks: { font: { family: 'Inter', size: 11 } } },
                        x: { grid: { display: false }, ticks: { font: { family: 'Inter', size: 11 } } }
                    }
                }
            });
        });
    </script>
</x-app-layout>