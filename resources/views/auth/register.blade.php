<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - RYPER_HUB</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-zinc-950 text-zinc-300 min-h-screen flex items-center justify-center p-6 font-sans relative overflow-hidden">

    <div class="absolute top-1/4 left-1/3 w-80 h-80 bg-emerald-500/10 blur-[120px] rounded-full z-0 pointer-events-none"></div>
    <div class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-teal-500/5 blur-[100px] rounded-full z-0 pointer-events-none"></div>

    <div class="bg-zinc-900/80 backdrop-blur border border-zinc-800 rounded-2xl p-8 w-full max-w-sm shadow-2xl relative z-10">
        <div class="text-center mb-8">
            <a href="/" class="text-3xl font-black text-white tracking-widest uppercase mb-1 block">RYPER<span class="text-emerald-500">_</span>HUB</a>
            <p class="text-zinc-500 text-xs font-mono uppercase tracking-widest">Buat Akun Baru</p>
        </div>

        {{-- Tampilkan error validasi --}}
        @if ($errors->any())
            <div class="bg-rose-500/10 border border-rose-500/50 text-rose-400 p-3 rounded-md text-xs font-bold mb-6">
                <ul class="space-y-1 text-center">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-2">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                    placeholder="Nama kamu"
                    class="w-full bg-zinc-950 border border-zinc-800 rounded-md px-4 py-3 text-white placeholder-zinc-700 font-mono focus:outline-none focus:border-emerald-500 transition-colors">
            </div>

            <div>
                <label for="reg-email" class="block text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-2">Email</label>
                <input type="email" name="email" id="reg-email" value="{{ old('email') }}" required
                    placeholder="email@kamu.com"
                    class="w-full bg-zinc-950 border border-zinc-800 rounded-md px-4 py-3 text-emerald-400 placeholder-zinc-700 font-mono focus:outline-none focus:border-emerald-500 transition-colors">
            </div>

            <div>
                <label for="reg-password" class="block text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-2">Password <span class="text-zinc-600 normal-case">(min. 8 karakter)</span></label>
                <input type="password" name="password" id="reg-password" required
                    class="w-full bg-zinc-950 border border-zinc-800 rounded-md px-4 py-3 text-emerald-400 font-mono tracking-widest focus:outline-none focus:border-emerald-500 transition-colors">
            </div>

            <div>
                <label for="password_confirmation" class="block text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="w-full bg-zinc-950 border border-zinc-800 rounded-md px-4 py-3 text-emerald-400 font-mono tracking-widest focus:outline-none focus:border-emerald-500 transition-colors">
            </div>

            <button type="submit" id="register-btn" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white py-3 rounded-md font-bold text-xs tracking-widest transition-all shadow-[0_0_15px_rgba(16,185,129,0.3)] mt-4 uppercase hover:shadow-[0_0_25px_rgba(16,185,129,0.4)]">
                Buat Akun
            </button>
        </form>

        <p class="text-center text-zinc-600 text-xs mt-6">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-emerald-400 hover:text-emerald-300 font-bold transition-colors">Masuk di sini</a>
        </p>
    </div>

</body>
</html>
