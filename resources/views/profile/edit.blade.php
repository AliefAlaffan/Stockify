<x-app-layout>
    <x-slot name="header">Profil Saya</x-slot>

    <div class="mb-6">
        <p class="font-mono-data text-[11px] tracking-widest text-steel uppercase mb-1">Akun</p>
        <h1 class="font-display text-xl font-semibold text-ink">Pengaturan Profil</h1>
    </div>

    <div class="max-w-2xl space-y-5">

        @if (auth()->user()->role === 'Admin')

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                @include('profile.partials.update-password-form')
            </div>

            <div class="bg-white rounded-2xl border border-rust/15 shadow-sm p-6">
                @include('profile.partials.delete-user-form')
            </div>

        @else

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center gap-2 mb-5 pb-5 border-b border-gray-100">
                    <div class="flex items-center justify-center w-11 h-11 rounded-full bg-brand/10 text-brand-dark font-semibold flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="font-display font-semibold text-ink text-sm">{{ auth()->user()->name }}</h2>
                        <p class="text-xs text-steel">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <p class="text-xs text-steel uppercase tracking-wide mb-1">Role</p>
                        @if (auth()->user()->role === 'Manajer Gudang')
                            <span class="stock-tag bg-brand/12 text-brand-dark"><span class="stock-tag-dot bg-brand"></span>Manajer Gudang</span>
                        @else
                            <span class="stock-tag bg-freight/12 text-freight"><span class="stock-tag-dot bg-freight"></span>Staff Gudang</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs text-steel uppercase tracking-wide mb-1">Bergabung Sejak</p>
                        <p class="font-medium text-ink text-sm">{{ auth()->user()->created_at->format('d M Y') }}</p>
                    </div>
                </div>

                <div class="flex items-start gap-2.5 p-4 bg-canvas-alt/60 rounded-xl">
                    <svg class="w-4 h-4 text-steel flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" d="M10 6v4m0 4h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-xs text-steel leading-relaxed">Perubahan nama, email, atau password hanya bisa dilakukan oleh Admin. Hubungi Admin jika ada data yang perlu diperbarui.</p>
                </div>
            </div>

        @endif

    </div>
</x-app-layout>