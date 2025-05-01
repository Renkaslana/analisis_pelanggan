@extends('layouts.app')

@section('title', 'Beranda - SuaraPelanggan')

@section('content')

<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-primary to-indigo-600 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-8 items-center">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-4">Tingkatkan Kepuasan Pelanggan Anda</h1>
                <p class="text-xl mb-8">Dengan analisis prediktif untuk memahami kebutuhan pelanggan secara mendalam.</p>
                <div class="flex space-x-4">
                    <a href="{{ route('register') }}"
                        class="px-6 py-3 bg-white text-primary rounded-lg font-medium hover:bg-opacity-90 transition">Mulai Sekarang</a>
                    <a href="#features"
                        class="px-6 py-3 border-2 border-white text-white rounded-lg font-medium hover:bg-white hover:bg-opacity-10 transition">Pelajari Lebih Lanjut</a>
                </div>
            </div>
            <div class="hidden md:block">
                <img src="https://illustrations.popsy.co/amber/digital-nomad.svg" alt="Customer Satisfaction"
                    class="w-full h-auto">
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-dark mb-4">Solusi Analisis Kepuasan Pelanggan</h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">Sistem kami membantu perusahaan jasa menganalisis dan memprediksi tingkat kepuasan pelanggan berdasarkan ulasan dan feedback mereka.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-gray-50 p-8 rounded-xl hover:shadow-lg transition">
                <div class="w-14 h-14 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-dark mb-3">Analisis Sentimen</h3>
                <p class="text-gray-600">Menganalisis ulasan pelanggan menggunakan Text Mining & Naïve Bayes untuk menentukan apakah ulasan positif, negatif, atau netral.</p>
            </div>
            <!-- Feature 2 -->
            <div class="bg-gray-50 p-8 rounded-xl hover:shadow-lg transition">
                <div class="w-14 h-14 bg-secondary bg-opacity-10 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-secondary" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-dark mb-3">Pohon Keputusan (C4.5)</h3>
                <p class="text-gray-600">Memprediksi faktor utama yang memengaruhi kepuasan pelanggan dengan algoritma Decision Tree C4.5.</p>
            </div>
            <!-- Feature 3 -->
            <div class="bg-gray-50 p-8 rounded-xl hover:shadow-lg transition">
                <div class="w-14 h-14 bg-purple-500 bg-opacity-10 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-purple-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-dark mb-3">K-Means Clustering</h3>
                <p class="text-gray-600">Mengelompokkan pelanggan berdasarkan tingkat kepuasan dan memberikan rekomendasi layanan yang lebih baik.</p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-dark mb-4">Bagaimana Sistem Ini Bekerja?</h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">Proses sederhana untuk mendapatkan wawasan mendalam tentang kepuasan pelanggan.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Step 1 -->
            <div class="text-center">
                <div class="w-20 h-20 bg-primary text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6">1</div>
                <h3 class="text-xl font-semibold text-dark mb-3">Masukkan Data</h3>
                <p class="text-gray-600">Unggah data ulasan pelanggan Anda atau masukkan secara manual melalui antarmuka yang mudah digunakan.</p>
            </div>
            <!-- Step 2 -->
            <div class="text-center">
                <div class="w-20 h-20 bg-primary text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6">2</div>
                <h3 class="text-xl font-semibold text-dark mb-3">Analisis Otomatis</h3>
                <p class="text-gray-600">Sistem akan menganalisis data menggunakan algoritma canggih untuk mengidentifikasi pola dan sentimen.</p>
            </div>
            <!-- Step 3 -->
            <div class="text-center">
                <div class="w-20 h-20 bg-primary text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6">3</div>
                <h3 class="text-xl font-semibold text-dark mb-3">Dapatkan Insight</h3>
                <p class="text-gray-600">Lihat hasil analisis dalam dashboard intuitif dengan visualisasi data yang mudah dipahami.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-primary text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-6">Siap Meningkatkan Kepuasan Pelanggan Anda?</h2>
        <p class="text-xl mb-8 max-w-3xl mx-auto">Daftar sekarang dan mulai dapatkan wawasan berharga dari feedback pelanggan Anda.</p>
        <a href="{{ route('register') }}" class="px-8 py-3 bg-white text-primary rounded-lg font-medium hover:bg-opacity-90 transition inline-block">Daftar Gratis</a>
    </div>
</section>

@endsection
