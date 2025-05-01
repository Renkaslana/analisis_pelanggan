{{-- resources/views/sentiments/partials/stats-cards.blade.php --}}

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <!-- Positif Card -->
    <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl shadow border border-green-100">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-medium text-gray-700">Positif</h3>
                <p class="mt-2 text-3xl font-bold text-green-600">{{ $sentimentCounts['positive'] }}</p>
            </div>
            <div class="bg-green-100 p-3 rounded-full">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                </svg>
            </div>
        </div>
        <p class="text-sm text-green-700 mt-3">
            {{ $sentimentCounts['positive'] > 0 ? round($sentimentCounts['positive'] / $sentiments->count() * 100, 2) : 0 }}% dari total
        </p>
    </div>

    <!-- Netral Card -->
    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl shadow border border-blue-100">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-medium text-gray-700">Netral</h3>
                <p class="mt-2 text-3xl font-bold text-blue-600">{{ $sentimentCounts['neutral'] }}</p>
            </div>
            <div class="bg-blue-100 p-3 rounded-full">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17V3m0 14a2 2 0 002 2h2a2 2 0 002-2V7m0 10l4-4m0 0l4-4m-4 4l-4-4m4 4V3"></path>
                </svg>
            </div>
        </div>
        <p class="text-sm text-blue-700 mt-3">
            {{ $sentimentCounts['neutral'] > 0 ? round($sentimentCounts['neutral'] / $sentiments->count() * 100, 2) : 0 }}% dari total
        </p>
    </div>

    <!-- Negatif Card -->
    <div class="bg-gradient-to-br from-red-50 to-red-100 p-6 rounded-xl shadow border border-red-100">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-medium text-gray-700">Negatif</h3>
                <p class="mt-2 text-3xl font-bold text-red-600">{{ $sentimentCounts['negative'] }}</p>
            </div>
            <div class="bg-red-100 p-3 rounded-full">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 14H5m0 6h14M5 10h14M5 6h14"></path>
                </svg>
            </div>
        </div>
        <p class="text-sm text-red-700 mt-3">
            {{ $sentimentCounts['negative'] > 0 ? round($sentimentCounts['negative'] / $sentiments->count() * 100, 2) : 0 }}% dari total
        </p>
    </div>
</div>
