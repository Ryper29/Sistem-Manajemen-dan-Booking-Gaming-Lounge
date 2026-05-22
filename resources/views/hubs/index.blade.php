@extends('layouts.app')

@section('content')
    <!-- Header Halaman Dasbor -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 pb-6 border-b border-zinc-800 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white tracking-wide uppercase">
                Gaming Hub Console
            </h1>
            <p class="text-zinc-500 mt-1 text-sm">Monitoring Status Ruangan & Fasilitas</p>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="{{ route('hubs.create') }}" class="bg-zinc-100 hover:bg-white text-zinc-900 px-5 py-2.5 rounded-md font-semibold transition-colors shadow-sm">
                + Tambah Ruangan
            </a>
        </div>
    </div>

    <!-- Statistik Cepat (Total Ruangan, Transaksi, Pendapatan) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <!-- Kotak Ruangan Aktif -->
        <div class="bg-zinc-900/50 border border-zinc-800 rounded-xl p-6 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-zinc-500 uppercase tracking-widest mb-1">Ruangan Aktif</p>
                <p class="text-3xl font-black text-white"><span class="text-emerald-500">{{ $activeRooms }}</span> <span class="text-lg text-zinc-600 font-medium">/ {{ $hubs->count() }}</span></p>
            </div>
            <div class="w-12 h-12 rounded-full bg-rose-500/10 flex items-center justify-center text-rose-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
        </div>

        <!-- Kotak Total Transaksi -->
        <div class="bg-zinc-900/50 border border-zinc-800 rounded-xl p-6 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-zinc-500 uppercase tracking-widest mb-1">Total Transaksi</p>
                <p class="text-3xl font-black text-white">{{ $totalTransactions }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>

        <!-- Kotak Total Pendapatan -->
        <div class="bg-zinc-900/50 border border-zinc-800 rounded-xl p-6 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-zinc-500 uppercase tracking-widest mb-1">Total Pendapatan</p>
                <p class="text-3xl font-black text-emerald-400">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Grid Kartu Ruangan -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        @foreach($hubs as $hub)
            <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-6 flex flex-col h-full hover:border-zinc-700 transition-colors shadow-lg relative overflow-hidden group">
                
                <div class="flex justify-between items-start mb-6">
                    <span class="text-[10px] font-black uppercase tracking-widest px-2 py-1 rounded bg-zinc-800 text-zinc-400 border border-zinc-700">
                        {{ $hub->tier }}
                    </span>
                    <span class="text-xs font-mono text-zinc-500">Rp {{ number_format($hub->price_per_hour, 0, ',', '.') }}/jam</span>
                </div>

                <h2 class="text-2xl font-black text-white tracking-wide mb-1">{{ $hub->hub_number }}</h2>
                <p class="text-zinc-500 text-xs mb-6 h-8">{{ $hub->facilities }}</p>

                <!-- Fitur Hitung Mundur (Hanya muncul jika disewa) -->
                @if($hub->status == 'Disewa' && $hub->transactions->isNotEmpty())
                    <div class="mb-4 bg-zinc-950 rounded-lg p-3 text-center border border-zinc-800 shadow-inner">
                        <p class="text-[9px] text-zinc-500 font-bold uppercase tracking-widest mb-1">Sisa Waktu</p>
                        <p class="countdown-timer text-xl font-mono font-black text-rose-400 tracking-wider" 
                           data-endtime="{{ $hub->transactions->first()->end_time }}"
                           data-formid="stop-form-{{ $hub->id }}">
                            --:--:--
                        </p>
                    </div>
                @endif

                <div class="mt-auto pt-4 border-t border-zinc-800/50 flex justify-between items-center">
                    @if($hub->status == 'Tersedia')
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                            <span class="text-xs font-bold text-emerald-500 tracking-widest uppercase">TERSEDIA</span>
                        </div>
                        <a href="{{ route('transactions.create', ['hub' => $hub->id]) }}" class="text-[10px] bg-zinc-100 hover:bg-emerald-500 hover:text-white text-zinc-900 font-bold px-4 py-2 rounded transition-all inline-block text-center">SEWA</a>
                    @else
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></div>
                            <span class="text-xs font-bold text-rose-500 tracking-widest uppercase">DISEWA</span>
                        </div>
                        <form id="stop-form-{{ $hub->id }}" action="{{ route('hubs.update', $hub->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="Tersedia">
                            <button type="submit" class="text-[10px] bg-rose-900/20 hover:bg-rose-600 text-rose-400 hover:text-white font-bold px-4 py-2 rounded border border-rose-800/50 transition-all">STOP</button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Script Hitung Mundur Otomatis -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const timers = document.querySelectorAll('.countdown-timer');
            function updateTimers() {
                const now = new Date().getTime();
                timers.forEach(timer => {
                    const endTimeRaw = timer.getAttribute('data-endtime');
                    const endTime = new Date(endTimeRaw.replace(/-/g, "/")).getTime();
                    const distance = endTime - now;

                    if (distance > 0) {
                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        timer.innerHTML = String(hours).padStart(2, '0') + ":" + 
                                          String(minutes).padStart(2, '0') + ":" + 
                                          String(seconds).padStart(2, '0');
                    } else {
                        timer.innerHTML = "WAKTU HABIS!";
                        timer.classList.replace('text-rose-400', 'text-rose-600');
                        timer.classList.add('animate-pulse');
                        
                        const formId = timer.getAttribute('data-formid');
                        const stopForm = document.getElementById(formId);
                        if(stopForm && !timer.hasAttribute('data-stopped')) {
                            timer.setAttribute('data-stopped', 'true');
                            stopForm.submit();
                        }
                    }
                });
            }
            setInterval(updateTimers, 1000);
            updateTimers();
        });
    </script>
@endsection