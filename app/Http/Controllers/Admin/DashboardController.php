<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Field;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $totalFields = Field::count();
        $totalUsers = User::where('role', 'user')->count();

        $totalRevenue = Booking::whereIn('status', ['approved', 'completed'])->sum('total_price');

        $popularFields = Field::withCount(['bookings' => function ($q) {
                $q->whereIn('status', ['approved', 'completed']);
            }])
            ->orderByDesc('bookings_count')
            ->take(5)
            ->get();

        $recentBookings = Booking::with(['user', 'field'])
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalBookings', 'pendingBookings', 'totalFields', 'totalUsers',
            'totalRevenue', 'popularFields', 'recentBookings'
        ));
    }
}
