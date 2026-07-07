<x-guest-layout>
    <div class="lg:hidden flex justify-center mb-8">
        <img src="{{ asset('images/stockify-logo-full.png') }}" alt="Stockify" class="h-11 w-auto object-contain">
    </div>

    <div class="mb-8">
        <h2 class="font-display text-2xl font-bold text-ink">Selamat datang kembali</h2>
        <p class="text-sm text-steel mt-1.5">Masuk untuk mengelola stok gudang kamu.</p>
    </div>

    @if (session('status'))
        <div class="flex items-center gap-2.5 p-3.5 mb-5 text-sm text-brand-dark rounded-xl bg-brand/8 border border-brand/15 animate-fade-up">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/></svg>
            <span class="font-medium">{{ session('status') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="flex items-start gap-2.5 p-3.5 mb-5 text-sm text-rust rounded-xl bg-rust/8 border border-rust/15 animate-shake">
            <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.7" stroke-linecap="round" d="M10 6v4m0 4h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="font-medium">{{ $errors->first() }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5" id="login-form">
        @csrf

        <!-- Email dengan floating label -->
        <div class="input-wrap relative rounded-xl transition-shadow">
            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-steel-light z-10 transition-colors" id="email-icon">
                <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.6" d="M2.5 5.5h15v9a1 1 0 01-1 1h-13a1 1 0 01-1-1v-9z"/><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M2.5 5.5l7.5 6 7.5-6"/></svg>
            </span>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder=" "
                class="peer bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:border-brand block w-full pt-5 pb-2 pl-11 pr-3 transition-colors outline-none">
            <label for="email"
                class="absolute left-11 top-1/2 -translate-y-1/2 text-steel-light text-sm transition-all duration-200 pointer-events-none
                peer-focus:top-3 peer-focus:text-[11px] peer-focus:text-brand-dark peer-focus:font-medium
                peer-[:not(:placeholder-shown)]:top-3 peer-[:not(:placeholder-shown)]:text-[11px] peer-[:not(:placeholder-shown)]:text-ink-soft">
                Alamat Email
            </label>
        </div>
        @error('email') <p class="text-xs text-rust -mt-3">{{ $message }}</p> @enderror

        <!-- Password dengan floating label -->
        <div>
            <div class="input-wrap relative rounded-xl transition-shadow">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-steel-light z-10">
                    <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.6" d="M5 9V6.5a5 5 0 0110 0V9M4.5 9h11a1 1 0 011 1v6a1 1 0 01-1 1h-11a1 1 0 01-1-1v-6a1 1 0 011-1z"/></svg>
                </span>
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder=" "
                    class="peer bg-canvas-alt/60 border border-gray-200 text-ink text-sm rounded-xl focus:border-brand block w-full pt-5 pb-2 pl-11 pr-11 transition-colors outline-none">
                <label for="password"
                    class="absolute left-11 top-1/2 -translate-y-1/2 text-steel-light text-sm transition-all duration-200 pointer-events-none
                    peer-focus:top-3 peer-focus:text-[11px] peer-focus:text-brand-dark peer-focus:font-medium
                    peer-[:not(:placeholder-shown)]:top-3 peer-[:not(:placeholder-shown)]:text-[11px] peer-[:not(:placeholder-shown)]:text-ink-soft">
                    Password
                </label>
                <button type="button" id="toggle-password" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-steel-light hover:text-steel transition-colors z-10">
                    <svg id="eye-open" class="w-[18px] h-[18px]" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.6" d="M1.5 10S4.5 4 10 4s8.5 6 8.5 6-3 6-8.5 6-8.5-6-8.5-6z"/><circle cx="10" cy="10" r="2.2" stroke="currentColor" stroke-width="1.6"/></svg>
                    <svg id="eye-closed" class="w-[18px] h-[18px] hidden" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.6" stroke-linecap="round" d="M3 3l14 14M8.2 8.3a2.2 2.2 0 003 3M6.3 6.4C4 7.7 2.5 10 2.5 10s3 6 7.5 6c1.3 0 2.5-.3 3.5-.8M9 4.1c.3 0 .6-.1 1-.1 5.5 0 8.5 6 8.5 6s-.6 1.2-1.7 2.4"/></svg>
                </button>
            </div>
            <div class="flex justify-end mt-1.5">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs font-medium text-brand-dark hover:underline">Lupa password?</a>
                @endif
            </div>
        </div>
        @error('password') <p class="text-xs text-rust -mt-3">{{ $message }}</p> @enderror

        <!-- Custom Checkbox -->
        <label class="flex items-center gap-2.5 cursor-pointer select-none">
            <span class="relative flex-shrink-0 w-[18px] h-[18px]">
                <input id="remember_me" type="checkbox" name="remember"
                    class="peer appearance-none w-[18px] h-[18px] rounded-md border-2 border-gray-300 checked:bg-brand checked:border-brand transition-colors cursor-pointer">
                <svg class="absolute inset-0 w-[18px] h-[18px] p-[3px] text-white opacity-0 peer-checked:opacity-100 scale-50 peer-checked:scale-100 transition-all duration-150 pointer-events-none" fill="none" viewBox="0 0 12 12">
                    <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M2 6l2.5 2.5L10 3"/>
                </svg>
            </span>
            <span class="text-sm text-ink-soft">Ingat saya di perangkat ini</span>
        </label>

        <button type="submit" id="login-btn" class="btn-primary btn-shine w-full flex items-center justify-center gap-2 px-4 py-3 text-sm font-semibold text-white rounded-xl mt-2">
            <svg id="login-spinner" class="hidden animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
            <span id="login-btn-text">Masuk</span>
            <svg id="login-btn-arrow" class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" d="M4 10h12m0 0l-4-4m4 4l-4 4"/></svg>
        </button>
    </form>

    <p class="text-center text-xs text-steel-light mt-8">
        &copy; {{ date('Y') }} Stockify — Cetak. Catat. Kendalikan Stok.
    </p>

    <script>
        const togglePassword = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password');
        const eyeOpen = document.getElementById('eye-open');
        const eyeClosed = document.getElementById('eye-closed');

        togglePassword.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            eyeOpen.classList.toggle('hidden', isPassword);
            eyeClosed.classList.toggle('hidden', !isPassword);
        });

        document.getElementById('login-form').addEventListener('submit', () => {
            document.getElementById('login-spinner').classList.remove('hidden');
            document.getElementById('login-btn-arrow').classList.add('hidden');
            document.getElementById('login-btn-text').textContent = 'Memproses...';
            document.getElementById('login-btn').disabled = true;
        });
    </script>
</x-guest-layout>