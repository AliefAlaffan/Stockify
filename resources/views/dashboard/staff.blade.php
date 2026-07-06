<x-app-layout>
    <x-slot name="header">Dashboard Staff Gudang</x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
            <p class="text-sm text-gray-500">Barang Masuk Perlu Diperiksa</p>
            <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $pendingIncoming->count() }}</p>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
            <p class="text-sm text-gray-500">Barang Keluar Perlu Disiapkan</p>
            <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $pendingOutgoing->count() }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-800">Perlu Diperiksa (Barang Masuk)</h2>
                <a href="{{ route('stock-transactions.confirm.incoming') }}" class="text-sm text-blue-600 hover:underline">Lihat semua →</a>
            </div>
            <ul class="divide-y divide-gray-100">
                @forelse ($pendingIncoming->take(5) as $trx)
                    <li class="p-4 text-sm">
                        <p class="font-medium text-gray-900">{{ $trx->product->name ?? '-' }}</p>
                        <p class="text-gray-500">{{ $trx->quantity }} unit — dicatat oleh {{ $trx->user->name ?? '-' }}</p>
                    </li>
                @empty
                    <li class="p-4 text-sm text-gray-400">Tidak ada tugas</li>
                @endforelse
            </ul>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-800">Perlu Disiapkan (Barang Keluar)</h2>
                <a href="{{ route('stock-transactions.confirm.outgoing') }}" class="text-sm text-blue-600 hover:underline">Lihat semua →</a>
            </div>
            <ul class="divide-y divide-gray-100">
                @forelse ($pendingOutgoing->take(5) as $trx)
                    <li class="p-4 text-sm">
                        <p class="font-medium text-gray-900">{{ $trx->product->name ?? '-' }}</p>
                        <p class="text-gray-500">{{ $trx->quantity }} unit — dicatat oleh {{ $trx->user->name ?? '-' }}</p>
                    </li>
                @empty
                    <li class="p-4 text-sm text-gray-400">Tidak ada tugas</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-app-layout>