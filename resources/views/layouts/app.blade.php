<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Stockify') }} @isset($header) — {{ $header }} @endisset</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-canvas font-body text-ink antialiased">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200/80 fixed z-30 w-full">
        <div class="px-4 py-3 lg:px-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar"
                        class="p-2 text-steel rounded-lg cursor-pointer lg:hidden hover:bg-canvas-alt">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z" clip-rule="evenodd"></path>
                        </svg>
                    </button>

                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                        <span class="flex items-center justify-center w-8 h-8 rounded bg-ink text-amber font-display font-bold text-sm">S</span>
                        <span class="font-display font-semibold text-lg tracking-tight text-ink">Stockify</span>
                    </a>

                    <!-- Breadcrumb ala manifest tag -->
                    @isset($header)
                        <span class="hidden md:inline-flex items-center gap-2 pl-4 ml-1 border-l border-gray-200 font-mono-data text-[11px] uppercase tracking-wider text-steel">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber"></span>
                            {{ $header }}
                        </span>
                    @endisset
                </div>

                <div class="flex items-center gap-3">
                    <span class="hidden sm:inline-flex stock-tag bg-canvas-alt text-ink-soft">
                        <span class="stock-tag-dot bg-amber"></span>
                        {{ strtoupper(auth()->user()->role) }}
                    </span>

                    <div>
                        <button type="button" class="flex items-center gap-2.5 pl-1 pr-2 py-1 rounded-full hover:bg-canvas-alt"
                            id="user-menu-button" data-dropdown-toggle="dropdown-user">
                            <div class="w-8 h-8 rounded-full bg-ink text-white flex items-center justify-center font-display font-semibold text-sm">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <svg class="w-3.5 h-3.5 text-steel" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"></path>
                            </svg>
                        </button>

                        <div class="hidden z-50 my-2 w-56 text-base bg-white divide-y divide-gray-100 rounded-xl shadow-lg border border-gray-100" id="dropdown-user">
                            <div class="px-4 py-3">
                                <p class="text-sm font-semibold text-ink">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-steel truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <ul class="py-1">
                                <li>
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-ink-soft hover:bg-canvas-alt">Profil Saya</a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                                            class="block px-4 py-2 text-sm text-rust hover:bg-canvas-alt">Keluar</a>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed top-0 left-0 z-20 flex flex-col w-64 h-full pt-16 lg:flex bg-white border-r border-gray-200/80">
        <div class="flex flex-col flex-1 pt-4 pb-4 overflow-y-auto sidebar-scroll">
            <nav class="flex-1 px-3 space-y-6">

                <div>
                    <p class="px-3 mb-1 text-[10px] font-semibold tracking-widest text-steel-light uppercase">Utama</p>
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-r-lg text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-ink' : 'text-ink-soft hover:bg-canvas-alt' }}">
                        <svg class="w-[18px] h-[18px] {{ request()->routeIs('dashboard') ? 'text-amber-dark' : 'text-steel' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Dashboard
                    </a>
                </div>

                @if(in_array(auth()->user()->role, ['Admin', 'Manajer Gudang']))
                <div>
                    <p class="px-3 mb-1 text-[10px] font-semibold tracking-widest text-steel-light uppercase">Data Master</p>
                    <div class="space-y-0.5">
                        <a href="{{ route('products.index') }}"
                            class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-r-lg text-sm font-medium {{ request()->routeIs('products.*') ? 'text-ink' : 'text-ink-soft hover:bg-canvas-alt' }}">
                            <svg class="w-[18px] h-[18px] {{ request()->routeIs('products.*') ? 'text-amber-dark' : 'text-steel' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                            </svg>
                            Produk
                        </a>
                        @if(auth()->user()->role === 'Admin')
                        <a href="{{ route('categories.index') }}"
                            class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-r-lg text-sm font-medium {{ request()->routeIs('categories.*') ? 'text-ink' : 'text-ink-soft hover:bg-canvas-alt' }}">
                            <svg class="w-[18px] h-[18px] {{ request()->routeIs('categories.*') ? 'text-amber-dark' : 'text-steel' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v10a2 2 0 002 2h10a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H5a1 1 0 000 2z" clip-rule="evenodd"></path>
                            </svg>
                            Kategori
                        </a>
                        <a href="{{ route('suppliers.index') }}"
                            class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-r-lg text-sm font-medium {{ request()->routeIs('suppliers.*') ? 'text-ink' : 'text-ink-soft hover:bg-canvas-alt' }}">
                            <svg class="w-[18px] h-[18px] {{ request()->routeIs('suppliers.*') ? 'text-amber-dark' : 'text-steel' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 00-1 1v9a2 2 0 002 2h.05a2.5 2.5 0 014.9 0h4.1a2.5 2.5 0 014.9 0H18a1 1 0 001-1v-4.19a1 1 0 00-.293-.707l-2.81-2.81A1 1 0 0015.19 7H14V5a1 1 0 00-1-1H3z"></path>
                            </svg>
                            Supplier
                        </a>
                        @endif
                    </div>
                </div>
                @endif

                @if(auth()->user()->role !== 'Admin')
                <div>
                    <p class="px-3 mb-1 text-[10px] font-semibold tracking-widest text-steel-light uppercase">Operasi</p>
                    <div class="space-y-0.5">
                        @if(auth()->user()->role === 'Manajer Gudang')
                        <a href="{{ route('stock-transactions.in.index') }}"
                            class="nav-link {{ request()->routeIs('stock-transactions.in.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-r-lg text-sm font-medium {{ request()->routeIs('stock-transactions.in.*') ? 'text-ink' : 'text-ink-soft hover:bg-canvas-alt' }}">
                            <svg class="w-[18px] h-[18px] {{ request()->routeIs('stock-transactions.in.*') ? 'text-depot' : 'text-steel' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd"></path>
                            </svg>
                            Barang Masuk
                        </a>
                        <a href="{{ route('stock-transactions.out.index') }}"
                            class="nav-link {{ request()->routeIs('stock-transactions.out.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-r-lg text-sm font-medium {{ request()->routeIs('stock-transactions.out.*') ? 'text-ink' : 'text-ink-soft hover:bg-canvas-alt' }}">
                            <svg class="w-[18px] h-[18px] {{ request()->routeIs('stock-transactions.out.*') ? 'text-rust' : 'text-steel' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a.75.75 0 000 1.5h6A.75.75 0 0013 9H7z" clip-rule="evenodd"></path>
                            </svg>
                            Barang Keluar
                        </a>
                        <a href="{{ route('stock-opname.index') }}"
                            class="nav-link {{ request()->routeIs('stock-opname.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-r-lg text-sm font-medium {{ request()->routeIs('stock-opname.*') ? 'text-ink' : 'text-ink-soft hover:bg-canvas-alt' }}">
                            <svg class="w-[18px] h-[18px] {{ request()->routeIs('stock-opname.*') ? 'text-amber-dark' : 'text-steel' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3z" clip-rule="evenodd"></path>
                            </svg>
                            Stock Opname
                        </a>
                        @endif

                        @if(auth()->user()->role === 'Staff Gudang')
                        <a href="{{ route('stock-transactions.confirm.incoming') }}"
                            class="nav-link {{ request()->routeIs('stock-transactions.confirm.incoming') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-r-lg text-sm font-medium {{ request()->routeIs('stock-transactions.confirm.incoming') ? 'text-ink' : 'text-ink-soft hover:bg-canvas-alt' }}">
                            <svg class="w-[18px] h-[18px] {{ request()->routeIs('stock-transactions.confirm.incoming') ? 'text-depot' : 'text-steel' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"></path>
                            </svg>
                            Konfirmasi Masuk
                        </a>
                        <a href="{{ route('stock-transactions.confirm.outgoing') }}"
                            class="nav-link {{ request()->routeIs('stock-transactions.confirm.outgoing') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-r-lg text-sm font-medium {{ request()->routeIs('stock-transactions.confirm.outgoing') ? 'text-ink' : 'text-ink-soft hover:bg-canvas-alt' }}">
                            <svg class="w-[18px] h-[18px] {{ request()->routeIs('stock-transactions.confirm.outgoing') ? 'text-rust' : 'text-steel' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"></path>
                            </svg>
                            Konfirmasi Keluar
                        </a>
                        @endif
                    </div>
                </div>
                @endif

                @if(in_array(auth()->user()->role, ['Admin', 'Manajer Gudang']))
                <div>
                    <p class="px-3 mb-1 text-[10px] font-semibold tracking-widest text-steel-light uppercase">Laporan</p>
                    <a href="#" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-r-lg text-sm font-medium text-ink-soft hover:bg-canvas-alt">
                        <svg class="w-[18px] h-[18px] text-steel" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V4z" clip-rule="evenodd"></path>
                        </svg>
                        Laporan
                    </a>
                </div>
                @endif

                @if(auth()->user()->role === 'Admin')
                <div>
                    <p class="px-3 mb-1 text-[10px] font-semibold tracking-widest text-steel-light uppercase">Sistem</p>
                    <div class="space-y-0.5">
                        <a href="#" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-r-lg text-sm font-medium text-ink-soft hover:bg-canvas-alt">
                            <svg class="w-[18px] h-[18px] text-steel" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                            Pengguna
                        </a>
                        <a href="#" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-r-lg text-sm font-medium text-ink-soft hover:bg-canvas-alt">
                            <svg class="w-[18px] h-[18px] text-steel" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                            </svg>
                            Pengaturan
                        </a>
                    </div>
                </div>
                @endif

            </nav>

            <!-- Footer mini sidebar -->
            <div class="px-3 pt-4 mt-2 border-t border-gray-100">
                <div class="stock-tag bg-canvas-alt text-steel w-full justify-center py-2">
                    <span class="stock-tag-dot bg-depot"></span>
                    SISTEM AKTIF
                </div>
            </div>
        </div>
    </aside>

    <!-- Main content -->
    <div class="pt-16 lg:pl-64">
        <main class="p-5 lg:p-7 max-w-[1400px]">
            {{ $slot }}
        </main>
    </div>

</body>
</html>