<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'field'])
            ->orderByDesc('booking_date')
            ->orderByDesc('start_time');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->paginate(15)->withQueryString();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function approve(Booking $booking)
    {
        abort_if($booking->status !== 'pending', 400, 'Booking ini sudah diproses sebelumnya.');
        $booking->update(['status' => 'approved']);

        return back()->with('success', 'Booking #' . $booking->id . ' disetujui.');
    }

    public function reject(Booking $booking)
    {
        abort_if($booking->status !== 'pending', 400, 'Booking ini sudah diproses sebelumnya.');
        $booking->update(['status' => 'rejected']);

        return back()->with('success', 'Booking #' . $booking->id . ' ditolak.');
    }

    public function complete(Booking $booking)
    {
        abort_if($booking->status !== 'approved', 400, 'Hanya booking berstatus approved yang bisa diselesaikan.');
        $booking->update(['status' => 'completed']);

        return back()->with('success', 'Booking #' . $booking->id . ' ditandai selesai.');
    }
}
