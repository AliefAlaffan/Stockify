@php use Illuminate\Support\Facades\Storage; @endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Kategori</h2>
    </x-slot>

    <div class="py-6 max-w-lg mx-auto">
        <form action="{{ route('categories.update', $category->id) }}" method="POST" class="bg-white p-6 rounded shadow-sm space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block mb-1">Nama</label>
                <input type="text" name="name" class="w-full border rounded p-2" value="{{ old('name', $category->name) }}">
                @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block mb-1">Deskripsi</label>
                <textarea name="description" class="w-full border rounded p-2">{{ old('description', $category->description) }}</textarea>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
        </form>
    </div>
</x-app-layout>