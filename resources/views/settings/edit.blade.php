@php use Illuminate\Support\Facades\Storage; @endphp
<x-app-layout>
    <x-slot name="header">Pengaturan</x-slot>

    <div class="mb-6">
        <p class="font-mono-data text-[11px] tracking-widest text-steel uppercase mb-1">Sistem</p>
        <h1 class="font-display text-xl font-semibold text-ink">Pengaturan Aplikasi</h1>
        <p class="text-sm text-steel mt-1">Kelola identitas aplikasi seperti nama dan logo.</p>
    </div>

    @if (session('success'))
        <div class="flex items-center gap-2.5 p-4 mb-5 text-sm text-brand-dark rounded-2xl bg-brand/8 border border-brand/15 animate-fade-up max-w-2xl" role="alert">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 max-w-2xl">
        <div class="flex items-center gap-2 mb-5 pb-5 border-b border-gray-100">
            <div class="icon-badge w-9 h-9 !rounded-lg bg-brand/10">
                <svg class="w-4 h-4 text-brand-dark" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"/></svg>
            </div>
            <div>
                <h2 class="font-display font-semibold text-ink text-sm">Identitas Aplikasi</h2>
                <p class="text-xs text-steel mt-0.5">Nama dan logo ini tampil di navbar seluruh halaman.</p>
            </div>
        </div>

        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-1.5 text-sm font-medium text-ink">Nama Aplikasi</label>
                <input type="text" name="app_name" value="{{ old('app_name', $settings['app_name']) }}"
                    class="bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:ring-2 focus:ring-brand/30 focus:border-brand block w-full p-2.5 transition-colors">
                @error('app_name') <p class="mt-1.5 text-sm text-rust">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1.5 text-sm font-medium text-ink">Logo Aplikasi</label>
                <label id="drop-zone" class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-gray-200 rounded-2xl cursor-pointer bg-canvas-alt/40 hover:bg-canvas-alt/70 hover:border-brand/40 transition-colors overflow-hidden">
                    <div id="drop-zone-content" class="flex flex-col items-center justify-center pt-5 pb-6 pointer-events-none">
                        @if ($settings['app_logo'])
                            <img src="{{ Storage::url($settings['app_logo']) }}" class="h-14 object-contain mb-2">
                            <p class="text-sm text-ink-soft"><span class="font-medium">Klik untuk ganti</span> logo</p>
                        @else
                            <svg class="w-8 h-8 mb-2 text-steel-light" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="text-sm text-steel"><span class="font-medium text-ink-soft">Klik untuk upload</span> logo aplikasi</p>
                        @endif
                        <p class="text-xs text-steel-light mt-0.5">PNG dengan latar transparan, maks. 1MB</p>
                    </div>
                    <input id="logo-input" type="file" name="app_logo" accept="image/*" class="hidden" />
                </label>
                @error('app_logo') <p class="mt-1.5 text-sm text-rust">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-2 pt-3 border-t border-gray-100">
                <button type="submit" class="btn-primary px-5 py-2.5 text-sm font-semibold text-white rounded-xl">Simpan Pengaturan</button>
            </div>
        </form>
    </div>

    <script>
        const logoInput = document.getElementById('logo-input');
        const dropZoneContent = document.getElementById('drop-zone-content');
        logoInput.addEventListener('change', () => {
            if (logoInput.files.length > 0) {
                const file = logoInput.files[0];
                const reader = new FileReader();
                reader.onload = (e) => {
                    dropZoneContent.innerHTML = `
                        <img src="${e.target.result}" class="h-14 object-contain mb-2">
                        <p class="text-sm font-medium text-ink-soft">${file.name}</p>
                        <p class="text-xs text-brand-dark mt-0.5">Klik untuk ganti logo</p>
                    `;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>