<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">{{ $field->name }}</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4">
        <div class="bg-white rounded shadow p-6">
            @if ($field->photo)
                <img src="{{ asset('storage/' . $field->photo) }}" class="w-full h-64 object-cover rounded mb-4">
            @endif
            <p class="text-gray-700">{{ $field->description }}</p>
            <p class="mt-3 text-xl font-bold text-slate-800">Rp {{ number_format($field->price_per_hour, 0, ',', '.') }} / jam</p>

            @auth
                <a href="{{ route('bookings.create', $field) }}" class="mt-4 inline-block bg-emerald-600 text-white px-5 py-2 rounded">Booking Sekarang</a>
            @else
                <a href="{{ route('login') }}" class="mt-4 inline-block bg-emerald-600 text-white px-5 py-2 rounded">Login untuk Booking</a>
            @endauth
        </div>

        <div class="bg-white rounded shadow p-6 mt-6">
            <h3 class="font-semibold text-lg mb-3">Jadwal Terisi (14 hari ke depan)</h3>
            @if ($bookedSlots->isEmpty())
                <p class="text-gray-500 text-sm">Belum ada jadwal terisi. Semua slot masih kosong.</p>
            @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="py-2">Tanggal</th>
                            <th class="py-2">Jam</th>
                            <th class="py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookedSlots as $slot)
                            <tr class="border-b">
                                <td class="py-2">{{ \Carbon\Carbon::parse($slot->booking_date)->translatedFormat('d M Y') }}</td>
                                <td class="py-2">{{ substr($slot->start_time, 0, 5) }} - {{ substr($slot->end_time, 0, 5) }}</td>
                                <td class="py-2 capitalize">{{ $slot->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
