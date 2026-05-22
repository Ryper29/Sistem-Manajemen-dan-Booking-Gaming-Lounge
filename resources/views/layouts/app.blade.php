<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gaming Hub Console</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-zinc-950 text-white font-sans antialiased flex h-screen overflow-hidden">

    <!-- SIDEBAR (Sekarang punya ID dan Animasi) -->
    <!-- transition-all duration-300 membuat gerakannya mulus (tidak patah) -->
    <aside id="sidebar" class="w-0 bg-zinc-900 border-zinc-800 flex flex-col transition-all duration-300 overflow-hidden shrink-0">
        <!-- Inner Wrapper (Lebar fix 64) agar teks tidak hancur tergencet saat sidebar menyusut -->
        <div class="w-64 h-full flex flex-col justify-between">
            <div class="p-6">
                <h1 class="text-2xl font-black text-white tracking-widest uppercase mb-1">ADMIN<span class="text-emerald-500">_</span>HUB</h1>
                <p class="text-zinc-500 text-[10px] font-mono uppercase tracking-widest mb-10">Console Panel</p>

                <nav class="space-y-2">
                    <a href="{{ route('hubs.index') }}" class="block px-4 py-3 rounded-lg hover:bg-zinc-800 text-zinc-400 hover:text-emerald-400 font-bold transition-colors">
                        🎮 Dashboard
                    </a>
                    <a href="{{ route('transactions.booking') }}" class="block px-4 py-3 rounded-lg hover:bg-zinc-800 text-zinc-400 hover:text-emerald-400 font-bold transition-colors">
                        🗓️ Daftar Reservasi
                    </a>
                    <a href="{{ route('reports.index') }}" class="block px-4 py-3 rounded-lg hover:bg-zinc-800 text-zinc-400 hover:text-emerald-400 font-bold transition-colors">
                        📈 Laporan Keuangan
                    </a>
                </nav>
            </div>

            <!-- Tombol Logout -->
            <div class="p-6 border-t border-zinc-800">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-rose-900/20 hover:bg-rose-600 text-rose-400 hover:text-white px-4 py-3 rounded-md font-semibold transition-colors border border-rose-800/50 text-sm">
                        LOGOUT SYSTEM
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- AREA KONTEN UTAMA -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden relative">
        
        <!-- TOPBAR BARU (Tempat tombol Buka/Tutup) -->
        <header class="bg-zinc-950/80 backdrop-blur-sm px-8 py-5 flex items-center border-b border-zinc-900 z-10 @yield('header_class')">
            <button id="toggleBtn" class="text-zinc-500 hover:text-emerald-500 hover:border-emerald-500 transition-colors mr-4 focus:outline-none bg-zinc-900 p-2 rounded-lg border border-zinc-800 group">
                <!-- Icon Hamburger -->
                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </header>

        <!-- Area Konten yang Bisa di-Scroll -->
        <div class="flex-1 overflow-y-auto p-10">
            @yield('content')
        </div>
        
    </main>

    <!-- SCRIPT LOGIKA BUKA-TUTUP SIDEBAR -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('toggleBtn');

            toggleBtn.addEventListener('click', () => {
                // Kita mematikan/menyalakan kelas w-64 (lebar 256px) dan w-0 (lebar 0px)
                // secara bersamaan dengan border-r agar garis pemisahnya juga ikut hilang
                sidebar.classList.toggle('w-64');
                sidebar.classList.toggle('w-0');
                sidebar.classList.toggle('border-r');
            });
        });
    </script>
</body>
</html>