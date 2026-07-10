<x-admin-layout>
    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded shadow p-5">
            <p class="text-gray-500 text-sm">Total Booking</p>
            <p class="text-2xl font-bold">{{ $totalBookings }}</p>
        </div>
        <div class="bg-white rounded shadow p-5">
            <p class="text-gray-500 text-sm">Menunggu Konfirmasi</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $pendingBookings }}</p>
        </div>
        <div class="bg-white rounded shadow p-5">
            <p class="text-gray-500 text-sm">Total Lapangan</p>
            <p class="text-2xl font-bold">{{ $totalFields }}</p>
        </div>
        <div class="bg-white rounded shadow p-5">
            <p class="text-gray-500 text-sm">Total Pendapatan</p>
            <p class="text-2xl font-bold text-emerald-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded shadow p-5">
            <h2 class="font-semibold mb-3">Lapangan Terpopuler</h2>
            <ul class="divide-y">
                @forelse ($popularFields as $f)
                    <li class="py-2 flex justify-between text-sm">
                        <span>{{ $f->name }}</span>
                        <span class="text-gray-500">{{ $f->bookings_count }} booking</span>
                    </li>
                @empty
                    <li class="py-2 text-gray-500 text-sm">Belum ada data.</li>
                @endforelse
            </ul>
        </div>

        <div class="bg-white rounded shadow p-5">
            <h2 class="font-semibold mb-3">Booking Terbaru</h2>
            <ul class="divide-y">
                @forelse ($recentBookings as $b)
                    <li class="py-2 text-sm">
                        <div class="flex justify-between">
                            <span>{{ $b->user->name }} - {{ $b->field->name }}</span>
                            <span class="capitalize text-gray-500">{{ $b->status }}</span>
                        </div>
                    </li>
                @empty
                    <li class="py-2 text-gray-500 text-sm">Belum ada data.</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-admin-layout>
