<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FieldController extends Controller
{
    public function index()
    {
        $fields = Field::orderBy('name')->paginate(10);
        return view('admin.fields.index', compact('fields'));
    }

    public function create()
    {
        return view('admin.fields.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateField($request);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('fields', 'public');
        }

        Field::create($validated);

        return redirect()->route('admin.fields.index')->with('success', 'Lapangan berhasil ditambahkan.');
    }

    public function edit(Field $field)
    {
        return view('admin.fields.edit', compact('field'));
    }

    public function update(Request $request, Field $field)
    {
        $validated = $this->validateField($request, $field->id);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('photo')) {
            if ($field->photo) {
                Storage::disk('public')->delete($field->photo);
            }
            $validated['photo'] = $request->file('photo')->store('fields', 'public');
        }

        $field->update($validated);

        return redirect()->route('admin.fields.index')->with('success', 'Lapangan berhasil diperbarui.');
    }

    public function destroy(Field $field)
    {
        if ($field->photo) {
            Storage::disk('public')->delete($field->photo);
        }
        $field->delete();

        return redirect()->route('admin.fields.index')->with('success', 'Lapangan berhasil dihapus.');
    }

    private function validateField(Request $request, $ignoreId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'price_per_hour' => ['required', 'numeric', 'min:0'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }
}
