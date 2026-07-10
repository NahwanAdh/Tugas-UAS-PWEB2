<x-admin-layout>
    <h1 class="text-2xl font-bold mb-6">Tambah Lapangan</h1>

    <div class="bg-white rounded shadow p-6 max-w-xl">
        <form method="POST" action="{{ route('admin.fields.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @include('admin.fields._form')
            <button class="bg-emerald-600 text-white px-5 py-2 rounded">Simpan</button>
        </form>
    </div>
</x-admin-layout>
