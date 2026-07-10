<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Daftar Lapangan</h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto px-4">

        <form method="GET" class="mb-6 flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama lapangan..."
                   class="border-gray-300 rounded w-full max-w-sm">
            <button class="bg-slate-800 text-white px-4 py-2 rounded">Cari</button>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse ($fields as $field)
                <div class="bg-white rounded shadow overflow-hidden">
                    @if ($field->photo)
                        <img src="{{ asset('storage/' . $field->photo) }}" class="w-full h-40 object-cover">
                    @else
                        <div class="w-full h-40 bg-gray-200 flex items-center justify-center text-gray-400">Tidak ada foto</div>
                    @endif
                    <div class="p-4">
                        <h3 class="font-bold text-lg">{{ $field->name }}</h3>
                        <p class="text-gray-500 text-sm mt-1 line-clamp-2">{{ $field->description }}</p>
                        <p class="mt-2 font-semibold text-slate-800">Rp {{ number_format($field->price_per_hour, 0, ',', '.') }} / jam</p>
                        <a href="{{ route('fields.show', $field) }}" class="mt-3 inline-block bg-slate-800 text-white px-4 py-2 rounded text-sm">Lihat Detail</a>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">Belum ada lapangan tersedia.</p>
            @endforelse
        </div>

        <div class="mt-6">{{ $fields->links() }}</div>
    </div>
</x-app-layout>
