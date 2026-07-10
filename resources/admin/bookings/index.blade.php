<x-admin-layout>
    <h1 class="text-2xl font-bold mb-6">Kelola Booking</h1>

    <form method="GET" class="mb-4 flex gap-2">
        <select name="status" onchange="this.form.submit()" class="rounded border-gray-300">
            <option value="">Semua Status</option>
            @foreach (['pending', 'approved', 'rejected', 'completed', 'cancelled'] as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
    </form>

    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr class="text-left">
                    <th class="p-3">User</th>
                    <th class="p-3">Lapangan</th>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Jam</th>
                    <th class="p-3">Total</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bookings as $b)
                    <tr class="border-b">
                        <td class="p-3">{{ $b->user->name }}</td>
                        <td class="p-3">{{ $b->field->name }}</td>
                        <td class="p-3">{{ \Carbon\Carbon::parse($b->booking_date)->translatedFormat('d M Y') }}</td>
                        <td class="p-3">{{ substr($b->start_time, 0, 5) }} - {{ substr($b->end_time, 0, 5) }}</td>
                        <td class="p-3">Rp {{ number_format($b->total_price, 0, ',', '.') }}</td>
                        <td class="p-3 capitalize">{{ $b->status }}</td>
                        <td class="p-3 space-x-2">
                            @if ($b->status === 'pending')
                                <form action="{{ route('admin.bookings.approve', $b) }}" method="POST" class="inline">
                                    @csrf @method('PATCH')
                                    <button class="text-green-600 hover:underline">Approve</button>
                                </form>
                                <form action="{{ route('admin.bookings.reject', $b) }}" method="POST" class="inline">
                                    @csrf @method('PATCH')
                                    <button class="text-red-600 hover:underline">Reject</button>
                                </form>
                            @elseif ($b->status === 'approved')
                                <form action="{{ route('admin.bookings.complete', $b) }}" method="POST" class="inline">
                                    @csrf @method('PATCH')
                                    <button class="text-blue-600 hover:underline">Tandai Selesai</button>
                                </form>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="p-3 text-gray-500">Belum ada booking.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $bookings->links() }}</div>
</x-admin-layout>
