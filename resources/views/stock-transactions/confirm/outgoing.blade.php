<x-app-layout>
    <x-slot name="header">Konfirmasi Pengeluaran Barang</x-slot>

    @if (session('success'))
        <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Barang Keluar yang Perlu Disiapkan</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Produk</th>
                        <th class="px-6 py-3">Jumlah</th>
                        <th class="px-6 py-3">Dicatat oleh</th>
                        <th class="px-6 py-3">Catatan</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $trx)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($trx->date)->format('d M Y') }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $trx->product->name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $trx->quantity }}</td>
                            <td class="px-6 py-4">{{ $trx->user->name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $trx->notes ?? '-' }}</td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('stock-transactions.confirm.outgoing.update', $trx->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" onclick="return confirm('Konfirmasi barang sudah disiapkan & dikirim?')" class="px-3 py-1.5 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">Sudah Dikeluarkan</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-400">Tidak ada barang keluar yang perlu disiapkan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>