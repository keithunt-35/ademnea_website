@extends('layouts.app')

@section('content')

@include('datanavbar')

<div class="flex flex-col space-y-4"> <!-- Changed to column layout for hierarchy -->
    <!-- Hive ID Display -->
    <div class="bg-white p-4 rounded-lg shadow">
        <h2 class="text-2xl font-bold text-gray-800">
            Hive ID: <span class="text-blue-600">{{ $hive_id }}</span>
        </h2>
    </div>

    <!-- Charts Row -->
    <div class="flex flex-row space-x-8">
        <div class="chart-container flex-1">
            <h2 class="text-xl font-semibold mb-2">VOLTAGE (V)</h2>
            <canvas id="voltageChart"></canvas>
        </div>
        <div class="chart-container flex-1">
            <h2 class="text-xl font-semibold mb-2">BATTERY (%)</h2>
            <canvas id="batteryChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const voltageCtx = document.getElementById('voltageChart').getContext('2d');
    const batteryCtx = document.getElementById('batteryChart').getContext('2d');
    const initialFeeds = {!! json_encode($battery_readings, JSON_HEX_TAG) !!};

    console.log('Initial feeds:', initialFeeds);

    // Process data for charts
    const timestamps = initialFeeds.map(feed => new Date(feed.reading_time).toLocaleTimeString());
    const voltageData = initialFeeds.map(feed => parseFloat(feed.voltage));
    const batteryData = initialFeeds.map(feed => parseFloat(feed.battery_percentage));

    // Common chart options
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false, // Allows custom sizing
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: false // We moved title to HTML heading
            }
        }
    };

    // Create charts
    new Chart(voltageCtx, {
        type: 'line',
        data: {
            labels: timestamps,
            datasets: [{
                label: 'Voltage',
                data: voltageData,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            ...chartOptions,
            scales: {
                y: {
                    beginAtZero: false
                }
            }
        }
    });

    new Chart(batteryCtx, {
        type: 'line',
        data: {
            labels: timestamps,
            datasets: [{
                label: 'Battery',
                data: batteryData,
                borderColor: 'rgb(255, 99, 132)',
                tension: 0.1
            }]
        },
        options: {
            ...chartOptions,
            scales: {
                y: {
                    min: 0,
                    max: 100
                }
            }
        }
    });
});
</script>

<style>
    .chart-container {
        position: relative;
        height: 400px; /* Reduced height */
        width: 100%; /* Takes full width of flex container */
        padding: 1rem;
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    /* Responsive adjustment */
    @media (max-width: 768px) {
        .flex-row {
            flex-direction: column;
        }
        .chart-container {
            margin-bottom: 1rem;
        }
    }
</style>
@endsection