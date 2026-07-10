<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Booking - {{ $field->name }}</h2>
    </x-slot>

    <div class="py-8 max-w-lg mx-auto px-4">
        <div class="bg-white rounded shadow p-6">
            <p class="mb-4 text-gray-600">Harga: <strong>Rp {{ number_format($field->price_per_hour, 0, ',', '.') }} / jam</strong></p>

            <form method="POST" action="{{ route('bookings.store', $field) }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                    <input type="date" name="booking_date" min="{{ now()->toDateString() }}"
                           value="{{ old('booking_date') }}" required class="w-full rounded border-gray-300">
                    @error('booking_date') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jam Mulai</label>
                        <input type="time" name="start_time" value="{{ old('start_time') }}" required class="w-full rounded border-gray-300">
                        @error('start_time') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jam Selesai</label>
                        <input type="time" name="end_time" value="{{ old('end_time') }}" required class="w-full rounded border-gray-300">
                        @error('end_time') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <button type="submit" class="w-full bg-emerald-600 text-white py-2 rounded font-medium">Ajukan Booking</button>
            </form>
        </div>
    </div>
</x-app-layout>
