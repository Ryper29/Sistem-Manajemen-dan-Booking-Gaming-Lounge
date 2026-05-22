<?php

namespace App\Http\Controllers;

use App\Models\Hub;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Dashboard customer — tampilkan ruangan yang tersedia
     */
    public function dashboard()
    {
        $hubs = Hub::orderBy('tier')->orderBy('hub_number')->get();

        // Ambil booking customer yang sedang aktif atau upcoming
        $myBookings = Transaction::where('user_id', Auth::id())
            ->whereIn('status', ['Active', 'Booked'])
            ->orderBy('start_time', 'asc')
            ->with('hub')
            ->get();

        return view('customer.dashboard', compact('hubs', 'myBookings'));
    }

    /**
     * Form booking customer untuk hub tertentu
     */
    public function bookingForm(string $hubId)
    {
        $hub = Hub::findOrFail($hubId);
        return view('customer.booking', compact('hub'));
    }

    /**
     * Simpan booking dari customer
     */
    public function storeBooking(Request $request)
    {
        $request->validate([
            'hub_id'         => 'required|exists:hubs,id',
            'start_time'     => 'required|date|after_or_equal:now',
            'duration_hours' => 'required|integer|min:1|max:24',
        ]);

        $hub = Hub::findOrFail($request->hub_id);

        $startTime = \Carbon\Carbon::parse($request->start_time);
        $endTime   = (clone $startTime)->addHours((int) $request->duration_hours);

        // Cek konflik jadwal
        $conflict = Transaction::where('hub_id', $hub->id)
            ->whereIn('status', ['Active', 'Booked'])
            ->where('start_time', '<', $endTime)
            ->where('end_time', '>', $startTime)
            ->exists();

        if ($conflict) {
            return back()->withErrors(['msg' => 'Ruangan sudah dibooking orang lain pada jam tersebut. Pilih waktu lain.']);
        }

        // Hitung harga add-on
        $addOnPrices = [
            'snack'          => 15000,
            'controller_ps5' => 10000,
            'nintendo'       => 20000,
            'vr_gear'        => 25000,
        ];
        $addOnName  = $request->add_on ?: null;
        $addOnPrice = $addOnPrices[$addOnName] ?? 0;
        $totalPrice = ($request->duration_hours * $hub->price_per_hour) + $addOnPrice;

        $status = $startTime->isFuture() ? 'Booked' : 'Active';

        Transaction::create([
            'user_id'        => Auth::id(),
            'hub_id'         => $hub->id,
            'customer_name'  => Auth::user()->name,
            'duration_hours' => $request->duration_hours,
            'add_on_name'    => $addOnName,
            'add_on_price'   => $addOnPrice,
            'total_price'    => $totalPrice,
            'start_time'     => $startTime,
            'end_time'       => $endTime,
            'status'         => $status,
        ]);

        if ($status === 'Active') {
            $hub->update(['status' => 'Disewa']);
        }

        return redirect()->route('customer.dashboard')->with('success', 'Booking berhasil! Sampai jumpa di RYPER_HUB 🎮');
    }
}
