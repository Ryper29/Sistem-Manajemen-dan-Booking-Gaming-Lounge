<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RYPER_HUB | Premium Gaming Lounge</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-950 text-white font-sans antialiased selection:bg-emerald-500 selection:text-white">

    <nav class="fixed w-full z-50 border-b border-zinc-800/50 bg-zinc-950/80 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="text-2xl font-black tracking-widest uppercase">RYPER<span class="text-emerald-500">_</span>HUB</div>
            <div class="flex items-center gap-4 md:gap-6">
                <a href="#rooms" class="hidden md:block text-sm font-bold text-zinc-400 hover:text-emerald-400 transition-colors">RUANGAN</a>
                <a href="{{ route('login') }}" class="text-sm font-bold text-white hover:text-emerald-400 transition-colors">LOGIN</a>
                <a href="{{ route('login') }}" class="text-sm font-bold bg-emerald-600 hover:bg-emerald-500 px-5 py-2.5 rounded-full transition-all shadow-[0_0_15px_rgba(16,185,129,0.2)]">BOOKING</a>
            </div>
        </div>
    </nav>

    <header class="relative pt-40 pb-24 lg:pt-56 lg:pb-40 overflow-hidden">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-emerald-500/10 rounded-full blur-[120px] pointer-events-none"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <div class="inline-block px-3 py-1 mb-6 border border-zinc-800 bg-zinc-900/50 text-emerald-500 text-[10px] font-bold uppercase tracking-widest rounded-full">
                Sistem Booking Online Telah Dibuka
            </div>
            <h1 class="text-5xl lg:text-7xl font-black uppercase tracking-tight mb-8 leading-tight">
                Elevate Your <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-600">Gaming Experience</span>
            </h1>
            <p class="text-zinc-400 text-lg lg:text-xl max-w-2xl mx-auto mb-12 leading-relaxed">
                Premium gaming lounge di Bandar Lampung. Rasakan performa rata kanan dan kenyamanan tanpa batas. Booking tempatmu sebelum kehabisan.
            </p>
            <a href="#rooms" class="inline-block bg-emerald-500 hover:bg-emerald-400 text-white font-black py-4 px-10 rounded-full transition-all hover:scale-105 uppercase tracking-wide shadow-[0_0_30px_rgba(16,185,129,0.35)]">
                Lihat Ruangan
            </a>
        </div>
    </header>

    <section class="py-16 border-y border-zinc-900 bg-zinc-900/20">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-xs font-bold text-zinc-500 uppercase tracking-widest mb-10">Popular Titles Available & Updated</p>
            <div class="flex flex-wrap justify-center gap-x-16 gap-y-8">
                <h3 class="text-2xl font-black tracking-widest text-zinc-600 hover:text-emerald-400 transition-colors duration-300 cursor-default">GTA V</h3>
                <h3 class="text-2xl font-black tracking-widest text-zinc-600 hover:text-emerald-400 transition-colors duration-300 cursor-default">MINECRAFT</h3>
                <h3 class="text-2xl font-black tracking-widest text-zinc-600 hover:text-emerald-400 transition-colors duration-300 cursor-default">ROBLOX</h3>
            </div>
        </div>
    </section>

    <section id="rooms" class="py-32">
        <div class="max-w-7xl mx-auto px-6">
            <div class="mb-16 md:flex justify-between items-end">
                <div>
                    <h2 class="text-4xl font-black uppercase tracking-wide mb-2">Katalog Ruangan</h2>
                    <p class="text-zinc-500">Pilih tier ruangan sesuai kebutuhan mabar-mu.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-8 hover:border-emerald-500/50 transition-colors group">
                    <div class="text-emerald-500 text-sm font-bold tracking-widest uppercase mb-4">Standard Tier</div>
                    <h3 class="text-3xl font-black mb-2">HUB<span class="text-zinc-500">_</span>STD</h3>
                    <p class="text-zinc-500 text-sm mb-6 pb-6 border-b border-zinc-800">Ruangan nyaman untuk solo player atau duo. Performa stabil untuk game kompetitif.</p>
                    <div class="mb-8">
                        <span class="text-4xl font-black">Rp 15k</span><span class="text-zinc-500">/jam</span>
                    </div>
                    <ul class="space-y-3 text-sm text-zinc-400 mb-8 font-mono">
                        <li class="flex items-center gap-2">✓ PC RTX 3060 / PS5</li>
                        <li class="flex items-center gap-2">✓ Monitor 144Hz</li>
                        <li class="flex items-center gap-2">✓ Sofa Standar</li>
                    </ul>
                    <a href="{{ route('login') }}" class="block w-full text-center bg-zinc-800 group-hover:bg-emerald-600 text-white font-bold py-3 rounded-lg transition-all hover:scale-[1.02]">
                        Login untuk Booking
                    </a>
                </div>

                <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-8 hover:border-emerald-500/50 transition-colors group relative overflow-hidden">
                    <div class="absolute top-0 right-0 bg-emerald-500 text-white text-[10px] font-black tracking-widest py-1 px-4 rounded-bl-lg uppercase">Best Value</div>
                    <div class="text-emerald-500 text-sm font-bold tracking-widest uppercase mb-4">VIP Tier</div>
                    <h3 class="text-3xl font-black mb-2">HUB<span class="text-zinc-500">_</span>VIP</h3>
                    <p class="text-zinc-500 text-sm mb-6 pb-6 border-b border-zinc-800">Privasi ekstra untuk squad 5 orang. Kedap suara dan setup yang lebih lega.</p>
                    <div class="mb-8">
                        <span class="text-4xl font-black">Rp 25k</span><span class="text-zinc-500">/jam</span>
                    </div>
                    <ul class="space-y-3 text-sm text-zinc-400 mb-8 font-mono">
                        <li class="flex items-center gap-2">✓ PC RTX 4060 / PS5</li>
                        <li class="flex items-center gap-2">✓ Monitor 240Hz</li>
                        <li class="flex items-center gap-2">✓ AC & Air Purifier Dedicated</li>
                    </ul>
                    <a href="{{ route('login') }}" class="block w-full text-center bg-zinc-800 group-hover:bg-emerald-600 text-white font-bold py-3 rounded-lg transition-all hover:scale-[1.02]">
                        Login untuk Booking
                    </a>
                </div>

                <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-8 hover:border-emerald-500/50 transition-colors group">
                    <div class="text-emerald-500 text-sm font-bold tracking-widest uppercase mb-4">VVIP Tier</div>
                    <h3 class="text-3xl font-black mb-2">HUB<span class="text-zinc-500">_</span>VVIP</h3>
                    <p class="text-zinc-500 text-sm mb-6 pb-6 border-b border-zinc-800">Pengalaman maksimal. Home theater setup, VR Gear, dan snack bar gratis.</p>
                    <div class="mb-8">
                        <span class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-600">Rp 40k</span><span class="text-zinc-500">/jam</span>
                    </div>
                    <ul class="space-y-3 text-sm text-zinc-400 mb-8 font-mono">
                        <li class="flex items-center gap-2">✓ Konsol Lengkap + VR Gear</li>
                        <li class="flex items-center gap-2">✓ TV OLED 65" + Surround Sound</li>
                        <li class="flex items-center gap-2">✓ Recliner Sofa Premium</li>
                    </ul>
                    <a href="{{ route('login') }}" class="block w-full text-center bg-zinc-800 group-hover:bg-emerald-600 text-white font-bold py-3 rounded-lg transition-all hover:scale-[1.02]">
                        Login untuk Booking
                    </a>
                </div>
            </div>
        </div>
    </section>

    <footer class="border-t border-zinc-900 py-12 text-center text-zinc-600 text-sm">
        <p>&copy; 2026 RYPER_HUB Console. All rights reserved.</p>
    </footer>

</body>
</html>