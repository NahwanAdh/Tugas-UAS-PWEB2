@php $field = $field ?? null; @endphp

<div>
    <label class="block text-sm font-medium text-gray-700">Nama Lapangan</label>
    <input type="text" name="name" value="{{ old('name', $field->name ?? '') }}" required class="w-full rounded border-gray-300">
    @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
    <textarea name="description" rows="3" class="w-full rounded border-gray-300">{{ old('description', $field->description ?? '') }}</textarea>
    @error('description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Harga per Jam (Rp)</label>
    <input type="number" step="0.01" name="price_per_hour" value="{{ old('price_per_hour', $field->price_per_hour ?? '') }}" required class="w-full rounded border-gray-300">
    @error('price_per_hour') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Foto</label>
    <input type="file" name="photo" accept="image/*" class="w-full">
    @if (!empty($field?->photo))
        <img src="{{ asset('storage/' . $field->photo) }}" class="h-20 mt-2 rounded">
    @endif
    @error('photo') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div class="flex items-center gap-2">
    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $field->is_active ?? true) ? 'checked' : '' }}>
    <label for="is_active" class="text-sm text-gray-700">Aktif (tampil ke user)</label>
</div>
