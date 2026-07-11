<x-guest-layout>
    <div class="w-full max-w-md mx-auto">
        <div class="text-center mb-6">
            <div class="icon-badge bg-brand/10 mx-auto mb-4 !w-14 !h-14">
                <svg class="w-6 h-6 text-brand-dark" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <h1 class="font-display text-xl font-semibold text-ink">Atur Ulang Password</h1>
            <p class="text-sm text-steel mt-1.5">Buat password baru untuk akunmu.</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div>
                    <label for="email" class="block mb-1.5 text-sm font-medium text-ink">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus
                        class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
                    @error('email') <p class="mt-1.5 text-sm text-rust">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="block mb-1.5 text-sm font-medium text-ink">Password Baru</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
                    @error('password') <p class="mt-1.5 text-sm text-rust">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block mb-1.5 text-sm font-medium text-ink">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
                    @error('password_confirmation') <p class="mt-1.5 text-sm text-rust">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="btn-primary w-full px-4 py-2.5 text-sm font-semibold text-white rounded-xl">
                    Simpan Password Baru
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>