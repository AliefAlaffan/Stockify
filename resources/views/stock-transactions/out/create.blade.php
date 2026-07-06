<x-app-layout>
    <x-slot name="header">Transaksi Barang Keluar</x-slot>

    @if (session('success'))
        <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 100 19 9.5 9.5 0 000-19zm3.7 7.2l-4.4 4.4a.7.7 0 01-1 0L6.3 10a.7.7 0 111-1l1.3 1.3 3.9-3.9a.7.7 0 111 1z"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="flex items-center justify-between p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Riwayat Barang Keluar</h2>
            <a href="{{ route('stock-transactions.out.create') }}"
                class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-200">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                </svg>
                Catat Barang Keluar
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Produk</th>
                        <th class="px-6 py-3">Jumlah</th>
                        <th class="px-6 py-3">Dicatat oleh</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $trx)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($trx->date)->format('d M Y') }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $trx->product->name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $trx->quantity }}</td>
                            <td class="px-6 py-4">{{ $trx->user->name ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @if ($trx->status === 'Pending')
                                    <span class="px-2.5 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">Pending</span>
                                @elseif ($trx->status === 'Dikeluarkan')
                                    <span class="px-2.5 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Dikeluarkan</span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded-full">{{ $trx->status }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">{{ $trx->notes ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-400">Belum ada transaksi barang keluar</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>