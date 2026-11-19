<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('user', 'slot', 'payment')->latest()->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function resetStruk(Booking $booking)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Akses ditolak.');

        $booking->update(['struk_dicetak_at' => null]);

        ActivityLog::create([
            'user' => auth()->user()->name,
            'activity' => 'Reset Struk',
            'details' => "Status cetak struk booking #{$booking->id} direset, struk bisa dicetak ulang",
        ]);

        return back()->with('success', 'Status cetak struk booking #' . $booking->id . ' berhasil direset.');
    }

    public function rekap(Request $request)
    {
        $dari = $request->query('dari');
        $sampai = $request->query('sampai');

        $query = Booking::with('slot', 'payment')
            ->whereHas('payment', function ($q) {
                $q->where('status', 'lunas');
            });

        if (!empty($dari)) {
            $query->whereDate('waktu_masuk', '>=', $dari);
        }

        if (!empty($sampai)) {
            $query->whereDate('waktu_masuk', '<=', $sampai);
        }

        $bookings = $query->orderByDesc('waktu_masuk')->get();

        $totalPendapatan = $bookings->sum(fn ($booking) => $booking->payment->jumlah ?? 0);

        return view('owner.rekap', [
            'bookings' => $bookings,
            'totalPendapatan' => $totalPendapatan,
            'dari' => $dari,
            'sampai' => $sampai,
        ]);
    }
}