@extends('layouts.dashboard')

@section('title', 'Dashboard - Sentimen Analysis')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h2 class="text-2xl font-bold text-dark mb-6">Ringkasan Analisis</h2>

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <h3 class="text-gray-500 text-sm uppercase tracking-wide">Positif</h3>
            <p class="mt-2 text-3xl font-bold text-green-500">{{ $sentimentCounts['positive'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <h3 class="text-gray-500 text-sm uppercase tracking-wide">Netral</h3>
            <p class="mt-2 text-3xl font-bold text-blue-500">{{ $sentimentCounts['neutral'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <h3 class="text-gray-500 text-sm uppercase tracking-wide">Negatif</h3>
            <p class="mt-2 text-3xl font-bold text-red-500">{{ $sentimentCounts['negative'] }}</p>
        </div>
    </div>

    <!-- Tabel Riwayat -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="font-semibold text-lg text-dark">Riwayat Terbaru</h3>
            <a href="{{ route('sentiments.history') }}" class="text-primary hover:underline">Lihat Semua</a>
        </div>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teks</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sentimen</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Probabilitas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($sentiments as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm truncate max-w-xs" title="{{ $item->text }}">
                        {{ Str::limit($item->text, 50) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="
                            inline-flex px-2 py-1 text-xs font-semibold rounded-full
                            @if($item->sentiment == 'positive') bg-green-100 text-green-800
                            @elseif($item->sentiment == 'negative') bg-red-100 text-red-800
                            @else bg-blue-100 text-blue-800
                            @endif">
                            {{ ucfirst($item->sentiment) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ number_format($item->probability * 100, 2) }}%
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-2">
                        <a href="{{ route('sentiments.edit', $item->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                        <form action="{{ route('sentiments.destroy', $item->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada data analisis.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
