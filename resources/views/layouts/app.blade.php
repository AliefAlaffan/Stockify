<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Stockify') }} @isset($header) - {{ $header }} @endisset</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200 fixed z-30 w-full">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">
                    <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar"
                        class="p-2 mr-2 text-gray-600 rounded-lg cursor-pointer lg:hidden hover:text-gray-900 hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                        </svg>
                    </button>
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <span class="self-center text-xl font-semibold whitespace-nowrap text-blue-600">Stockify</span>
                    </a>
                </div>

                <div class="flex items-center">
                    <div class="flex items-center ml-3">
                        <div>
                            <button type="button" class="flex text-sm bg-gray-200 rounded-full focus:ring-4 focus:ring-gray-300"
                                id="user-menu-button" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                <span class="sr-only">Buka menu user</span>
                                <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center font-semibold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            </button>
                        </div>
                        <div class="hidden ml-3 text-left lg:block" >
                            <p class="text-sm font-medium text-gray-800">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ auth()->user()->role }}</p>
                        </div>
                        <!-- Dropdown menu -->
                        <div class="hidden z-50 my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow border" id="dropdown-user">
                            <div class="px-4 py-3">
                                <p class="text-sm text-gray-900 font-medium">{{ auth()->user()->name }}</p>
                                <p class="text-sm text-gray-500 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <ul class="py-1">
                                <li>
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Saya</a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Keluar
                                        </a>
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
    <aside id="sidebar" class="fixed top-0 left-0 z-20 flex flex-col flex-shrink-0 w-64 h-full pt-16 font-normal duration-75 lg:flex transition-width bg-white border-r border-gray-200"
        aria-label="Sidebar">
        <div class="relative flex flex-col flex-1 min-h-0 pt-0">
            <div class="flex flex-col flex-1 pt-5 pb-4 overflow-y-auto">
                <div class="flex-1 px-3 space-y-1 bg-white divide-y divide-gray-200">
                    <ul class="pb-2 space-y-1">

                        <li>
                            <a href="{{ route('dashboard') }}"
                                class="flex items-center p-2 text-base font-medium rounded-lg group {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-900 hover:bg-gray-100' }}">
                                <svg class="w-6 h-6 {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-500 group-hover:text-gray-900' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                                <span class="ml-3">Dashboard</span>
                            </a>
                        </li>

                        @if(in_array(auth()->user()->role, ['Admin', 'Manajer Gudang']))
                        <li>
                            <button type="button" class="flex items-center w-full p-2 text-base font-medium text-gray-900 rounded-lg group hover:bg-gray-100"
                                data-collapse-toggle="dropdown-produk">
                                <svg class="flex-shrink-0 w-6 h-6 text-gray-500 group-hover:text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                                </svg>
                                <span class="flex-1 ml-3 text-left whitespace-nowrap">Produk</span>
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <ul id="dropdown-produk" class="py-2 space-y-1">
                                <li>
                                    <a href="{{ route('products.index') }}" class="flex items-center p-2 pl-11 text-sm rounded-lg {{ request()->routeIs('products.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-900 hover:bg-gray-100' }}">
                                        Daftar Produk
                                    </a>
                                </li>
                                @if(auth()->user()->role === 'Admin')
                                <li>
                                    <a href="{{ route('categories.index') }}" class="flex items-center p-2 pl-11 text-sm rounded-lg {{ request()->routeIs('categories.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-900 hover:bg-gray-100' }}">
                                        Kategori
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif

                        @if(auth()->user()->role === 'Admin')
                        <li>
                            <a href="{{ route('suppliers.index') }}"
                                class="flex items-center p-2 text-base font-medium rounded-lg group {{ request()->routeIs('suppliers.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-900 hover:bg-gray-100' }}">
                                <svg class="w-6 h-6 {{ request()->routeIs('suppliers.*') ? 'text-blue-600' : 'text-gray-500 group-hover:text-gray-900' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                                    <path d="M3 4a1 1 0 00-1 1v9a2 2 0 002 2h.05a2.5 2.5 0 014.9 0h4.1a2.5 2.5 0 014.9 0H18a1 1 0 001-1v-4.19a1 1 0 00-.293-.707l-2.81-2.81A1 1 0 0015.19 7H14V5a1 1 0 00-1-1H3z"></path>
                                </svg>
                                <span class="ml-3">Supplier</span>
                            </a>
                        </li>
                        @endif

                        @if(auth()->user()->role !== 'Admin')
                        <li>
                            <a href="#"
                                class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg group hover:bg-gray-100">
                                <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                    <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"></path>
                                </svg>
                                <span class="ml-3">Transaksi Stok</span>
                            </a>
                        </li>
                        @endif

                        @if(auth()->user()->role === 'Manajer Gudang')
                        <li>
                            <a href="#" class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg group hover:bg-gray-100">
                                <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-3">Stock Opname</span>
                            </a>
                        </li>
                        @endif

                        @if(in_array(auth()->user()->role, ['Admin', 'Manajer Gudang']))
                        <li>
                            <a href="#" class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg group hover:bg-gray-100">
                                <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-3">Laporan</span>
                            </a>
                        </li>
                        @endif

                        @if(auth()->user()->role === 'Admin')
                        <li>
                            <a href="#" class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg group hover:bg-gray-100">
                                <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-3">Pengguna</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg group hover:bg-gray-100">
                                <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-3">Pengaturan</span>
                            </a>
                        </li>
                        @endif

                    </ul>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main content -->
    <div class="pt-16 lg:pl-64">
        <main class="p-4">
            @isset($header)
                <div class="mb-6">
                    <h1 class="text-2xl font-semibold text-gray-800">{{ $header }}</h1>
                </div>
            @endisset

            {{ $slot }}
        </main>
    </div>

</body>
</html>