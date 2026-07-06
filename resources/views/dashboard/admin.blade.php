<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    <div class="mb-6">
        <p class="font-mono-data text-[11px] tracking-widest text-steel uppercase mb-1">Ringkasan Operasional</p>
        <h1 class="font-display text-2xl font-semibold text-ink">Selamat datang, {{ auth()->user()->name }}</h1>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="card-elevated stat-card animate-fade-up bg-white p-5 rounded-xl border border-gray-100" style="animation-delay: 0ms">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-steel uppercase tracking-wide">Total Produk</p>
                    <p class="font-display text-3xl font-bold text-ink mt-2">{{ $totalProducts }}</p>
                </div>
                <div class="icon-badge bg-amber/15">
                    <svg class="w-5 h-5 text-amber-dark" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="card-elevated stat-card stat-depot animate-fade-up bg-white p-5 rounded-xl border border-gray-100" style="animation-delay: 60ms">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-steel uppercase tracking-wide">Transaksi Masuk</p>
                    <p class="font-display text-3xl font-bold text-depot mt-2">{{ $totalIncoming }}</p>
                </div>
                <div class="icon-badge bg-depot/15">
                    <svg class="w-5 h-5 text-depot" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V3a1 1 0 012 0v9.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="card-elevated stat-card stat-rust animate-fade-up bg-white p-5 rounded-xl border border-gray-100" style="animation-delay: 120ms">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-steel uppercase tracking-wide">Transaksi Keluar</p>
                    <p class="font-display text-3xl font-bold text-rust mt-2">{{ $totalOutgoing }}</p>
                </div>
                <div class="icon-badge bg-rust/15">
                    <svg class="w-5 h-5 text-rust" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V17a1 1 0 01-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <!-- Grafik -->
        <div class="lg:col-span-2 card-elevated animate-fade-up bg-white p-5 rounded-xl border border-gray-100" style="animation-delay: 180ms">
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

        <!-- Aktivitas Terbaru -->
        <div class="card-elevated animate-fade-up bg-white p-5 rounded-xl border border-gray-100" style="animation-delay: 240ms">
            <p class="font-mono-data text-[10px] tracking-widest text-steel uppercase">Live Feed</p>
            <h3 class="font-display font-semibold text-ink mt-0.5 mb-4">Aktivitas Pengguna</h3>
            <ul class="space-y-4">
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    <script>
        const ctx = document.getElementById('stockChart');
        const gradientMasuk = ctx.getContext('2d').createLinearGradient(0, 0, 0, 220);
        gradientMasuk.addColorStop(0, 'rgba(47,133,90,0.25)');
        gradientMasuk.addColorStop(1, 'rgba(47,133,90,0)');

        const gradientKeluar = ctx.getContext('2d').createLinearGradient(0, 0, 0, 220);
        gradientKeluar.addColorStop(0, 'rgba(193,68,14,0.2)');
        gradientKeluar.addColorStop(1, 'rgba(193,68,14,0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_column($chartData, 'date')) !!},
                datasets: [
                    {
                        label: 'Barang Masuk',
                        data: {!! json_encode(array_column($chartData, 'masuk')) !!},
                        borderColor: '#2F855A',
                        backgroundColor: gradientMasuk,
                        fill: true, tension: 0.4, pointRadius: 3, pointBackgroundColor: '#2F855A', borderWidth: 2,
                    },
                    {
                        label: 'Barang Keluar',
                        data: {!! json_encode(array_column($chartData, 'keluar')) !!},
                        borderColor: '#C1440E',
                        backgroundColor: gradientKeluar,
                        fill: true, tension: 0.4, pointRadius: 3, pointBackgroundColor: '#C1440E', borderWidth: 2,
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#EEF1F4' }, ticks: { font: { family: 'Inter', size: 11 } } },
                    x: { grid: { display: false }, ticks: { font: { family: 'Inter', size: 11 } } }
                }
            }
        });
    </script>
</x-app-layout>