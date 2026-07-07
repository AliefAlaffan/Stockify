<div class="flex items-center gap-2 mb-5 pb-5 border-b border-rust/10">
    <div class="icon-badge w-9 h-9 !rounded-lg bg-rust/10">
        <svg class="w-4 h-4 text-rust" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M4 6h12M8 6V4.5A1.5 1.5 0 019.5 3h1A1.5 1.5 0 0112 4.5V6m2 0v9.5A1.5 1.5 0 0112.5 17h-5A1.5 1.5 0 016 15.5V6h8z"/></svg>
    </div>
    <div>
        <h2 class="font-display font-semibold text-ink text-sm">Hapus Akun</h2>
        <p class="text-xs text-steel mt-0.5">Setelah dihapus, semua data akun ini akan hilang permanen.</p>
    </div>
</div>

<button type="button"
    data-modal-target="modal-delete-account" data-modal-toggle="modal-delete-account"
    class="px-4 py-2.5 text-sm font-semibold text-rust bg-rust/8 rounded-xl hover:bg-rust/15 transition-colors">
    Hapus Akun Saya
</button>

<div id="modal-delete-account" tabindex="-1" aria-hidden="true" class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center bg-ink/30 modal-backdrop">
    <div class="modal-panel relative w-full max-w-md">
        <div class="relative bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="p-6 pt-7 text-center">
                <div class="relative w-14 h-14 mx-auto mb-4">
                    <span class="absolute inset-0 rounded-full bg-rust/15 animate-ping-slow"></span>
                    <div class="relative w-14 h-14 rounded-full bg-rust/10 flex items-center justify-center">
                        <svg class="w-6 h-6 text-rust" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" d="M4 6h12M8 6V4.5A1.5 1.5 0 019.5 3h1A1.5 1.5 0 0112 4.5V6m2 0v9.5A1.5 1.5 0 0112.5 17h-5A1.5 1.5 0 016 15.5V6h8z"/></svg>
                    </div>
                </div>
                <p class="font-display font-semibold text-ink mb-1">Hapus akunmu secara permanen?</p>
                <p class="text-sm text-steel mb-5">Tindakan ini tidak bisa dibatalkan. Masukkan password untuk konfirmasi.</p>

                <form method="post" action="{{ route('profile.destroy') }}" class="text-left">
                    @csrf
                    @method('delete')

                    <label for="password" class="block mb-1.5 text-sm font-medium text-ink">Password</label>
                    <input id="password" name="password" type="password" placeholder="Password"
                        class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-rust/30 focus:border-rust block w-full p-2.5 transition-colors mb-1.5">
                    @error('password', 'userDeletion') <p class="mb-3 text-sm text-rust">{{ $message }}</p> @enderror

                    <div class="flex gap-2 mt-4">
                        <button type="button" data-modal-hide="modal-delete-account"
                            class="flex-1 px-4 py-2.5 text-sm font-medium text-ink-soft bg-canvas-alt rounded-xl hover:bg-gray-200 transition-colors">Batal</button>
                        <button type="submit"
                            class="flex-1 px-4 py-2.5 text-sm font-semibold text-white bg-rust rounded-xl hover:bg-rust/90 transition-colors shadow-sm shadow-rust/30">Ya, Hapus Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>