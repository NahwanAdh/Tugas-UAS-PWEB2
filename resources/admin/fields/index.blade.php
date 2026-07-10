<x-admin-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Kelola Lapangan</h1>
        <a href="{{ route('admin.fields.create') }}" class="bg-emerald-600 text-white px-4 py-2 rounded">+ Tambah Lapangan</a>
    </div>

    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr class="text-left">
                    <th class="p-3">Nama</th>
                    <th class="p-3">Harga/Jam</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($fields as $field)
                    <tr class="border-b">
                        <td class="p-3">{{ $field->name }}</td>
                        <td class="p-3">Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}</td>
                        <td class="p-3">
                            @if ($field->is_active)
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Aktif</span>
                            @else
                                <span class="px-2 py-1 bg-gray-200 text-gray-700 rounded text-xs">Nonaktif</span>
                            @endif
                        </td>
                        <td class="p-3 space-x-2">
                            <a href="{{ route('admin.fields.edit', $field) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.fields.destroy', $field) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Hapus lapangan ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="p-3 text-gray-500">Belum ada lapangan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $fields->links() }}</div>
</x-admin-layout>
