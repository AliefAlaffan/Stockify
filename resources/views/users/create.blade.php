<x-app-layout>
    <x-slot name="header">Tambah Pengguna</x-slot>

    <div class="flex items-center gap-3 mb-5">
        <a href="{{ route('users.index') }}" class="icon-btn text-steel hover:bg-canvas-alt !rounded-lg">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" d="M12.5 15l-5-5 5-5"/></svg>
        </a>
        <div>
            <p class="font-mono-data text-[11px] tracking-widest text-steel uppercase mb-0.5">Administrasi / Pengguna</p>
            <h1 class="font-display text-xl font-semibold text-ink">Tambah Pengguna Baru</h1>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 max-w-lg">
        <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block mb-1.5 text-sm font-medium text-ink">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
                @error('name') <p class="mt-1.5 text-sm text-rust">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block mb-1.5 text-sm font-medium text-ink">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
                @error('email') <p class="mt-1.5 text-sm text-rust">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block mb-1.5 text-sm font-medium text-ink">Role</label>
                <select name="role" class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
                    <option value="">— Pilih Role —</option>
                    <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="Manajer Gudang" {{ old('role') == 'Manajer Gudang' ? 'selected' : '' }}>Manajer Gudang</option>
                    <option value="Staff Gudang" {{ old('role') == 'Staff Gudang' ? 'selected' : '' }}>Staff Gudang</option>
                </select>
                @error('role') <p class="mt-1.5 text-sm text-rust">{{ $message }}</p> @enderror
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1.5 text-sm font-medium text-ink">Password</label>
                    <input type="password" name="password"
                        class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
                    @error('password') <p class="mt-1.5 text-sm text-rust">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block mb-1.5 text-sm font-medium text-ink">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation"
                        class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
                </div>
            </div>
            <div class="flex justify-end gap-2 pt-3 border-t border-gray-100">
                <a href="{{ route('users.index') }}" class="px-4 py-2.5 text-sm font-medium text-ink-soft bg-canvas-alt rounded-xl hover:bg-gray-200 transition-colors">Batal</a>
                <button type="submit" class="btn-primary px-5 py-2.5 text-sm font-semibold text-white rounded-xl">Simpan Pengguna</button>
            </div>
        </form>
    </div>
</x-app-layout>