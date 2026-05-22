<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RYPER_HUB</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-zinc-950 text-zinc-300 min-h-screen flex items-center justify-center p-6 font-sans relative overflow-hidden">

    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-emerald-500/10 blur-[100px] rounded-full z-0"></div>

    <div class="bg-zinc-900/80 backdrop-blur border border-zinc-800 rounded-2xl p-8 w-full max-w-sm shadow-2xl relative z-10">
        <div class="text-center mb-8">
            <a href="/" class="text-3xl font-black text-white tracking-widest uppercase mb-1 block">RYPER<span class="text-emerald-500">_</span>HUB</a>
            <p class="text-zinc-500 text-xs font-mono uppercase tracking-widest">Member Portal</p>
        </div>

        @error('email')
            <div class="bg-rose-500/10 border border-rose-500/50 text-rose-400 p-3 rounded-md text-xs font-bold mb-6 text-center">
                {{ $message }}
            </div>
        @enderror

        <form action="/login" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="w-full bg-zinc-950 border border-zinc-800 rounded-md px-4 py-3 text-emerald-400 font-mono focus:outline-none focus:border-emerald-500 transition-colors">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-2">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full bg-zinc-950 border border-zinc-800 rounded-md px-4 py-3 text-emerald-400 font-mono tracking-widest focus:outline-none focus:border-emerald-500 transition-colors">
            </div>

            <button type="submit" id="login-btn" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white py-3 rounded-md font-bold text-xs tracking-widest transition-colors shadow-[0_0_15px_rgba(16,185,129,0.3)] mt-4 uppercase">
                Masuk
            </button>
        </form>

        <p class="text-center text-zinc-600 text-xs mt-6">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-emerald-400 hover:text-emerald-300 font-bold transition-colors">Daftar di sini</a>
        </p>
    </div>

</body>
</html>