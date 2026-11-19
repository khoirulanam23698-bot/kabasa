<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\ParkingArea;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetugasController extends Controller
{
    // Menampilkan form input kendaraan masuk
    public function create()
    {
        // Ambil semua kendaraan yang didaftarkan Admin
        $vehicles = Vehicle::orderBy('plat_nomor')->get(); 
        // Ambil semua area parkir
        $areas = ParkingArea::all(); 
        
        // KITA UBAH MENJADI 'petugas.transaksi.create' KARENA FILENYA ADA DI FOLDER PETUGAS/TRANSAKSI
        return view('petugas.transaksi.create', compact('vehicles', 'areas'));
    }

    // Menyimpan transaksi masuk
    public function store(Request $request)
    {
        $request->validate([
            'plat_nomor' => 'required|exists:vehicles,plat_nomor',
            'parking_area_id' => 'required|exists:parking_areas,id',
        ]);

        // Cari data kendaraan berdasarkan plat yang dipilih
        $vehicle = Vehicle::where('plat_nomor', $request->plat_nomor)->first();

        // Simpan ke tabel bookings sebagai transaksi masuk
        Booking::create([
            'user_id' => Auth::id(), // ID Petugas yang menginput
            'vehicle_id' => $vehicle->id,
            'parking_area_id' => $request->parking_area_id,
            'plat_kendaraan' => $vehicle->plat_nomor,
            'nama_kendaraan' => $vehicle->nama_kendaraan,
            'waktu_masuk' => now(),
            'status' => 'Parkir', // Status awal
        ]);

        return redirect()->route('petugas.transaksi.index')->with('success', 'Kendaraan berhasil masuk area parkir!');
    }
}