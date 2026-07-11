<x-guest-layout>
    <div class="w-full max-w-md mx-auto">
        <div class="text-center mb-6">
            <div class="icon-badge bg-brand/10 mx-auto mb-4 !w-14 !h-14">
                <svg class="w-6 h-6 text-brand-dark" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <h1 class="font-display text-xl font-semibold text-ink">Lupa Password?</h1>
            <p class="text-sm text-steel mt-1.5 max-w-xs mx-auto">Masukkan email akunmu, kami akan kirim link untuk atur ulang password.</p>
        </div>

        @if (session('status'))
            <div class="flex items-center gap-2.5 p-4 mb-5 text-sm text-brand-dark rounded-2xl bg-brand/8 border border-brand/15" role="alert">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/></svg>
                <span class="font-medium">{{ session('status') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block mb-1.5 text-sm font-medium text-ink">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        placeholder="nama@perusahaan.com"
                        class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
                    @error('email') <p class="mt-1.5 text-sm text-rust">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="btn-primary w-full px-4 py-2.5 text-sm font-semibold text-white rounded-xl">
                    Kirim Link Reset Password
                </button>
            </form>

            <div class="mt-5 pt-5 border-t border-gray-100 text-center">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-ink-soft hover:text-brand-dark transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" d="M12.5 15l-5-5 5-5"/></svg>
                    Kembali ke Login
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>