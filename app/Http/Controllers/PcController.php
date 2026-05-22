<?php

namespace App\Http\Controllers;
use App\Models\Pc;

use Illuminate\Http\Request;

class PcController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
        {
            // Mengambil data PC dan mengurutkannya berdasarkan kolom pc_number dari A-Z (Ascending)
            $pcs = Pc::orderBy('pc_number', 'asc')->get();

            return view('pcs.index', compact('pcs'));
        }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Membuka halaman form create.blade.php
        return view('pcs.create');
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi input (Pastikan gaada yang kosong dan nomor PC belum dipakai)
        $request->validate([
            'pc_number' => 'required|unique:pcs',
            'type' => 'required|in:Regular,VIP',
        ]);

        // 2. Simpan ke database
        Pc::create([
            'pc_number' => $request->pc_number,
            'type' => $request->type,
            'status' => 'Available' // Default saat PC baru dibeli/didaftarkan
        ]);

        // 3. Kembalikan user ke halaman depan
        return redirect()->route('pcs.index');
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
        // 1. Cari PC mana yang diklik berdasarkan ID-nya
        $pc = Pc::findOrFail($id);

        // 2. Ubah statusnya sesuai yang dikirim dari tombol (In_Use / Available)
        $pc->update([
            'status' => $request->status
        ]);

        // 3. Kembalikan ke halaman depan
        return redirect()->route('pcs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
