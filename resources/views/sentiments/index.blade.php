{{-- resources/views/sentiments/index.blade.php --}}

@extends('layouts.dashboard')
@section('title', 'Beranda - Dashboard')
@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Section -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Selamat Datang di Dashboard Analisis Sentimen</h2>
            <p class="text-gray-600 mt-2">Kelola analisis teks dan pantau kepuasan pelanggan secara real-time.</p>
        </div>

        <!-- Stats Cards -->
        @include('sentiments.partials.stats-cards', compact('sentimentCounts', 'sentiments'))

        <!-- Chart Section -->
        <div class="mb-10 bg-white p-6 rounded-lg shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-dark">Visualisasi Data Sentimen</h3>
                <div class="flex space-x-2">
                    <button id="pieChartBtn"
                        class="px-3 py-1 bg-blue-100 text-blue-700 rounded-md text-sm font-medium chart-type-btn active"
                        data-type="pie">
                        Pie Chart
                    </button>
                    <button id="barChartBtn"
                        class="px-3 py-1 bg-gray-100 text-gray-700 rounded-md text-sm font-medium chart-type-btn"
                        data-type="bar">
                        Bar Chart
                    </button>
                    <button id="lineChartBtn"
                        class="px-3 py-1 bg-gray-100 text-gray-700 rounded-md text-sm font-medium chart-type-btn"
                        data-type="line">
                        Line Chart
                    </button>
                </div>
            </div>
            <div class="chart-container relative" style="height: 400px;">
                <canvas id="sentimentChart"></canvas>
            </div>

            <!-- Date Range Filter -->
            <div class="mt-6 flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                <div class="w-full sm:w-1/3">
                    <label for="dateRange" class="block text-sm font-medium text-gray-700 mb-1">Rentang Waktu</label>
                    <select id="dateRange"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">Semua Data</option>
                        <option value="today">Hari Ini</option>
                        <option value="week">Minggu Ini</option>
                        <option value="month">Bulan Ini</option>
                        <option value="year">Tahun Ini</option>
                        <option value="custom">Custom</option>
                    </select>
                </div>
                <div id="customDateRange" class="hidden w-full sm:flex space-x-4">
                    <div class="w-1/2">
                        <label for="startDate" class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                        <input type="date" id="startDate"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="w-1/2">
                        <label for="endDate" class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                        <input type="date" id="endDate"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>
        </div>

        <!-- Notification Section -->
        @if (session('error'))
            <x-alert type="danger">{{ session('error') }}</x-alert>
        @endif

        @if (session('result'))
            <div class="mt-6 rounded-md bg-green-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">Hasil Analisis</h3>
                        <div class="mt-2 text-sm text-green-700">
                            @if (session('source') == 'manual')
                                <p>Dianalisis dari teks yang dimasukkan secara manual.</p>
                            @else
                                <p>Dianalisis dari file CSV/JSON yang diunggah.</p>
                            @endif
                            <p>
                                Sentimen: <strong>{{ ucfirst(session('result')['sentiment']) }}</strong> |
                                Probabilitas: {{ round(session('result')['probability'] * 100, 2) }}%
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (session('results'))
            <div class="mt-6 rounded-md bg-green-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">Analisis Batch Selesai</h3>
                        <div class="mt-2 text-sm text-green-700">
                            <p>Berhasil menganalisis {{ count(session('results')) }} data.</p>
                            <p>
                                @if (count(session('results')) > 1)
                                    Input ini berasal dari file CSV/JSON.
                                @else
                                    Input ini berasal dari teks manual.
                                @endif
                            </p>
                            <a href="{{ route('sentiments.history') }}"
                                class="mt-2 inline-flex items-center text-green-600 hover:underline">
                                Lihat detail di riwayat
                                <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Upload Form -->
        <div class="mt-10 bg-white rounded-lg shadow-md p-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Lakukan Analisis Baru</h3>
            <form action="{{ route('sentiments.analyze') }}" method="POST" enctype="multipart/form-data" id="analyzeForm"
                class="space-y-6">
                @csrf
                <!-- Text Input -->
                <div>
                    <label for="text" class="block text-sm font-medium text-gray-700 mb-1">Masukkan Ulasan atau
                        Teks</label>
                    <textarea name="text" id="text" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                        placeholder="Contoh: Saya sangat puas dengan layanan ini..."></textarea>
                </div>
                <!-- Divider -->
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">ATAU</span>
                    </div>
                </div>
                <!-- File Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Unggah CSV / JSON</label>
                    <input type="file" name="file" accept=".csv,.json" id="fileInput"
                        class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded file:border-0
                        file:text-sm file:font-semibold
                        file:bg-primary file:text-white
                        hover:file:bg-opacity-90
                        focus:outline-none">
                    <p class="mt-1 text-xs text-gray-500">Ukuran maksimal 2MB</p>
                </div>

                <!-- Preview Section -->
                <div id="filePreview" class="mt-4 hidden">
                    <h4 class="text-lg font-medium text-gray-700">Pratinjau File:</h4>
                    <div class="bg-gray-100 p-4 rounded-md mt-2">
                        <p class="text-sm"><strong>Nama File:</strong> <span id="fileName"></span></p>
                        <p class="text-sm"><strong>Tipe File:</strong> <span id="fileType"></span></p>
                        <p class="text-sm"><strong>Jumlah Data:</strong> <span id="fileDataCount"></span></p>
                        <p class="text-sm"><strong>Konten:</strong></p>
                        <pre id="fileContent" class="overflow-auto max-h-48 p-2 bg-gray-200 rounded-md"></pre>
                    </div>
                </div>

                <!-- Error Message -->
                @if ($errors->any())
                    <div class="rounded bg-red-50 text-red-700 p-3 text-sm">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- Submit Button -->
                <div class="flex space-x-4">
                    <button type="submit"
                        class="px-6 py-2 bg-primary text-white rounded hover:bg-indigo-700 transition">Analisis</button>
                    <a href="{{ route('sentiments.history') }}"
                        class="px-6 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">Lihat Riwayat</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS untuk Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment"></script>
    <script>
        const sentimentData = {
            labels: ['Positif', 'Netral', 'Negatif'],
            datasets: [{
                label: 'Jumlah Sentimen',
                data: [
                    {{ $sentimentCounts['positive'] }},
                    {{ $sentimentCounts['neutral'] }},
                    {{ $sentimentCounts['negative'] }}
                ],
                backgroundColor: ['#10B981', '#6366F1', '#EF4444'],
                borderColor: ['#10B981', '#6366F1', '#EF4444'],
                borderWidth: 1
            }]
        };

        const timeSeriesData = {
            labels: {!! json_encode($groupedSentiments->keys()) !!},
            datasets: [{
                    label: 'Positif',
                    data: {!! json_encode($groupedSentiments->pluck('positive')->values()) !!},
                    backgroundColor: '#10B981'
                },
                {
                    label: 'Netral',
                    data: {!! json_encode($groupedSentiments->pluck('neutral')->values()) !!},
                    backgroundColor: '#6366F1'
                },
                {
                    label: 'Negatif',
                    data: {!! json_encode($groupedSentiments->pluck('negative')->values()) !!},
                    backgroundColor: '#EF4444'
                }
            ]
        };

        let chartType = 'pie';
        let currentChart = null;
        const ctx = document.getElementById('sentimentChart').getContext('2d');

        function renderChart(type) {
            if (currentChart) currentChart.destroy();
            // Buat ulang chart sesuai tipe
            if (type === 'pie' || type === 'doughnut') {
                currentChart = new Chart(ctx, {
                    type: type,
                    data: {
                        labels: sentimentData.labels,
                        datasets: [{
                            label: 'Jumlah',
                            data: sentimentData.data,
                            backgroundColor: sentimentData.backgroundColor,
                            hoverOffset: 10,
                            cutout: type === 'doughnut' ? '70%' : 0
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'right'
                            },
                            tooltip: {
                                callbacks: {
                                    label: context => `${context.label}: ${context.raw} data`
                                }
                            }
                        }
                    }
                });
            } else if (type === 'bar') {
                currentChart = new Chart(ctx, {
                    type: 'bar',
                    data: sentimentData,
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            } else if (type === 'line') {
                currentChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: timeSeriesData.labels,
                        datasets: timeSeriesData.datasets
                    },
                    options: {
                        responsive: true,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        scales: {
                            x: {
                                type: 'time',
                                time: {
                                    unit: 'day',
                                    tooltipFormat: 'YYYY-MM-DD'
                                },
                                title: {
                                    display: true,
                                    text: 'Tanggal'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                },
                                title: {
                                    display: true,
                                    text: 'Jumlah'
                                }
                            }
                        }
                    }
                });
            }
        }

        renderChart(chartType);

        document.querySelectorAll('.chart-type-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.chart-type-btn').forEach(b => {
                    b.classList.remove('active', 'bg-blue-100', 'text-blue-700');
                    b.classList.add('bg-gray-100', 'text-gray-700');
                });
                btn.classList.add('active', 'bg-blue-100', 'text-blue-700');
                btn.classList.remove('bg-gray-100', 'text-gray-700');
                chartType = btn.dataset.type;
                renderChart(chartType);
            });
        });

        document.getElementById('fileInput').addEventListener('change', function() {
            const file = this.files[0];
            if (!file) return;

            // Show preview section
            document.getElementById('filePreview').classList.remove('hidden');

            // Display file name and type
            document.getElementById('fileName').textContent = file.name;
            document.getElementById('fileType').textContent = file.type;

            // Read file content
            const reader = new FileReader();
            reader.onload = function(e) {
                const content = e.target.result;

                // Parse JSON if it's a JSON file
                if (file.type === 'application/json') {
                    try {
                        const jsonData = JSON.parse(content);
                        document.getElementById('fileContent').textContent = JSON.stringify(jsonData, null, 2);
                        document.getElementById('fileDataCount').textContent = `Total Data: ${jsonData.length}`;
                    } catch (error) {
                        alert('File JSON tidak valid.');
                        return;
                    }
                } else if (file.type === 'text/csv') {
                    // For CSV, show raw content
                    document.getElementById('fileContent').textContent = content;
                    // Count lines in CSV
                    const lines = content.split('\n').filter(line => line.trim() !== '');
                    document.getElementById('fileDataCount').textContent = `Jumlah Baris: ${lines.length}`;
                } else {
                    alert('Tipe file tidak didukung.');
                    return;
                }
            };
            reader.readAsText(file);
        });

        document.getElementById('dateRange').addEventListener('change', function() {
            const customRange = document.getElementById('customDateRange');
            if (this.value === 'custom') customRange.classList.remove('hidden');
            else customRange.classList.add('hidden');
        });
    </script>
@endpush
