<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/stockify-icon-256.png') }}">
    <title>{{ config('app.name', 'Stockify') }} — Masuk</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-body antialiased bg-canvas">

    <div class="min-h-screen flex">

        <!-- Panel Kiri: Branding -->
        <div id="brand-panel" class="hidden lg:flex lg:w-[46%] relative overflow-hidden bg-ink">
            <div class="absolute inset-0 opacity-[0.06]" style="background-image: linear-gradient(#fff 1px, transparent 1px), linear-gradient(90deg, #fff 1px, transparent 1px); background-size: 32px 32px;"></div>

            <div id="parallax-layer" class="absolute inset-0">
                <div class="orb-a absolute -top-24 -right-24 w-96 h-96 rounded-full bg-brand/25 blur-3xl"></div>
                <div class="orb-b absolute -bottom-32 -left-16 w-96 h-96 rounded-full bg-freight/20 blur-3xl"></div>

                <svg class="crate-float absolute top-[18%] right-[15%] w-14 h-14 text-brand/40" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" d="M3 8l9-5 9 5-9 5-9-5zm0 0v8l9 5 9-5V8M12 13v8"/>
                </svg>
                <svg class="crate-float-delay absolute top-[55%] right-[8%] w-10 h-10 text-white/20" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" d="M3 8l9-5 9 5-9 5-9-5zm0 0v8l9 5 9-5V8M12 13v8"/>
                </svg>
                <svg class="crate-float-delay-2 absolute top-[35%] right-[32%] w-8 h-8 text-freight/40" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" d="M3 8l9-5 9 5-9 5-9-5zm0 0v8l9 5 9-5V8M12 13v8"/>
                </svg>
            </div>

            <div class="relative z-10 flex flex-col justify-between p-12 w-full">
                <div class="flex items-center justify-between animate-fade-up">
                    <div class="relative">
                        <span class="absolute inset-0 rounded-2xl bg-brand/30 blur-xl scale-110"></span>
                        <img src="{{ asset('images/stockify-icon-256.png') }}" alt="Stockify" class="relative w-20 h-20 object-contain">
                    </div>
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/5 border border-white/10">
                        <span class="status-dot w-1.5 h-1.5 rounded-full bg-brand"></span>
                        <span class="font-mono-data text-[10px] text-gray-300 tracking-wider">SISTEM ONLINE</span>
                    </span>
                </div>

                <div class="animate-fade-up" style="animation-delay: 100ms">
                    <p class="font-mono-data text-[11px] tracking-widest text-brand uppercase mb-4">Warehouse Management System</p>
                    <h1 class="font-display text-4xl font-bold text-white leading-tight mb-4 min-h-[8rem]">
                        <span id="typewriter-text"></span><span class="typewriter-cursor text-brand">|</span>
                    </h1>
                    <p class="text-gray-400 text-sm leading-relaxed max-w-sm">
                        Satu sistem untuk mengelola produk, transaksi, dan laporan gudang secara real-time.
                    </p>
                </div>

                <div class="grid grid-cols-3 gap-4 animate-fade-up" style="animation-delay: 200ms">
                    <div class="p-4 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/[0.08] hover:-translate-y-1 transition-all duration-200 cursor-default">
                        <p class="font-display text-2xl font-bold text-brand"><span class="stat-count" data-target="24">0</span>/7</p>
                        <p class="text-[11px] text-gray-400 uppercase tracking-wide mt-1">Real-time Sync</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/[0.08] hover:-translate-y-1 transition-all duration-200 cursor-default">
                        <p class="font-display text-2xl font-bold text-white"><span class="stat-count" data-target="3">0</span></p>
                        <p class="text-[11px] text-gray-400 uppercase tracking-wide mt-1">Level Akses</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/[0.08] hover:-translate-y-1 transition-all duration-200 cursor-default">
                        <p class="font-display text-2xl font-bold text-white"><span class="stat-count" data-target="100">0</span>%</p>
                        <p class="text-[11px] text-gray-400 uppercase tracking-wide mt-1">Akurat</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel Kanan: Form -->
        <div class="flex-1 flex items-center justify-center p-6 sm:p-10 relative overflow-hidden">
            <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[28rem] h-[28rem] rounded-full bg-brand/[0.04] blur-3xl pointer-events-none"></div>
            <div class="relative w-full max-w-sm animate-fade-up">
                {{ $slot }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Typewriter rotating tagline
            var taglines = [
                "Kendalikan setiap pergerakan stok gudang Anda.",
                "Cetak. Catat. Kendalikan Stok.",
                "Data stok akurat, kapan saja dibutuhkan.",
                "Satu sistem, seluruh alur gudang Anda."
            ];
            var typewriterEl = document.getElementById('typewriter-text');
            var taglineIndex = 0, charIndex = 0, isDeleting = false;

            function typeLoop() {
                var current = taglines[taglineIndex];
                if (!isDeleting) {
                    typewriterEl.textContent = current.slice(0, charIndex + 1);
                    charIndex++;
                    if (charIndex === current.length) {
                        isDeleting = true;
                        setTimeout(typeLoop, 1800);
                        return;
                    }
                } else {
                    typewriterEl.textContent = current.slice(0, charIndex - 1);
                    charIndex--;
                    if (charIndex === 0) {
                        isDeleting = false;
                        taglineIndex = (taglineIndex + 1) % taglines.length;
                    }
                }
                setTimeout(typeLoop, isDeleting ? 25 : 45);
            }
            if (typewriterEl) typeLoop();

            // Count-up stats
            document.querySelectorAll('.stat-count').forEach(function (el) {
                var target = parseInt(el.dataset.target, 10);
                var current = 0;
                var step = Math.max(1, Math.ceil(target / 40));
                var timer = setInterval(function () {
                    current += step;
                    if (current >= target) { current = target; clearInterval(timer); }
                    el.textContent = current;
                }, 30);
            });

            // Parallax mengikuti kursor
            var brandPanel = document.getElementById('brand-panel');
            var parallaxLayer = document.getElementById('parallax-layer');
            if (brandPanel && parallaxLayer) {
                brandPanel.addEventListener('mousemove', function (e) {
                    var rect = brandPanel.getBoundingClientRect();
                    var x = (e.clientX - rect.left) / rect.width - 0.5;
                    var y = (e.clientY - rect.top) / rect.height - 0.5;
                    parallaxLayer.style.transform = 'translate(' + (x * 16) + 'px,' + (y * 16) + 'px)';
                });
                brandPanel.addEventListener('mouseleave', function () {
                    parallaxLayer.style.transform = 'translate(0,0)';
                });
            }
        });
    </script>
</body>
</html>