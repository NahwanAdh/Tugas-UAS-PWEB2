<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Field;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // Riwayat booking milik user yang sedang login
    public function index(Request $request)
    {
        $bookings = $request->user()->bookings()
            ->with('field')
            ->orderByDesc('booking_date')
            ->orderByDesc('start_time')
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    public function create(Field $field)
    {
        return view('bookings.create', compact('field'));
    }

    public function store(Request $request, Field $field)
    {
        $validated = $request->validate([
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
        ]);

        // Validasi bentrok jadwal di sisi server (wajib, jangan hanya di frontend)
        $conflict = Booking::hasConflict(
            $field->id,
            $validated['booking_date'],
            $validated['start_time'],
            $validated['end_time']
        );

        if ($conflict) {
            return back()
                ->withInput()
                ->withErrors(['start_time' => 'Slot waktu ini sudah dibooking. Silakan pilih jam lain.']);
        }

        // Hitung total harga berdasarkan durasi jam x harga per jam
        $start = \Carbon\Carbon::createFromFormat('H:i', $validated['start_time']);
        $end = \Carbon\Carbon::createFromFormat('H:i', $validated['end_time']);
        $hours = $end->diffInMinutes($start) / 60;
        $totalPrice = $hours * $field->price_per_hour;

        Booking::create([
            'user_id' => $request->user()->id,
            'field_id' => $field->id,
            'booking_date' => $validated['booking_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking berhasil diajukan. Menunggu konfirmasi Admin.');
    }

    public function cancel(Request $request, Booking $booking)
    {
        // Pastikan hanya pemilik booking yang bisa cancel
        abort_if($booking->user_id !== $request->user()->id, 403);

        // Hanya bisa cancel jika masih pending/approved dan minimal H-1 dari jadwal
        $canCancel = in_array($booking->status, ['pending', 'approved'])
            && now()->lt($booking->booking_date->copy()->subDay());

        if (!$canCancel) {
            return back()->withErrors(['cancel' => 'Booking ini tidak dapat dibatalkan (sudah lewat batas waktu atau sudah selesai/dibatalkan).']);
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking berhasil dibatalkan.');
    }
}
