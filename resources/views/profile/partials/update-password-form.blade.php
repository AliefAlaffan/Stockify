<div class="flex items-center gap-2 mb-5 pb-5 border-b border-gray-100">
    <div class="icon-badge w-9 h-9 !rounded-lg bg-freight/10">
        <svg class="w-4 h-4 text-freight" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
    </div>
    <div>
        <h2 class="font-display font-semibold text-ink text-sm">Ubah Password</h2>
        <p class="text-xs text-steel mt-0.5">Gunakan password yang panjang dan acak agar akun tetap aman.</p>
    </div>
</div>

<form method="post" action="{{ route('password.update') }}" class="space-y-4">
    @csrf
    @method('put')

    <div>
        <label for="update_password_current_password" class="block mb-1.5 text-sm font-medium text-ink">Password Saat Ini</label>
        <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
            class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
        @error('current_password', 'updatePassword') <p class="mt-1.5 text-sm text-rust">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="update_password_password" class="block mb-1.5 text-sm font-medium text-ink">Password Baru</label>
        <input id="update_password_password" name="password" type="password" autocomplete="new-password"
            class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
        @error('password', 'updatePassword') <p class="mt-1.5 text-sm text-rust">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="update_password_password_confirmation" class="block mb-1.5 text-sm font-medium text-ink">Konfirmasi Password</label>
        <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
            class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
        @error('password_confirmation', 'updatePassword') <p class="mt-1.5 text-sm text-rust">{{ $message }}</p> @enderror
    </div>

    <div class="flex items-center gap-3 pt-3 border-t border-gray-100">
        <button type="submit" class="btn-primary px-5 py-2.5 text-sm font-semibold text-white rounded-xl">Simpan</button>

        @if (session('status') === 'password-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                class="text-sm font-medium text-brand-dark">Tersimpan.</p>
        @endif
    </div>
</form>