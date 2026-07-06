<x-app-layout>
    <x-slot name="header">Dashboard Admin</x-slot>

    <!-- Ringkasan Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
            <p class="text-sm text-gray-500">Total Produk</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalProducts }}</p>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
            <p class="text-sm text-gray-500">Total Transaksi Masuk</p>
            <p class="text-2xl font-bold text-green-600 mt-1">{{ $totalIncoming }}</p>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
            <p class="text-sm text-gray-500">Total Transaksi Keluar</p>
            <p class="text-2xl font-bold text-red-600 mt-1">{{ $totalOutgoing }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <!-- Grafik -->
        <div class="lg:col-span-2 bg-white p-5 rounded-lg shadow-sm border border-gray-200">
            <h3 class="text-sm font-semibold text-gray-800 mb-4">Grafik Stok 7 Hari Terakhir</h3>
            <canvas id="stockChart" height="120"></canvas>
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
            <h3 class="text-sm font-semibold text-gray-800 mb-4">Aktivitas Pengguna Terbaru</h3>
            <ul class="space-y-3">
                @forelse ($recentActivity as $activity)
                    <li class="flex items-start gap-3 text-sm">
                        <span class="mt-1 w-2 h-2 rounded-full flex-shrink-0 {{ $activity->type === 'Masuk' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                        <div>
                            <p class="text-gray-800">
                                <span class="font-medium">{{ $activity->user->name ?? '-' }}</span>
                                {{ $activity->type === 'Masuk' ? 'mencatat barang masuk' : 'mencatat barang keluar' }}
                                <span class="font-medium">{{ $activity->product->name ?? '-' }}</span>
                            </p>
                            <p class="text-xs text-gray-400">{{ $activity->created_at->diffForHumans() }}</p>
                        </div>
                    </li>
                @empty
                    <li class="text-sm text-gray-400">Belum ada aktivitas</li>
                @endforelse
            </ul>
        </div>
    </div>

    @vite(['resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    <script>
        const ctx = document.getElementById('stockChart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_column($chartData, 'date')) !!},
                datasets: [
                    {
                        label: 'Barang Masuk',
                        data: {!! json_encode(array_column($chartData, 'masuk')) !!},
                        borderColor: '#16a34a',
                        backgroundColor: 'rgba(22,163,74,0.1)',
                        tension: 0.3,
                    },
                    {
                        label: 'Barang Keluar',
                        data: {!! json_encode(array_column($chartData, 'keluar')) !!},
                        borderColor: '#dc2626',
                        backgroundColor: 'rgba(220,38,38,0.1)',
                        tension: 0.3,
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } },
                scales: { y: { beginAtZero: true } }
            }
        });
    </script>
</x-app-layout>