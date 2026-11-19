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
        $vehicles = Vehicle::orderBy('plat_nomor')->get(); 
        $areas = ParkingArea::all(); 
        
        return view('petugas.transaksi.create', compact('vehicles', 'areas'));
    }

    // Menyimpan transaksi masuk
    public function store(Request $request)
    {
        $request->validate([
            'plat_nomor' => 'required|exists:vehicles,plat_nomor',
            'parking_area_id' => 'required|exists:parking_areas,id',
        ]);

        $vehicle = Vehicle::where('plat_nomor', $request->plat_nomor)->first();

        Booking::create([
            'user_id' => Auth::id(),
            'vehicle_id' => $vehicle->id,
            'parking_area_id' => $request->parking_area_id,
            'parking_slot_id' => null,
            'plat_kendaraan' => $vehicle->plat_nomor,
            'nama_kendaraan' => $vehicle->nama_kendaraan,
            'waktu_masuk' => now(),
            'status' => 'aktif',
        ]);

        return redirect()->route('petugas.transaksi.index')->with('success', 'Kendaraan berhasil masuk area parkir!');
    }

    // FUNGSI BARU: Memproses kendaraan keluar & hitung biaya
    public function checkout(Request $request, Booking $booking)
    {
        // Hitung durasi (dalam jam, minimal 1 jam)
        $waktu_masuk = \Carbon\Carbon::parse($booking->waktu_masuk);
        $waktu_keluar = \Carbon\Carbon::now();
        $durasi_jam = max(1, $waktu_masuk->diffInHours($waktu_keluar));

        // Tarif per jam (bisa disesuaikan dengan jenis kendaraan)
        // Pastikan relasi $booking->vehicle ada. Jika tidak, gunakan $booking->plat_kendaraan untuk cek jenis.
        $jenis = $booking->vehicle ? $booking->vehicle->jenis_kendaraan : 'Motor';
        $tarif_per_jam = $jenis === 'Mobil' ? 5000 : 2000;
        
        $biaya_total = $durasi_jam * $tarif_per_jam;

        // Update booking
        $booking->update([
            'waktu_keluar' => $waktu_keluar,
            'status' => 'selesai',
        ]);

        // Buat atau update pembayaran menjadi Lunas
        if ($booking->payment) {
            $booking->payment->update([
                'jumlah' => $biaya_total,
                'status' => 'lunas',
                'metode' => 'tunai',
            ]);
        } else {
            \App\Models\Payment::create([
                'booking_id' => $booking->id,
                'jumlah' => $biaya_total,
                'status' => 'lunas',
                'metode' => 'tunai',
            ]);
        }

        // Log Aktivitas
        \App\Models\ActivityLog::create([
            'user' => Auth::user()->name,
            'activity' => 'Checkout Kendaraan',
            'details' => "Plat {$booking->plat_kendaraan} keluar. Biaya: Rp " . number_format($biaya_total) . " ({$durasi_jam} jam)",
        ]);

        return redirect()->back()->with('success', "Kendaraan keluar. Biaya: Rp " . number_format($biaya_total) . ". Silakan cetak struk.");
    }
}