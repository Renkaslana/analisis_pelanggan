@extends('layouts.dashboard')

@section('title', 'Edit Hasil Analisis')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <h2 class="text-2xl font-bold text-dark mb-6">Edit Hasil Analisis</h2>

    <form action="{{ route('sentiments.update', $sentiment->id) }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="text" class="block text-sm font-medium text-gray-700 mb-1">Teks</label>
            <textarea name="text" id="text" rows="4" class="w-full border border-gray-300 rounded-md p-2" required>{{ old('text', $sentiment->text) }}</textarea>
            @error('text')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="sentiment" class="block text-sm font-medium text-gray-700 mb-1">Hasil Sentimen</label>
            <select name="sentiment" id="sentiment" class="w-full border border-gray-300 rounded-md p-2" required>
                <option value="positive" {{ $sentiment->sentiment === 'positive' ? 'selected' : '' }}>Positif</option>
                <option value="neutral" {{ $sentiment->sentiment === 'neutral' ? 'selected' : '' }}>Netral</option>
                <option value="negative" {{ $sentiment->sentiment === 'negative' ? 'selected' : '' }}>Negatif</option>
            </select>
            @error('sentiment')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="probability" class="block text-sm font-medium text-gray-700 mb-1">Probabilitas</label>
            <input type="number" name="probability" id="probability" step="0.01" min="0" max="1" class="w-full border border-gray-300 rounded-md p-2" value="{{ old('probability', $sentiment->probability) }}" required>
            @error('probability')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded hover:bg-opacity-90 transition">Simpan Perubahan</button>
            <a href="{{ route('sentiments.history') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">Batal</a>
        </div>
    </form>
</div>
@endsection
