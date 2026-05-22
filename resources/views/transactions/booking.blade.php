@extends('layouts.app')

@section('content')
<div class="mb-10 pb-6 border-b border-zinc-800">
    <h1 class="text-3xl font-bold text-white tracking-wide uppercase">Daftar Reservasi</h1>
    <p class="text-zinc-500 mt-1 text-sm">Daftar pelanggan yang telah menjadwalkan sewa.</p>
</div>

<div class="bg-zinc-900/50 border border-zinc-800 rounded-xl overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-zinc-900 border-b border-zinc-800">
                <th class="p-4 text-xs font-bold text-zinc-500 uppercase tracking-widest">Pelanggan</th>
                <th class="p-4 text-xs font-bold text-zinc-500 uppercase tracking-widest">Ruangan</th>
                <th class="p-4 text-xs font-bold text-zinc-500 uppercase tracking-widest">Jadwal Main</th>
                <th class="p-4 text-xs font-bold text-zinc-500 uppercase tracking-widest">Durasi</th>
                <th class="p-4 text-xs font-bold text-zinc-500 uppercase tracking-widest text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-zinc-800/50">
            @forelse($bookings as $booking)
            <tr class="hover:bg-zinc-800/30 transition-colors">
                <td class="p-4 font-semibold text-white">{{ $booking->customer_name }}</td>
                <td class="p-4">
                    <span class="px-2 py-1 bg-zinc-800 text-zinc-400 text-[10px] font-bold rounded border border-zinc-700">
                        {{ $booking->hub->hub_number }} ({{ $booking->hub->tier }})
                    </span>
                </td>
                <td class="p-4 text-sm text-zinc-400">
                    {{ \Carbon\Carbon::parse($booking->start_time)->format('d M Y, H:i') }}
                </td>
                <td class="p-4 text-sm text-zinc-400">{{ $booking->duration_hours }} Jam</td>
                <td class="p-4 text-right">
                    <form action="{{ route('transactions.start', $booking->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="text-[10px] bg-emerald-500/10 hover:bg-emerald-500 text-emerald-500 hover:text-white font-bold px-3 py-1.5 rounded border border-emerald-500/50 transition-all">
                            MULAI MAIN
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="p-10 text-center text-zinc-600 italic">Tidak ada jadwal booking untuk saat ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection