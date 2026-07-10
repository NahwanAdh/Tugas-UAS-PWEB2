<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Booking Saya</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4">
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ $errors->first() }}</div>
        @endif

        <div class="bg-white rounded shadow overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr class="text-left">
                        <th class="p-3">Lapangan</th>
                        <th class="p-3">Tanggal</th>
                        <th class="p-3">Jam</th>
                        <th class="p-3">Total</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        <tr class="border-b">
                            <td class="p-3">{{ $booking->field->name }}</td>
                            <td class="p-3">{{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d M Y') }}</td>
                            <td class="p-3">{{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }}</td>
                            <td class="p-3">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                            <td class="p-3">
                                <span @class([
                                    'px-2 py-1 rounded text-xs font-medium',
                                    'bg-yellow-100 text-yellow-800' => $booking->status === 'pending',
                                    'bg-green-100 text-green-800' => $booking->status === 'approved',
                                    'bg-red-100 text-red-800' => $booking->status === 'rejected',
                                    'bg-gray-200 text-gray-700' => in_array($booking->status, ['completed', 'cancelled']),
                                ])>{{ ucfirst($booking->status) }}</span>
                            </td>
                            <td class="p-3">
                                @if (in_array($booking->status, ['pending', 'approved']))
                                    <form method="POST" action="{{ route('bookings.cancel', $booking) }}"
                                          onsubmit="return confirm('Batalkan booking ini?')">
                                        @csrf
                                        @method('PATCH')
                                        <button class="text-red-600 hover:underline">Batalkan</button>
                                    </form>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="p-3 text-gray-500">Belum ada booking.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $bookings->links() }}</div>
    </div>
</x-app-layout>
