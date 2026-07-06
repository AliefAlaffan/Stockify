<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Supplier</h2>
    </x-slot>

    <div class="py-6 max-w-lg mx-auto">
        <form action="{{ route('suppliers.store') }}" method="POST" class="bg-white p-6 rounded shadow-sm space-y-4">
            @csrf
            <div>
                <label class="block mb-1">Nama</label>
                <input type="text" name="name" class="w-full border rounded p-2" value="{{ old('name') }}">
                @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block mb-1">Alamat</label>
                <textarea name="address" class="w-full border rounded p-2">{{ old('address') }}</textarea>
            </div>
            <div>
                <label class="block mb-1">Telepon</label>
                <input type="text" name="phone" class="w-full border rounded p-2" value="{{ old('phone') }}">
            </div>
            <div>
                <label class="block mb-1">Email</label>
                <input type="email" name="email" class="w-full border rounded p-2" value="{{ old('email') }}">
                @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
        </form>
    </div>
</x-app-layout>