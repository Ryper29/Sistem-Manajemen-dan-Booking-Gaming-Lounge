@extends('layouts.app')

@section('header_class', 'hidden')

@section('content')
<div class="max-w-xl mx-auto mt-10">
    <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-8 shadow-2xl">
        <h1 class="text-2xl font-black text-white tracking-wide uppercase mb-2">Form Sewa Ruangan</h1>
        <p class="text-zinc-500 text-sm mb-6 pb-6 border-b border-zinc-800">
            <span class="font-bold text-emerald-500">HUB-{{ str_pad(request('hub'), 2, '0', STR_PAD_LEFT) }}</span>
        </p>

        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf
            
            <input type="hidden" name="hub_id" value="{{ request('hub') }}">

            @if ($errors->any())
                <div class="mb-6 bg-rose-900/20 border border-rose-800 text-rose-400 px-4 py-3 rounded-md text-sm shadow-inner">
                    <div class="font-bold uppercase tracking-widest text-xs mb-1">Transaksi Ditolak:</div>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-6">
                <label class="block text-xs font-bold text-zinc-500 uppercase tracking-widest mb-2">Nama Pelanggan</label>
                <input type="text" name="customer_name" required placeholder="Masukkan nama..."
                    class="w-full bg-zinc-950 border border-zinc-800 rounded-md px-4 py-3 text-white focus:outline-none focus:border-emerald-500 transition-colors">
            </div>

            <div class="mb-6">
                <label class="block text-xs font-bold text-zinc-500 uppercase tracking-widest mb-2">Waktu Mulai</label>
                <input type="datetime-local" name="start_time" value="{{ now()->format('Y-m-d\TH:i') }}" required
                    class="w-full bg-zinc-950 border border-zinc-800 rounded-md px-4 py-3 text-white font-mono focus:outline-none focus:border-emerald-500 transition-colors">
                <p class="text-[10px] text-zinc-600 mt-2">*Biarkan sesuai bawaan jika ingin sewa sekarang.</p>
            </div>

            <div class="mb-6">
                <label class="block text-xs font-bold text-zinc-500 uppercase tracking-widest mb-2">Durasi Main (Jam)</label>
                <input type="number" name="duration_hours" min="1" required placeholder="Contoh: 2"
                    class="w-full bg-zinc-950 border border-zinc-800 rounded-md px-4 py-3 text-white font-mono focus:outline-none focus:border-emerald-500 transition-colors">
            </div>

            <div class="mb-6">
                <label class="block text-xs font-bold text-zinc-500 uppercase tracking-widest mb-2">Fasilitas Tambahan</label>
                <select name="add_on" class="w-full bg-zinc-950 border border-zinc-800 rounded-md px-4 py-3 text-white focus:outline-none focus:border-emerald-500 transition-colors appearance-none">
                    <option value="">-- Tidak Ada Tambahan --</option>
                    <option value="controller_ps5">Extra Controller PS5 (+ Rp 10.000)</option>
                    <option value="nintendo">Konsol Nintendo (+ Rp 20.000)</option>
                    <option value="snack">Paket Snack & Minum (+ Rp 15.000)</option>
                    <option value="vr_gear">VR Gear (+ Rp 25.000)</option>
                </select>
            </div>

            <div class="flex gap-4 mt-8">
                <a href="{{ route('hubs.index') }}" class="flex-1 bg-zinc-800 hover:bg-zinc-700 text-zinc-300 font-bold py-3 px-4 rounded-md text-center transition-colors border border-zinc-700">BATAL</a>
                <button type="submit" class="flex-1 bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-3 px-4 rounded-md transition-colors shadow-lg">PROSES TRANSAKSI</button>
            </div>
        </form>
    </div>
</div>
@endsection