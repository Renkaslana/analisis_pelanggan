<?php

namespace App\Http\Controllers;

use App\Models\Sentiment;
use App\Services\SentimentAnalyzer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SentimentController extends Controller
{
    protected $sentimentAnalyzer;

    public function __construct(SentimentAnalyzer $sentimentAnalyzer)
    {
        $this->middleware('auth');
        $this->sentimentAnalyzer = $sentimentAnalyzer;
    }

    public function index()
    {
        $sentiments = Sentiment::where('user_id', Auth::id())->latest()->get();

        // Calculate sentiment counts
        $sentimentCounts = [
            'positive' => $sentiments->where('sentiment', 'positive')->count(),
            'neutral' => $sentiments->where('sentiment', 'neutral')->count(),
            'negative' => $sentiments->where('sentiment', 'negative')->count(),
        ];

        return view('sentiments.index', compact('sentiments', 'sentimentCounts'));
    }

    public function analyze(Request $request)
    {
        // Validasi teks atau file
        $validator = Validator::make($request->all(), [
            'text' => 'nullable|string|min:3',
            'file' => 'nullable|file|mimes:csv,json',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $results = [];

        // Jika file diunggah
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();

            if ($extension === 'csv') {
                $handle = fopen($file->getPathname(), 'r');
                $header = fgetcsv($handle);
                $textIndex = array_search('text', $header);
                $sentimentIndex = array_search('sentiment', $header);
                $probabilityIndex = array_search('probability', $header);

                while (($data = fgetcsv($handle)) !== false) {
                    if (!isset($data[$textIndex])) continue;

                    $text = trim($data[$textIndex]);
                    $sentiment = $data[$sentimentIndex] ?? null;
                    $probability = $data[$probabilityIndex] ?? 0.8;

                    // Normalisasi sentimen
                    $mappedSentiment = $this->mapSentiment($sentiment);

                    $result = $this->sentimentAnalyzer->analyzeText($text, $mappedSentiment, floatval($probability));

                    $results[] = $result;

                    Sentiment::create([
                        'user_id' => Auth::id(),
                        'text' => $text,
                        'sentiment' => $result['sentiment'],
                        'probability' => $result['probability']
                    ]);
                }
                fclose($handle);
            } elseif ($extension === 'json') {
                $jsonData = json_decode(file_get_contents($file->getPathname()), true);
                foreach ($jsonData as $item) {
                    $text = trim($item['text'] ?? '');
                    if (!$text) continue;

                    $sentiment = $item['sentiment'] ?? null;
                    $probability = $item['probability'] ?? 0.8;

                    $mappedSentiment = $this->mapSentiment($sentiment);

                    $result = $this->sentimentAnalyzer->analyzeText($text, $mappedSentiment, floatval($probability));
                    $results[] = $result;

                    Sentiment::create([
                        'user_id' => Auth::id(),
                        'text' => $text,
                        'sentiment' => $result['sentiment'],
                        'probability' => $result['probability']
                    ]);
                }
            }
        }

        // Teks manual
        if ($request->filled('text')) {
            $text = $request->input('text');
            $result = $this->sentimentAnalyzer->analyzeText($text);
            $results[] = $result;

            Sentiment::create([
                'user_id' => Auth::id(),
                'text' => $text,
                'sentiment' => $result['sentiment'],
                'probability' => $result['probability']
            ]);
        }

        if (count($results) === 1) {
            return redirect()->route('sentiments.index')->with('result', $results[0]);
        } else {
            return redirect()->route('sentiments.index')->with('results', $results);
        }
    }

    // Fungsi normalisasi sentimen
    private function mapSentiment(?string $sentiment): string
    {
        if (!$sentiment) return 'neutral';

        $lowerSentiment = strtolower(trim($sentiment));
        if (in_array($lowerSentiment, ['positive', 'positif', 'puas'])) {
            return 'positive';
        } elseif (in_array($lowerSentiment, ['negative', 'negatif', 'tidak puas'])) {
            return 'negative';
        } else {
            return 'neutral';
        }
    }

    public function analyzeText(string $text, ?string $givenSentiment = null, float $givenProbability = 0.8): array
    {
        if ($givenSentiment) {
            // Gunakan sentimen yang sudah disediakan
            return [
                'text' => $text,
                'sentiment' => $givenSentiment,
                'probability' => $givenProbability
            ];
        }

        // Jika tidak ada sentimen, lakukan prediksi otomatis
        // Misalnya menggunakan model AI atau rule-based
        // Contoh dummy:
        $sentiment = 'positive'; // Ganti dengan logic sebenarnya
        $probability = 0.95; // Ganti dengan probabilitas sebenarnya

        return [
            'text' => $text,
            'sentiment' => $sentiment,
            'probability' => $probability
        ];
    }

    public function dashboard()
    {
        $sentiments = Sentiment::where('user_id', Auth::id())->latest()->get();

        // Calculate sentiment counts
        $sentimentCounts = [
            'positive' => $sentiments->where('sentiment', 'positive')->count(),
            'neutral' => $sentiments->where('sentiment', 'neutral')->count(),
            'negative' => $sentiments->where('sentiment', 'negative')->count(),
        ];

        return view('sentiments.dashboard', compact('sentiments', 'sentimentCounts'));
    }

    public function history()
    {
        $sentiments = Sentiment::where('user_id', Auth::id())->latest()->get();
        return view('sentiments.history', compact('sentiments'));
    }

    public function edit($id)
    {
        $sentiment = Sentiment::where('user_id', Auth::id())->findOrFail($id);
        return view('sentiments.edit', compact('sentiment'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required|string|min:3',
            'sentiment' => 'required|in:positive,negative,neutral',
            'probability' => 'required|numeric|min:0|max:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $sentiment = Sentiment::where('user_id', Auth::id())->findOrFail($id);
        $sentiment->text = $request->input('text');
        $sentiment->sentiment = $request->input('sentiment');
        $sentiment->probability = $request->input('probability');
        $sentiment->save();

        return redirect()->route('sentiments.history')->with('success', 'Sentiment updated successfully');
    }

    public function destroy($id)
    {
        $sentiment = Sentiment::where('user_id', Auth::id())->findOrFail($id);
        $sentiment->delete();

        return redirect()->route('sentiments.history')->with('success', 'Sentiment deleted successfully');
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:csv,json',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        $success = 0;
        $failed = 0;

        if ($extension === 'csv') {
            // Process CSV file
            $handle = fopen($file->getPathname(), 'r');
            $header = fgetcsv($handle);

            // Validate headers
            $requiredColumns = ['text', 'sentiment'];
            $missingColumns = array_diff($requiredColumns, $header);

            if (!empty($missingColumns)) {
                return redirect()->back()->with('error', 'Invalid CSV file. Missing required columns: ' . implode(', ', $missingColumns));
            }

            $textIndex = array_search('text', $header);
            $sentimentIndex = array_search('sentiment', $header);
            $probabilityIndex = array_search('probability', $header);

            while (($data = fgetcsv($handle)) !== false) {
                try {
                    if (count($data) < max($textIndex, $sentimentIndex) + 1) {
                        $failed++;
                        continue;
                    }

                    $text = trim($data[$textIndex]);
                    $sentiment = strtolower(trim($data[$sentimentIndex]));

                    // Normalize sentiment value
                    if (in_array($sentiment, ['positive', 'positif', 'puas'])) {
                        $sentiment = 'positive';
                    } elseif (in_array($sentiment, ['negative', 'negatif', 'tidak puas'])) {
                        $sentiment = 'negative';
                    } else {
                        $sentiment = 'neutral';
                    }

                    // Get probability if available, otherwise use default
                    $probability = 0.8;
                    if ($probabilityIndex !== false && isset($data[$probabilityIndex])) {
                        $probValue = floatval($data[$probabilityIndex]);
                        if ($probValue >= 0 && $probValue <= 1) {
                            $probability = $probValue;
                        }
                    }

                    // Add to database with user_id
                    Sentiment::create([
                        'user_id' => Auth::id(),
                        'text' => $text,
                        'sentiment' => $sentiment,
                        'probability' => $probability,
                    ]);

                    $success++;
                } catch (\Exception $e) {
                    $failed++;
                }
            }

            fclose($handle);
        } elseif ($extension === 'json') {
            // Process JSON file
            $jsonData = json_decode(file_get_contents($file->getPathname()), true);

            if (!is_array($jsonData)) {
                return redirect()->back()->with('error', 'Invalid JSON file. Data must be an array.');
            }

            foreach ($jsonData as $item) {
                try {
                    if (!isset($item['text']) || !is_string($item['text'])) {
                        $failed++;
                        continue;
                    }

                    $sentiment = strtolower($item['sentiment'] ?? 'neutral');

                    // Normalize sentiment value
                    if (in_array($sentiment, ['positive', 'positif', 'puas'])) {
                        $sentiment = 'positive';
                    } elseif (in_array($sentiment, ['negative', 'negatif', 'tidak puas'])) {
                        $sentiment = 'negative';
                    } else {
                        $sentiment = 'neutral';
                    }

                    // Get probability if available, otherwise use default
                    $probability = 0.8;
                    if (isset($item['probability'])) {
                        $probValue = floatval($item['probability']);
                        if ($probValue >= 0 && $probValue <= 1) {
                            $probability = $probValue;
                        }
                    }

                    // Add to database with user_id
                    Sentiment::create([
                        'user_id' => Auth::id(),
                        'text' => $item['text'],
                        'sentiment' => $sentiment,
                        'probability' => $probability,
                    ]);

                    $success++;
                } catch (\Exception $e) {
                    $failed++;
                }
            }
        }

        return redirect()->route('sentiments.history')->with('import_stats', [
            'total' => $success + $failed,
            'success' => $success,
            'failed' => $failed,
        ]);
    }

    public function export()
    {
        $sentiments = Sentiment::where('user_id', Auth::id())->get();
        $filename = 'sentiment-data-' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($sentiments) {
            $file = fopen('php://output', 'w');

            // Add headers
            fputcsv($file, ['id', 'text', 'sentiment', 'probability', 'created_at']);

            // Add data
            foreach ($sentiments as $sentiment) {
                fputcsv($file, [
                    $sentiment->id,
                    $sentiment->text,
                    $sentiment->sentiment,
                    $sentiment->probability,
                    $sentiment->created_at,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function print()
    {
        $sentiments = Sentiment::where('user_id', Auth::id())->latest()->get();

        // Calculate sentiment counts
        $sentimentCounts = [
            'positive' => $sentiments->where('sentiment', 'positive')->count(),
            'neutral' => $sentiments->where('sentiment', 'neutral')->count(),
            'negative' => $sentiments->where('sentiment', 'negative')->count(),
        ];

        return view('sentiments.print', compact('sentiments', 'sentimentCounts'));
    }
}
