<x-app-layout>
    <x-slot name="header">Laporan</x-slot>

    <div class="mb-6">
        <p class="font-mono-data text-[11px] tracking-widest text-steel uppercase mb-1">Analitik</p>
        <h1 class="font-display text-xl font-semibold text-ink">Pusat Laporan</h1>
        <p class="text-sm text-steel mt-1">Pilih jenis laporan yang ingin ditinjau atau diekspor.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

        <a href="{{ route('reports.stock') }}" class="report-card group">
            <div class="icon-badge w-11 h-11 !rounded-xl bg-brand/10 mb-4">
                <svg class="w-5 h-5 text-brand-dark" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0v10l-8 4m8-14l-8 4m0 10l-8-4V7m8 10V7"/></svg>
            </div>
            <h2 class="font-display font-semibold text-ink text-sm mb-1">Laporan Stok Barang</h2>
            <p class="text-xs text-steel">Ringkasan stok per periode & kategori, termasuk barang menipis.</p>
            <span class="report-card-arrow">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" d="M7.5 5l5 5-5 5"/></svg>
            </span>
        </a>

        <a href="{{ route('reports.transactions') }}" class="report-card group">
            <div class="icon-badge w-11 h-11 !rounded-xl bg-freight/10 mb-4">
                <svg class="w-5 h-5 text-freight" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4M16 17H4m0 0l4 4m-4-4l4-4"/></svg>
            </div>
            <h2 class="font-display font-semibold text-ink text-sm mb-1">Laporan Barang Masuk & Keluar</h2>
            <p class="text-xs text-steel">Riwayat transaksi lengkap dengan filter tanggal & jenis.</p>
            <span class="report-card-arrow">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" d="M7.5 5l5 5-5 5"/></svg>
            </span>
        </a>

        @if (auth()->user()->role === 'Admin')
        <a href="{{ route('reports.user-activity') }}" class="report-card group">
            <div class="icon-badge w-11 h-11 !rounded-xl bg-amber/12 mb-4">
                <svg class="w-5 h-5 text-amber-dark" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14c-4.4 0-8 2.2-8 5v1h16v-1c0-2.8-3.6-5-8-5z"/></svg>
            </div>
            <h2 class="font-display font-semibold text-ink text-sm mb-1">Laporan Aktivitas Pengguna</h2>
            <p class="text-xs text-steel">Log siapa melakukan apa dan kapan di seluruh sistem.</p>
            <span class="report-card-arrow">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" d="M7.5 5l5 5-5 5"/></svg>
            </span>
        </a>
        @endif

    </div>
</x-app-layout>