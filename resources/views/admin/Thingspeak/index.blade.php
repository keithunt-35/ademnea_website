@extends('layouts.app')

@section('content')

@include('datanavbar')

<div class="flex flex-col space-y-60"> <!-- Increased from space-y-6 to space-y-12 -->
    <div class="chart-container">
        <h2 class="text-2xl font-semibold mb-4">VOLTAGE CHARTS</h2>
        <canvas id="voltageChart"></canvas>
    </div>
    <div class="chart-container">
        <h2 class="text-2xl font-semibold mb-4">BATTERY(%) CHARTS</h2>
        <canvas id="batteryChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const voltageCtx = document.getElementById('voltageChart').getContext('2d');
    const batteryCtx = document.getElementById('batteryChart').getContext('2d');
    const initialFeeds = {!! json_encode($battery_readings, JSON_HEX_TAG) !!};

    const hiveId = {{ $hive->id }};

    console.log('Initial feeds:', initialFeeds);

    // Process data for charts
    const timestamps = initialFeeds.map(feed => new Date(feed.reading_time).toLocaleTimeString());
    const voltageData = initialFeeds.map(feed => parseFloat(feed.voltage));
    const batteryData = initialFeeds.map(feed => parseFloat(feed.battery_percentage));

    // Create initial charts
    const voltageChart = new Chart(voltageCtx, {
        type: 'line',
        data: {
            labels: timestamps,
            datasets: [{
                label: 'Voltage (V)',
                data: voltageData,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Voltage Monitoring',
                    font: {
                        size: 20
                    }
                }
            }
        }
    });

    const batteryChart = new Chart(batteryCtx, {
        type: 'line',
        data: {
            labels: timestamps,
            datasets: [{
                label: 'Battery (%)',
                data: batteryData,
                borderColor: 'rgb(255, 99, 132)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Battery Level Monitoring',
                    font: {
                        size: 20
                    }
                }
            },
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
        height: 550px;
        width: 90%;
    }
</style>
@endsection
