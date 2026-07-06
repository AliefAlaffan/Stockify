<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    <div class="mb-6">
        <p class="font-mono-data text-[11px] tracking-widest text-steel uppercase mb-1">Manajer Gudang</p>
        <h1 class="font-display text-2xl font-semibold text-ink">Selamat datang, {{ auth()->user()->name }}</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="card-elevated stat-card stat-rust animate-fade-up bg-white p-5 rounded-xl border border-gray-100" style="animation-delay: 0ms">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-steel uppercase tracking-wide">Stok Menipis</p>
                    <p class="font-display text-3xl font-bold text-rust mt-2">{{ $lowStockProducts->count() }}</p>
                </div>
                <div class="icon-badge bg-rust/15">
                    <svg class="w-5 h-5 text-rust" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l6.28 11.184c.75 1.334-.213 2.985-1.742 2.985H3.72c-1.53 0-2.493-1.65-1.743-2.985L8.257 3.1zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-.25-6.25a.75.75 0 00-1.5 0v3.5a.75.75 0 001.5 0v-3.5z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="card-elevated stat-card stat-depot animate-fade-up bg-white p-5 rounded-xl border border-gray-100" style="animation-delay: 60ms">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-steel uppercase tracking-wide">Masuk Hari Ini</p>
                    <p class="font-display text-3xl font-bold text-depot mt-2">{{ $incomingToday }}</p>
                </div>
                <div class="icon-badge bg-depot/15">
                    <svg class="w-5 h-5 text-depot" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V3a1 1 0 012 0v9.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                </div>
            </div>
        </div>
        <div class="card-elevated stat-card stat-freight animate-fade-up bg-white p-5 rounded-xl border border-gray-100" style="animation-delay: 120ms">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-steel uppercase tracking-wide">Keluar Hari Ini</p>
                    <p class="font-display text-3xl font-bold text-freight mt-2">{{ $outgoingToday }}</p>
                </div>
                <div class="icon-badge bg-freight/15">
                    <svg class="w-5 h-5 text-freight" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V17a1 1 0 01-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="card-elevated animate-fade-up bg-white rounded-xl border border-gray-100" style="animation-delay: 180ms">
        <div class="p-5 border-b border-gray-100">
            <p class="font-mono-data text-[10px] tracking-widest text-steel uppercase">Perlu Perhatian</p>
            <h2 class="font-display font-semibold text-ink mt-0.5">Produk dengan Stok Menipis</h2>
        </div>

        <div class="divide-y divide-gray-100">
            @forelse ($lowStockProducts as $product)
                @php
                    $ratio = $product->minimum_stock > 0 ? min(100, ($product->current_stock / $product->minimum_stock) * 100) : 0;
                    $severity = $ratio <= 0 ? 'bg-rust' : ($ratio < 50 ? 'bg-amber' : 'bg-amber-dark');
                @endphp
                <div class="p-5 flex items-center gap-4 hover:bg-canvas-alt/60 transition-colors">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1.5">
                            <p class="font-medium text-ink text-sm">{{ $product->name }}</p>
                            <span class="stock-tag bg-canvas-alt text-steel">{{ $product->sku }}</span>
                        </div>
                        <div class="progress-track w-full max-w-xs">
                            <div class="progress-bar {{ $severity }}" style="width: {{ $ratio }}%"></div>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-display text-lg font-bold text-ink">{{ $product->current_stock }}<span class="text-steel-light text-sm font-normal"> / {{ $product->minimum_stock }}</span></p>
                        <p class="text-[11px] text-steel-light uppercase tracking-wide">stok / minimum</p>
                    </div>
                </div>
            @empty
                <div class="p-10 text-center">
                    <p class="text-3xl mb-2">✓</p>
                    <p class="text-sm text-steel">Semua stok dalam kondisi aman</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>