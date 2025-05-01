@extends('layouts.dashboard')

@section('title', 'Cetak Laporan Analisis')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-dark">Laporan Hasil Analisis</h2>
            <button onclick="window.print()" class="px-4 py-2 bg-secondary text-white rounded hover:bg-opacity-90 transition">Cetak</button>
        </div>

        <table class="min-w-full divide-y divide-gray-200 border">
            <thead class="bg-gray-50">
                <tr>
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">Teks</th>
                    <th class="border px-4 py-2">Sentimen</th>
                    <th class="border px-4 py-2">Probabilitas</th>
                    <th class="border px-4 py-2">Tanggal</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($sentiments as $index => $item)
                <tr>
                    <td class="border px-4 py-2 text-center">{{ $index + 1 }}</td>
                    <td class="border px-4 py-2">{{ $item->text }}</td>
                    <td class="border px-4 py-2 text-center capitalize">{{ $item->sentiment }}</td>
                    <td class="border px-4 py-2 text-center">{{ number_format($item->probability * 100, 2) }}%</td>
                    <td class="border px-4 py-2 text-center">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
