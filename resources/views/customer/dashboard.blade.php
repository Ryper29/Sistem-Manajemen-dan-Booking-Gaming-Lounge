<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - RYPER_HUB</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-zinc-950 text-white font-sans antialiased min-h-screen">

    {{-- NAVBAR --}}
    <nav class="fixed w-full z-50 border-b border-zinc-800/50 bg-zinc-950/90 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('customer.dashboard') }}" class="text-2xl font-black tracking-widest uppercase">RYPER<span class="text-emerald-500">_</span>HUB</a>
            <div class="flex items-center gap-4">
                <span class="text-zinc-400 text-sm hidden md:block">
                    Halo, <span class="text-emerald-400 font-bold">{{ Auth::user()->name }}</span>
                </span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" id="logout-btn" class="text-xs font-bold text-zinc-400 hover:text-rose-400 transition-colors border border-zinc-800 hover:border-rose-800 px-4 py-2 rounded-lg">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="pt-24 pb-16 max-w-7xl mx-auto px-6">

        {{-- Flash success message --}}
        @if (session('success'))
            <div class="mb-6 bg-emerald-500/10 border border-emerald-500/40 text-emerald-400 px-5 py-4 rounded-xl text-sm font-bold flex items-center gap-3">
                <span class="text-lg">✅</span> {{ session('success') }}
            </div>
        @endif

        {{-- HEADER --}}
        <div class="mb-10">
            <h1 class="text-4xl font-black uppercase tracking-tight mb-2">
                Pilih <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-600">Ruangan</span>
            </h1>
            <p class="text-zinc-500">Pilih ruangan yang tersedia dan booking sekarang sebelum penuh.</p>
        </div>

        {{-- MY ACTIVE BOOKINGS --}}
        @if($myBookings->count() > 0)
        <div class="mb-12">
            <h2 class="text-xs font-black uppercase tracking-widest text-zinc-500 mb-4">🗓️ Booking Aktif Kamu</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($myBookings as $booking)
                <div class="bg-zinc-900 border border-emerald-500/30 rounded-xl p-5 flex justify-between items-center">
                    <div>
                        <div class="text-emerald-400 font-black text-sm mb-1">
                            HUB #{{ $booking->hub->hub_number }} — {{ $booking->hub->tier }}
                        </div>
                        <div class="text-zinc-400 text-xs font-mono">
                            {{ \Carbon\Carbon::parse($booking->start_time)->format('d M Y, H:i') }}
                            &rarr;
                            {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                        </div>
                        <div class="text-zinc-500 text-xs mt-1">{{ $booking->duration_hours }} jam · Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full
                        {{ $booking->status === 'Active' ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/50' : 'bg-amber-500/20 text-amber-400 border border-amber-500/50' }}">
                        {{ $booking->status === 'Active' ? 'Berlangsung' : 'Menunggu' }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ROOM CATALOG --}}
        <div>
            <h2 class="text-xs font-black uppercase tracking-widest text-zinc-500 mb-6">🎮 Semua Ruangan</h2>

            @php
                $tiers = ['Standard', 'VIP', 'VVIP'];
            @endphp

            @foreach($tiers as $tier)
                @php $tierHubs = $hubs->where('tier', $tier); @endphp
                @if($tierHubs->count() > 0)
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="text-emerald-500 font-black text-xs uppercase tracking-widest">{{ $tier }} Tier</span>
                        <div class="flex-1 h-px bg-zinc-800"></div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                        @foreach($tierHubs as $hub)
                        <div class="bg-zinc-900 border rounded-xl p-5 flex flex-col gap-4 transition-all duration-200
                            {{ $hub->status === 'Tersedia' ? 'border-zinc-800 hover:border-emerald-500/50 group' : 'border-zinc-800 opacity-60' }}">

                            {{-- Header --}}
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="text-xs font-bold text-zinc-500 uppercase tracking-widest mb-1">Hub #{{ $hub->hub_number }}</div>
                                    <div class="text-xl font-black">
                                        HUB<span class="text-zinc-500">_</span>{{ str_pad($hub->hub_number, 2, '0', STR_PAD_LEFT) }}
                                    </div>
                                </div>
                                <span class="text-[10px] font-black uppercase tracking-widest px-2 py-1 rounded-full
                                    {{ $hub->status === 'Tersedia' ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/40' : 'bg-rose-500/10 text-rose-400 border border-rose-500/30' }}">
                                    {{ $hub->status === 'Tersedia' ? 'Tersedia' : 'Penuh' }}
                                </span>
                            </div>

                            {{-- Price --}}
                            <div class="text-2xl font-black {{ $tier === 'VVIP' ? 'text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-500' : '' }}">
                                Rp {{ number_format($hub->price_per_hour / 1000, 0) }}k
                                <span class="text-zinc-600 text-sm font-normal">/jam</span>
                            </div>

                            {{-- Facilities --}}
                            <p class="text-zinc-500 text-xs leading-relaxed flex-1">
                                {{ $hub->facilities }}
                            </p>

                            {{-- CTA --}}
                            @if($hub->status === 'Tersedia')
                                <a href="{{ route('customer.booking', $hub->id) }}" id="book-hub-{{ $hub->id }}"
                                    class="block w-full text-center bg-zinc-800 group-hover:bg-emerald-600 text-white font-bold py-2.5 rounded-lg text-sm transition-all hover:scale-[1.02]">
                                    Booking Sekarang
                                </a>
                            @else
                                <button disabled class="w-full text-center bg-zinc-800/50 text-zinc-600 font-bold py-2.5 rounded-lg text-sm cursor-not-allowed">
                                    Tidak Tersedia
                                </button>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            @endforeach
        </div>

    </div>

</body>
</html>
