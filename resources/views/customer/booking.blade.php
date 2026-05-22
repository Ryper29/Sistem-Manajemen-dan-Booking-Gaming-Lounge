<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking {{ $hub->tier }} #{{ $hub->hub_number }} - RYPER_HUB</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-zinc-950 text-white font-sans antialiased min-h-screen">

    {{-- NAVBAR --}}
    <nav class="fixed w-full z-50 border-b border-zinc-800/50 bg-zinc-950/90 backdrop-blur-md">
        <div class="max-w-4xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-2 text-zinc-400 hover:text-emerald-400 transition-colors font-bold text-sm">
                ← Kembali ke Dashboard
            </a>
            <span class="text-lg font-black tracking-widest uppercase">RYPER<span class="text-emerald-500">_</span>HUB</span>
        </div>
    </nav>

    <div class="pt-28 pb-16 max-w-4xl mx-auto px-6">

        {{-- ERROR --}}
        @if($errors->any())
        <div class="mb-6 bg-rose-500/10 border border-rose-500/40 text-rose-400 px-5 py-4 rounded-xl text-sm font-bold">
            @foreach($errors->all() as $error)
                <div>⚠️ {{ $error }}</div>
            @endforeach
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

            {{-- ROOM INFO (kiri) --}}
            <div class="lg:col-span-2">
                <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 sticky top-28">
                    <div class="text-emerald-500 text-xs font-bold tracking-widest uppercase mb-1">{{ $hub->tier }} Tier</div>
                    <h2 class="text-3xl font-black mb-1">HUB<span class="text-zinc-500">_</span>{{ str_pad($hub->hub_number, 2, '0', STR_PAD_LEFT) }}</h2>
                    <p class="text-zinc-500 text-sm mb-6 pb-6 border-b border-zinc-800">{{ $hub->facilities }}</p>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-zinc-500">Harga Sewa</span>
                            <span class="font-bold text-white">Rp {{ number_format($hub->price_per_hour, 0, ',', '.') }}/jam</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-zinc-500">Status</span>
                            <span class="text-emerald-400 font-bold">{{ $hub->status }}</span>
                        </div>
                    </div>

                    {{-- Kalkulasi Harga Real-time --}}
                    <div class="mt-6 pt-6 border-t border-zinc-800">
                        <div class="text-zinc-500 text-xs uppercase tracking-widest mb-2">Estimasi Total</div>
                        <div id="price-display" class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-500">
                            Rp 0
                        </div>
                        <div id="price-breakdown" class="text-zinc-600 text-xs mt-1 font-mono"></div>
                    </div>
                </div>
            </div>

            {{-- BOOKING FORM (kanan) --}}
            <div class="lg:col-span-3">
                <div class="mb-8">
                    <h1 class="text-3xl font-black uppercase tracking-tight mb-2">Form Booking</h1>
                    <p class="text-zinc-500 text-sm">Isi detail booking kamu di bawah ini.</p>
                </div>

                <form action="{{ route('customer.store') }}" method="POST" id="booking-form" class="space-y-6">
                    @csrf
                    <input type="hidden" name="hub_id" value="{{ $hub->id }}">

                    {{-- Nama (pre-filled) --}}
                    <div>
                        <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-2">Nama Kamu</label>
                        <input type="text" value="{{ Auth::user()->name }}" readonly
                            class="w-full bg-zinc-900 border border-zinc-700 rounded-md px-4 py-3 text-zinc-400 font-mono cursor-not-allowed">
                    </div>

                    {{-- Tanggal & Waktu Mulai --}}
                    <div>
                        <label for="start_time" class="block text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-2">Tanggal & Waktu Mulai</label>
                        <input type="datetime-local" name="start_time" id="start_time" required
                            value="{{ old('start_time') }}"
                            min="{{ now()->format('Y-m-d\TH:i') }}"
                            class="w-full bg-zinc-950 border border-zinc-800 rounded-md px-4 py-3 text-white font-mono focus:outline-none focus:border-emerald-500 transition-colors">
                    </div>

                    {{-- Durasi --}}
                    <div>
                        <label for="duration_hours" class="block text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-2">Durasi (Jam)</label>
                        <div class="flex items-center gap-3">
                            <input type="number" name="duration_hours" id="duration_hours" required
                                min="1" max="24" value="{{ old('duration_hours', 1) }}"
                                class="w-full bg-zinc-950 border border-zinc-800 rounded-md px-4 py-3 text-emerald-400 font-mono text-xl font-bold focus:outline-none focus:border-emerald-500 transition-colors">
                            <span class="text-zinc-500 text-sm shrink-0">jam</span>
                        </div>
                    </div>

                    {{-- Add-On --}}
                    <div>
                        <label for="add_on" class="block text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-2">Add-On (Opsional)</label>
                        <select name="add_on" id="add_on"
                            class="w-full bg-zinc-950 border border-zinc-800 rounded-md px-4 py-3 text-white font-mono focus:outline-none focus:border-emerald-500 transition-colors">
                            <option value="">— Tanpa Add-On —</option>
                            <option value="controller_ps5" data-price="10000" {{ old('add_on') === 'controller_ps5' ? 'selected' : '' }}>Controller PS5 (+Rp 10.000)</option>
                            <option value="nintendo"       data-price="20000" {{ old('add_on') === 'nintendo' ? 'selected' : '' }}>Nintendo Switch (+Rp 20.000)</option>
                            <option value="snack"          data-price="15000" {{ old('add_on') === 'snack' ? 'selected' : '' }}>Snack Pack (+Rp 15.000)</option>
                            <option value="vr_gear"        data-price="25000" {{ old('add_on') === 'vr_gear' ? 'selected' : '' }}>VR Gear (+Rp 25.000)</option>
                        </select>
                    </div>

                    <button type="submit" id="confirm-booking-btn"
                        class="w-full bg-emerald-600 hover:bg-emerald-500 text-white py-4 rounded-xl font-black text-sm tracking-widest uppercase transition-all shadow-[0_0_20px_rgba(16,185,129,0.3)] hover:shadow-[0_0_30px_rgba(16,185,129,0.45)] hover:scale-[1.01]">
                        Konfirmasi Booking
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const pricePerHour = {{ $hub->price_per_hour }};

        function formatRupiah(amount) {
            return 'Rp ' + amount.toLocaleString('id-ID');
        }

        function updatePrice() {
            const duration = parseInt(document.getElementById('duration_hours').value) || 0;
            const addOnSelect = document.getElementById('add_on');
            const addOnPrice = parseInt(addOnSelect.selectedOptions[0]?.dataset?.price || 0);

            const basePrice = duration * pricePerHour;
            const totalPrice = basePrice + addOnPrice;

            document.getElementById('price-display').textContent = formatRupiah(totalPrice);

            let breakdown = `${duration} jam × ${formatRupiah(pricePerHour)}`;
            if (addOnPrice > 0) {
                breakdown += ` + Add-On ${formatRupiah(addOnPrice)}`;
            }
            document.getElementById('price-breakdown').textContent = breakdown;
        }

        document.getElementById('duration_hours').addEventListener('input', updatePrice);
        document.getElementById('add_on').addEventListener('change', updatePrice);
        updatePrice();
    </script>

</body>
</html>
