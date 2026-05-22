<?php

namespace App\Http\Controllers;

use App\Models\Hub;
use App\Models\Transaction;
use Illuminate\Http\Request;

class HubController extends Controller
{
    public function index()
    {
        // Mengambil data Hub sekaligus membawa data Transaksinya yang sedang 'Active'
        $hubs = Hub::with(['transactions' => function($query) {
            $query->where('status', 'Active');
        }])->orderBy('hub_number', 'asc')->get();

        // Statistik Cepat (Angka di atas)
        $activeRooms = Hub::where('status', 'Disewa')->count();
        $totalTransactions = Transaction::count();
        $totalRevenue = Transaction::sum('total_price');

        // Kirim semuanya ke halaman depan (View) TANPA data chart
        return view('hubs.index', compact(
            'hubs', 'activeRooms', 'totalTransactions', 'totalRevenue'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hubs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'hub_number' => 'required|unique:hubs,hub_number',
            'tier'       => 'required|in:Standard,VIP,VVIP',
        ]);

        // Logika penentuan fasilitas & harga otomatis
        $tierSettings = [
            'Standard' => ['price' => 15000, 'features' => 'PS5, DualSense'],
            'VIP'      => ['price' => 25000, 'features' => 'PS5, Nintendo Switch, Pro Controller'],
            'VVIP'     => ['price' => 40000, 'features' => 'PS5, Nintendo, VR Gear, Netflix 4K'],
        ];

        $settings = $tierSettings[$request->tier];

        Hub::create([
            'hub_number'     => $request->hub_number,
            'tier'           => $request->tier,
            'facilities'     => $settings['features'],
            'price_per_hour' => $settings['price'],
            'status'         => 'Tersedia'
        ]);

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
        $hub = Hub::findOrFail($id);
        
        // 1. Ubah status ruangan (Hub)
        $hub->update(['status' => $request->status]);

        // 2. LOGIKA BARU: Jika ruangan di-STOP (menjadi Tersedia)
        if ($request->status == 'Tersedia') {
            
            // Cari transaksi yang masih 'Active' di ruangan ini
            $activeTransaction = Transaction::where('hub_id', $hub->id)
                ->where('status', 'Active')
                ->first();

            // Jika ketemu, ubah statusnya jadi 'Completed' (Selesai)
            if ($activeTransaction) {
                $activeTransaction->update([
                    'status' => 'Completed',
                    'end_time' => now() // Ubah jam selesainya menjadi waktu saat tombol STOP ditekan
                ]);
            }
        }

        return redirect()->route('hubs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}