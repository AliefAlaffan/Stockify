@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/stockify-icon-256.png') }}">

   <title>{{ setting('app_name', config('app.name', 'Stockify')) }} — @isset($header){{ $header }}@else Dashboard @endisset</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-canvas font-body text-ink antialiased">

   <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200/80 fixed z-30 w-full">
        <div class="px-4 py-2.5 lg:px-5">
            <div class="flex items-center justify-between">

                 <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        @if (setting('app_logo'))
                            <img src="{{ Storage::url(setting('app_logo')) }}" alt="{{ setting('app_name', 'Stockify') }}" class="h-10 w-auto object-contain">
                        @else
                            <img src="{{ asset('images/stockify-logo-full.png') }}" alt="Stockify" class="h-10 w-auto object-contain">
                        @endif
                    </a>
                </div>

                <!-- Kanan: Jam, Role, Profil -->
                <div class="flex items-center gap-3">

                    <!-- Jam & Tanggal Live -->
                    <div class="hidden md:flex items-center gap-2.5 pr-3 mr-1 border-r border-gray-200">
                        <div class="icon-badge w-8 h-8 !rounded-lg bg-canvas-alt">
                            <svg class="w-4 h-4 text-steel" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M10 5.5V10l3 1.5M17.5 10a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z"/>
                            </svg>
                        </div>
                        <div class="leading-tight">
                            <p id="live-date" class="text-xs font-medium text-ink-soft">—</p>
                            <p id="live-time" class="font-mono-data text-sm font-semibold text-ink tabular-nums">--:--:--</p>
                        </div>
                    </div>

                    <!-- Role Badge -->
                    <span class="hidden sm:inline-flex stock-tag bg-canvas-alt text-ink-soft">
                        <span class="w-1.5 h-1.5 rounded-full bg-brand animate-pulse"></span>
                        {{ strtoupper(auth()->user()->role) }}
                    </span>

                    <!-- Profil Dropdown -->
                    <div>
                        <button type="button" class="flex items-center gap-2 pl-1 pr-1.5 py-1 rounded-full border border-transparent hover:border-gray-200 hover:bg-canvas-alt transition-colors"
                            id="user-menu-button" data-dropdown-toggle="dropdown-user" data-dropdown-placement="bottom-end">
                            <div class="w-8 h-8 rounded-full bg-ink text-white flex items-center justify-center font-display font-semibold text-sm ring-2 ring-white shadow-sm">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <svg class="w-3.5 h-3.5 text-steel mr-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"></path>
                            </svg>
                        </button>

                        <div class="hidden z-50 mt-2 w-64 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden" id="dropdown-user">
                            <!-- Header -->
                            <div class="flex items-center gap-3 px-4 py-3.5 bg-canvas-alt/60">
                                <div class="w-10 h-10 rounded-xl bg-ink text-white flex items-center justify-center font-display font-semibold text-sm flex-shrink-0">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-ink truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-steel truncate">{{ auth()->user()->email }}</p>
                                </div>
                            </div>

                            <!-- Role tag -->
                            <div class="px-4 py-2.5 border-b border-gray-100">
                                <span class="stock-tag bg-canvas-alt text-ink-soft">
                                    <span class="stock-tag-dot bg-brand"></span>
                                    {{ strtoupper(auth()->user()->role) }}
                                </span>
                            </div>

                            <!-- Menu items -->
                            <ul class="py-1.5">
                                <li>
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-ink-soft hover:bg-canvas-alt transition-colors">
                                        <svg class="w-4 h-4 text-steel" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M13.5 6.5a3.5 3.5 0 11-7 0 3.5 3.5 0 017 0zM3.5 17.25c0-3.176 2.91-5.75 6.5-5.75s6.5 2.574 6.5 5.75"/>
                                        </svg>
                                        Profil Saya
                                    </a>
                                </li>
                            </ul>

                            <!-- Logout -->
                            <div class="p-1.5 border-t border-gray-100">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-rust hover:bg-rust/8 transition-colors">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" d="M7 15.5H4.5A1.5 1.5 0 013 14V6a1.5 1.5 0 011.5-1.5H7M13 13.5l3.5-3.5-3.5-3.5M16.5 10H7.5"/>
                                        </svg>
                                        Keluar
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed top-0 left-0 z-20 flex flex-col w-64 h-full pt-16 lg:flex bg-white border-r border-gray-200/80">

        <div class="flex flex-col flex-1 pt-6 pb-4 overflow-y-auto sidebar-scroll">
            <nav class="flex-1 px-4 space-y-7">

                <!-- UTAMA -->
                <div class="sidebar-item-in" style="animation-delay: 0ms">
                    <p class="sidebar-group-title px-2 mb-2.5 text-[10px] font-semibold tracking-widest text-steel-light uppercase">Utama</p>
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }} flex items-center gap-3 px-2.5 py-2.5 rounded-2xl text-sm {{ request()->routeIs('dashboard') ? 'text-ink font-semibold' : 'text-ink-soft font-medium' }}">
                        <span class="nav-icon w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 {{ request()->routeIs('dashboard') ? 'bg-brand text-white shadow-sm shadow-brand/40' : 'text-steel' }}">
                            <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                        </span>
                        <span class="sidebar-label">Dashboard</span>
                    </a>
                </div>

                <!-- DATA MASTER -->
                @if(in_array(auth()->user()->role, ['Admin', 'Manajer Gudang']))
                <div class="sidebar-item-in" style="animation-delay: 40ms">
                    <button type="button" class="sidebar-group-title flex items-center justify-between w-full px-2 mb-2.5" data-group-toggle="master">
                        <span class="text-[10px] font-semibold tracking-widest text-steel-light uppercase">Data Master</span>
                        <svg class="group-chevron w-3 h-3 text-steel-light" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/></svg>
                    </button>
                    <div class="group-items space-y-1.5" data-group="master">
                        <a href="{{ route('products.index') }}"
                            class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }} flex items-center gap-3 px-2.5 py-2.5 rounded-2xl text-sm {{ request()->routeIs('products.*') ? 'text-ink font-semibold' : 'text-ink-soft font-medium' }}">
                            <span class="nav-icon w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 {{ request()->routeIs('products.*') ? 'bg-brand text-white shadow-sm shadow-brand/40' : 'text-steel' }}">
                                <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path></svg>
                            </span>
                            <span class="sidebar-label">Produk</span>
                        
                        </a>
                        @if(auth()->user()->role === 'Admin')
                        <a href="{{ route('categories.index') }}"
                            class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }} flex items-center gap-3 px-2.5 py-2.5 rounded-2xl text-sm {{ request()->routeIs('categories.*') ? 'text-ink font-semibold' : 'text-ink-soft font-medium' }}">
                            <span class="nav-icon w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 {{ request()->routeIs('categories.*') ? 'bg-brand text-white shadow-sm shadow-brand/40' : 'text-steel' }}">
                                <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 3a1 1 0 000 2v10a2 2 0 002 2h10a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H5a1 1 0 000 2z" clip-rule="evenodd"/></svg>
                            </span>
                            <span class="sidebar-label">Kategori</span>
                        
                        </a>
                        <a href="{{ route('suppliers.index') }}"
                            class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }} flex items-center gap-3 px-2.5 py-2.5 rounded-2xl text-sm {{ request()->routeIs('suppliers.*') ? 'text-ink font-semibold' : 'text-ink-soft font-medium' }}">
                            <span class="nav-icon w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 {{ request()->routeIs('suppliers.*') ? 'bg-brand text-white shadow-sm shadow-brand/40' : 'text-steel' }}">
                                <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 00-1 1v9a2 2 0 002 2h.05a2.5 2.5 0 014.9 0h4.1a2.5 2.5 0 014.9 0H18a1 1 0 001-1v-4.19a1 1 0 00-.293-.707l-2.81-2.81A1 1 0 0015.19 7H14V5a1 1 0 00-1-1H3z"/></svg>
                            </span>
                            <span class="sidebar-label">Supplier</span>
                           
                        </a>
                        @endif
                    </div>
                </div>
                @endif

                <!-- OPERASI -->
                @if(auth()->user()->role !== 'Admin')
                <div class="sidebar-item-in" style="animation-delay: 80ms">
                    <button type="button" class="sidebar-group-title flex items-center justify-between w-full px-2 mb-2.5" data-group-toggle="operasi">
                        <span class="text-[10px] font-semibold tracking-widest text-steel-light uppercase">Operasi</span>
                        <svg class="group-chevron w-3 h-3 text-steel-light" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/></svg>
                    </button>
                    <div class="group-items space-y-1.5" data-group="operasi">
                        @if(auth()->user()->role === 'Manajer Gudang')
                        <a href="{{ route('stock-transactions.in.index') }}"
                            class="nav-link {{ request()->routeIs('stock-transactions.in.*') ? 'active' : '' }} flex items-center gap-3 px-2.5 py-2.5 rounded-2xl text-sm {{ request()->routeIs('stock-transactions.in.*') ? 'text-ink font-semibold' : 'text-ink-soft font-medium' }}">
                            <span class="nav-icon w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 {{ request()->routeIs('stock-transactions.in.*') ? 'bg-brand text-white shadow-sm shadow-brand/40' : 'text-steel' }}">
                                <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd"/></svg>
                            </span>
                            <span class="sidebar-label">Barang Masuk</span>
                            
                        </a>
                        <a href="{{ route('stock-transactions.out.index') }}"
                            class="nav-link {{ request()->routeIs('stock-transactions.out.*') ? 'active' : '' }} flex items-center gap-3 px-2.5 py-2.5 rounded-2xl text-sm {{ request()->routeIs('stock-transactions.out.*') ? 'text-ink font-semibold' : 'text-ink-soft font-medium' }}">
                            <span class="nav-icon w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 {{ request()->routeIs('stock-transactions.out.*') ? 'bg-brand text-white shadow-sm shadow-brand/40' : 'text-steel' }}">
                                <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a.75.75 0 000 1.5h6A.75.75 0 0013 9H7z" clip-rule="evenodd"/></svg>
                            </span>
                            <span class="sidebar-label">Barang Keluar</span>
                            
                        </a>
                        <a href="{{ route('stock-opname.index') }}"
                            class="nav-link {{ request()->routeIs('stock-opname.*') ? 'active' : '' }} flex items-center gap-3 px-2.5 py-2.5 rounded-2xl text-sm {{ request()->routeIs('stock-opname.*') ? 'text-ink font-semibold' : 'text-ink-soft font-medium' }}">
                            <span class="nav-icon w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 {{ request()->routeIs('stock-opname.*') ? 'bg-brand text-white shadow-sm shadow-brand/40' : 'text-steel' }}">
                                <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3z" clip-rule="evenodd"/></svg>
                            </span>
                            <span class="sidebar-label">Stock Opname</span>
                            
                        </a>
                        @endif

                        @if(auth()->user()->role === 'Staff Gudang')
                        <a href="{{ route('stock-transactions.confirm.incoming') }}"
                            class="nav-link {{ request()->routeIs('stock-transactions.confirm.incoming') ? 'active' : '' }} flex items-center gap-3 px-2.5 py-2.5 rounded-2xl text-sm {{ request()->routeIs('stock-transactions.confirm.incoming') ? 'text-ink font-semibold' : 'text-ink-soft font-medium' }}">
                            <span class="nav-icon w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 {{ request()->routeIs('stock-transactions.confirm.incoming') ? 'bg-brand text-white shadow-sm shadow-brand/40' : 'text-steel' }}">
                                <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/></svg>
                            </span>
                            <span class="sidebar-label">Konfirmasi Masuk</span>
                       
                        </a>
                        <a href="{{ route('stock-transactions.confirm.outgoing') }}"
                            class="nav-link {{ request()->routeIs('stock-transactions.confirm.outgoing') ? 'active' : '' }} flex items-center gap-3 px-2.5 py-2.5 rounded-2xl text-sm {{ request()->routeIs('stock-transactions.confirm.outgoing') ? 'text-ink font-semibold' : 'text-ink-soft font-medium' }}">
                            <span class="nav-icon w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 {{ request()->routeIs('stock-transactions.confirm.outgoing') ? 'bg-brand text-white shadow-sm shadow-brand/40' : 'text-steel' }}">
                                <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/></svg>
                            </span>
                            <span class="sidebar-label">Konfirmasi Keluar</span>
                            
                        </a>
                        @endif
                    </div>
                </div>
                @endif

                <!-- LAPORAN -->
                @if(in_array(auth()->user()->role, ['Admin', 'Manajer Gudang']))
                <div class="sidebar-item-in" style="animation-delay: 120ms">
                    <p class="sidebar-group-title px-2 mb-2.5 text-[10px] font-semibold tracking-widest text-steel-light uppercase">Laporan</p>
                    <a href="{{ route('reports.index') }}" class="nav-link flex items-center gap-3 px-2.5 py-2.5 rounded-2xl text-sm text-ink-soft font-medium">
                        <span class="nav-icon w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 text-steel">
                            <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V4z" clip-rule="evenodd"/></svg>
                        </span>
                        <span class="sidebar-label">Laporan</span>
                        
                    </a>
                </div>
                @endif

                <!-- SISTEM -->
                @if(auth()->user()->role === 'Admin')
                <div class="sidebar-item-in" style="animation-delay: 160ms">
                    <p class="sidebar-group-title px-2 mb-2.5 text-[10px] font-semibold tracking-widest text-steel-light uppercase">Sistem</p>
                    <div class="space-y-1.5">
                        <a href="{{ route('users.index') }}"
                            class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }} flex items-center gap-3 px-2.5 py-2.5 rounded-2xl text-sm {{ request()->routeIs('users.*') ? 'text-ink font-semibold' : 'text-ink-soft font-medium' }}">
                            <span class="nav-icon w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 {{ request()->routeIs('users.*') ? 'bg-brand text-white shadow-sm shadow-brand/40' : 'text-steel' }}">
                                <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                            </span>
                            <span class="sidebar-label">Pengguna</span>
                        </a>
                        <a href="{{ route('settings.edit') }}"
                            class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }} flex items-center gap-3 px-2.5 py-2.5 rounded-2xl text-sm {{ request()->routeIs('settings.*') ? 'text-ink font-semibold' : 'text-ink-soft font-medium' }}">
                            <span class="nav-icon w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 {{ request()->routeIs('settings.*') ? 'bg-brand text-white shadow-sm shadow-brand/40' : 'text-steel' }}">
                                <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/></svg>
                            </span>
                            <span class="sidebar-label">Pengaturan</span>
                        </a>
                    </div>
                </div>
                @endif

            </nav>

        </div>
    </aside>

    <!-- Main content -->
    <div class="main-content pt-16 lg:pl-64 transition-all duration-300">
        <main class="p-5 lg:p-7 max-w-[1400px]">
            {{ $slot }}
        </main>
    </div>

    <script>
        document.querySelectorAll('[data-group-toggle]').forEach(btn => {
            btn.addEventListener('click', () => {
                btn.parentElement.classList.toggle('group-collapsed');
            });
        });
        function updateLiveClock() {
            const now = new Date();
            const dateFormatter = new Intl.DateTimeFormat('id-ID', { weekday: 'long', day: '2-digit', month: 'long', year: 'numeric' });
            const timeFormatter = new Intl.DateTimeFormat('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false });

            const dateEl = document.getElementById('live-date');
            const timeEl = document.getElementById('live-time');
            if (dateEl) dateEl.textContent = dateFormatter.format(now);
            if (timeEl) timeEl.textContent = timeFormatter.format(now);
        }

        updateLiveClock();
        setInterval(updateLiveClock, 1000);
    </script>
</body>
</html>