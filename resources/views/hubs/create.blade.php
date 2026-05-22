<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Ruangan - Gaming Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-zinc-950 text-zinc-300 min-h-screen flex items-center justify-center p-6 font-sans">

    <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-8 w-full max-w-md shadow-2xl">
        <h2 class="text-2xl font-bold text-white mb-2 uppercase tracking-tight">Setup Ruangan Baru</h2>
        <p class="text-zinc-500 text-xs mb-8">Pilih tipe ruangan untuk konfigurasi otomatis.</p>

        <form action="{{ route('hubs.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest mb-2">Nomor / Nama Ruangan</label>
                <input type="text" name="hub_number" placeholder="Contoh: HUB-01 atau VVIP-05" required
                    class="w-full bg-zinc-950 border border-zinc-800 rounded-md px-4 py-3 text-zinc-100 focus:outline-none focus:border-zinc-500 transition-colors">
            </div>

            <div>
                <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest mb-2">Pilih Tier Layanan</label>
                <select name="tier" class="w-full bg-zinc-950 border border-zinc-800 rounded-md px-4 py-3 text-zinc-100 focus:outline-none focus:border-zinc-500 transition-colors appearance-none cursor-pointer">
                    <option value="Standard">Standard (PS5 Console)</option>
                    <option value="VIP">VIP (PS5 + Nintendo Switch)</option>
                    <option value="VVIP">VVIP (Premium + VR + Netflix)</option>
                </select>
                <p class="mt-2 text-[10px] text-zinc-600 italic">*Fasilitas dan harga akan disesuaikan otomatis oleh sistem.</p>
            </div>

            <div class="pt-4 flex gap-3">
                <a href="{{ route('hubs.index') }}" class="w-1/3 text-center bg-zinc-800 hover:bg-zinc-700 text-zinc-300 py-3 rounded-md font-bold text-xs transition-colors">BATAL</a>
                <button type="submit" class="w-2/3 bg-zinc-100 hover:bg-white text-zinc-900 py-3 rounded-md font-bold text-xs transition-colors shadow-lg">SIMPAN RUANGAN</button>
            </div>
        </form>
    </div>

</body>
</html>