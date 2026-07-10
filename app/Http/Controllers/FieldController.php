<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function index(Request $request)
    {
        $query = Field::where('is_active', true);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $fields = $query->orderBy('name')->paginate(9)->withQueryString();

        return view('fields.index', compact('fields'));
    }

    public function show(Field $field)
    {
        // Ambil booking aktif (pending/approved) untuk 14 hari ke depan, buat ditampilkan sebagai jadwal terisi
        $bookedSlots = $field->bookings()
            ->whereIn('status', ['pending', 'approved'])
            ->where('booking_date', '>=', now()->toDateString())
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->get();

        return view('fields.show', compact('field', 'bookedSlots'));
    }
}
