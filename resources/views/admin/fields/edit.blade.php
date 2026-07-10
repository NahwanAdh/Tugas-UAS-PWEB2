<x-admin-layout>
    <h1 class="text-2xl font-bold mb-6">Edit Lapangan</h1>

    <div class="bg-white rounded shadow p-6 max-w-xl">
        <form method="POST" action="{{ route('admin.fields.update', $field) }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
            @include('admin.fields._form')
            <button class="bg-emerald-600 text-white px-5 py-2 rounded">Update</button>
        </form>
    </div>
</x-admin-layout>
