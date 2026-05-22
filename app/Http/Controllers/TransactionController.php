<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Hub; // Wajib dipanggil supaya sistem mengenali ruangan
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Menangkap data Ruangan (Hub) mana yang diklik oleh operator
        $hub = Hub::findOrFail($request->hub);
        
        // Melempar data ruangan tersebut ke halaman form kasir
        return view('transactions.create', compact('hub'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'hub_id' => 'required',
            'customer_name' => 'required',
            'start_time' => 'required|date',
            'duration_hours' => 'required|integer|min:1',
        ]);

        $hub = Hub::findOrFail($request->hub_id);
        
        // 1. Hitung Waktu
        $startTime = \Carbon\Carbon::parse($request->start_time);
        $endTime = (clone $startTime)->addHours((int) $request->duration_hours);

        // 2. CEK KONFLIK JADWAL (Fitur Pro)
        // Cari apakah ada transaksi lain di ruangan yang sama pada jam yang bersinggungan
        $conflict = Transaction::where('hub_id', $hub->id)
            ->whereIn('status', ['Active', 'Booked'])
            ->where(function($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                      ->orWhereBetween('end_time', [$startTime, $endTime])
                      ->orWhere(function($q) use ($startTime, $endTime) {
                          $q->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                      });
            })->exists();

        if ($conflict) {
            return back()->withErrors(['msg' => 'Gagal! Ruangan ini sudah dibooking orang lain pada jam tersebut.']);
        }

        // 3. Tentukan Status & Update Ruangan
        // Jika start_time adalah masa depan, statusnya 'Booked'
        // Jika start_time adalah sekarang (toleransi 1 menit), statusnya 'Active'
        $status = $startTime->isFuture() ? 'Booked' : 'Active';

        // 4. Kalkulasi Harga Add-On
        $addOnPrices = [
            'snack'          => 15000,
            'controller_ps5' => 10000,
            'nintendo'       => 20000,
            'vr_gear'        => 25000,
        ];
        $addOnName  = $request->add_on ?: null;
        $addOnPrice = $addOnPrices[$addOnName] ?? 0;
        $totalPrice = ($request->duration_hours * $hub->price_per_hour) + $addOnPrice;

        // 5. Simpan Transaksi
        Transaction::create([
            'hub_id'         => $hub->id,
            'customer_name'  => $request->customer_name,
            'duration_hours' => $request->duration_hours,
            'add_on_name'    => $addOnName,
            'add_on_price'   => $addOnPrice,
            'total_price'    => $totalPrice,
            'start_time'     => $startTime,
            'end_time'       => $endTime,
            'status'         => $status,
        ]);

        // Jika statusnya Active, ubah ruangan jadi 'Disewa' agar timer muncul
        if ($status == 'Active') {
            $hub->update(['status' => 'Disewa']);
        }

        return redirect()->route('hubs.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function report()
    {
        // Ambil data pendapatan 7 Hari Terakhir
        $chartData = Transaction::where('status', 'Completed')
            ->where('created_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, SUM(total_price) as total')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $chartLabels = $chartData->pluck('date')->toArray();
        $chartValues = $chartData->pluck('total')->toArray();

        return view('reports.index', compact('chartLabels', 'chartValues'));
    }

    public function bookingList()
    {
        // Mengambil transaksi yang statusnya 'Booked' dan diurutkan berdasarkan waktu mulai terdekat
        $bookings = Transaction::with('hub')
                    ->where('status', 'Booked')
                    ->orderBy('start_time', 'asc')
                    ->get();

        return view('transactions.booking', compact('bookings'));
    }

    public function startBooking($id)
    {
        $transaction = Transaction::findOrFail($id);

        // 1. Ubah status transaksi menjadi Active
        // PRO TIP: Kita me-reset waktu mulai menjadi 'SEKARANG' (now).
        // Kenapa? Agar pelanggan yang telat 5 menit tidak rugi waktu sewa
        $transaction->update([
            'status' => 'Active',
            'start_time' => now(),
            'end_time' => now()->addHours($transaction->duration_hours)
        ]);

        // 2. Ubah status ruangan menjadi Disewa
        $transaction->hub->update([
            'status' => 'Disewa'
        ]);

        // 3. Kembalikan ke halaman Dashboard Utama
        return redirect()->route('hubs.index');
    }
}