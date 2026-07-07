<div class="flex items-center gap-2 mb-5 pb-5 border-b border-gray-100">
    <div class="icon-badge w-9 h-9 !rounded-lg bg-brand/10">
        <svg class="w-4 h-4 text-brand-dark" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14c-4.4 0-8 2.2-8 5v1h16v-1c0-2.8-3.6-5-8-5z"/></svg>
    </div>
    <div>
        <h2 class="font-display font-semibold text-ink text-sm">Informasi Profil</h2>
        <p class="text-xs text-steel mt-0.5">Perbarui nama dan alamat email akunmu.</p>
    </div>
</div>

<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}" class="space-y-4">
    @csrf
    @method('patch')

    <div>
        <label for="name" class="block mb-1.5 text-sm font-medium text-ink">Nama</label>
        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
            class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
        @error('name', 'updateProfileInformation') <p class="mt-1.5 text-sm text-rust">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="email" class="block mb-1.5 text-sm font-medium text-ink">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
            class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
        @error('email', 'updateProfileInformation') <p class="mt-1.5 text-sm text-rust">{{ $message }}</p> @enderror

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="mt-2.5 flex items-start gap-2 p-3 bg-amber/8 border border-amber/15 rounded-xl">
                <svg class="w-4 h-4 text-amber-dark flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" d="M10 6v4m0 4h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-xs text-amber-dark leading-relaxed">
                    Email kamu belum terverifikasi.
                    <button form="send-verification" class="underline font-medium hover:no-underline">
                        Klik untuk kirim ulang email verifikasi.
                    </button>
                </p>
            </div>

            @if (session('status') === 'verification-link-sent')
                <p class="mt-2 text-sm font-medium text-brand-dark">
                    Link verifikasi baru telah dikirim ke alamat email kamu.
                </p>
            @endif
        @endif
    </div>

    <div class="flex items-center gap-3 pt-3 border-t border-gray-100">
        <button type="submit" class="btn-primary px-5 py-2.5 text-sm font-semibold text-white rounded-xl">Simpan</button>

        @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                class="text-sm font-medium text-brand-dark">Tersimpan.</p>
        @endif
    </div>
</form>