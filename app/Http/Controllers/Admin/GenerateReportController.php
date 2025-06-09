<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class GenerateReportController extends Controller
{
    public function generateLocalReport(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer|between:2022,2025',
            'hive_id' => 'required|string|regex:/^[a-zA-Z0-9_-]+$/',
        ]);

        $month = $request->input('month');
        $year = $request->input('year');
        $hive_id = $request->input('hive_id');

        // Define paths
        $pythonScriptPath = storage_path('app/python_scripts/main.py');
        $outputDir = storage_path('app/public/reports');
        $csvDir = storage_path('app/csv');

        // CSV file paths (assumed naming convention)
        $co2File = "{$csvDir}/hive_carbondioxide_{$hive_id}.csv";
        $weightFile = "{$csvDir}/hive_weights_{$hive_id}.csv";
        $tempFile = "{$csvDir}/hive_temperatures_{$hive_id}.csv";
        $humidityFile = "{$csvDir}/hive_humidity_{$hive_id}.csv";

        // Verify CSV files exist
        $requiredFiles = [$co2File, $weightFile, $tempFile, $humidityFile];
        foreach ($requiredFiles as $file) {
            if (!file_exists($file)) {
                return response()->json([
                    'success' => false,
                    'message' => "CSV file not found: " . basename($file)
                ], 400);
            }
        }

        // Ensure output directory exists
        Storage::makeDirectory('public/reports');

        // Execute the Python script
        $process = new Process([
            'python3', // Adjust to 'python' if needed
            $pythonScriptPath,
            $co2File,
            $weightFile,
            $tempFile,
            $humidityFile,
            $year,
            $month,
            $hive_id,
            $outputDir
        ]);

        $process->setTimeout(120); // Increased timeout for complex processing
        try {
            $process->run();

            // Check if the process was successful
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            // Verify PDF exists
           $monthStr = str_pad($month, 2, '0', STR_PAD_LEFT);
            $pdfFile = "public/reports/Monthly_Report_{$hive_id}_{$year}_{$monthStr}.pdf";

            if (!Storage::exists($pdfFile)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to generate PDF report'
                ], 500);
            }

            // List of expected plots
            $plots = [
                'co2_monthly_trend.png',
                'co2_diurnal_variation.png',
                'weight_monthly_trend.png',
                'temperature_trend.png',
                'humidity_trend.png',
                'combined_trends.png',
                'correlation_heatmap.png'
            ];

            // Filter existing plots
            $plotUrls = [];
            foreach ($plots as $plot) {
                $plotPath = "public/reports/{$plot}";
                if (Storage::exists($plotPath)) {
                    $plotUrls[] = Storage::url($plotPath);
                }
            }

            return response()->json([
                'success' => true,
                'download_url' => Storage::url($pdfFile),
                'plots' => $plotUrls
            ]);

        } catch (ProcessFailedException $e) {
            \Log::error('Python script execution failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Report generation failed: ' . $e->getMessage()
            ], 500);
        }
    }
}