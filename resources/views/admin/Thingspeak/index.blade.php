@extends('layouts.app')

@section('content')

@php
    $hive_id = session('hive_id');
@endphp


@include('datanavbar')



    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-semibold mb-4"> Hive {{ $hive_id }}</h2>

        <div class="flex flex-col space-y-6">
            <div class="chart-container ">
                <h2 class="text-2xl font-semibold mb-4"> VOLTAGE CHARTS</h2>
                <canvas id="voltageChart"></canvas>
            </div>
            <div class="chart-container ">
                <h2 class="text-2xl font-semibold mb-4"> BATTERY(%) CHARTS</h2>
                <canvas id="batteryChart"></canvas>
            </div>
        </div>
    </div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// creating a new chart instance
document.addEventListener('DOMContentLoaded', function() {
    const voltageCtx = document.getElementById('voltageChart').getContext('2d');
    const batteryCtx = document.getElementById('batteryChart').getContext('2d');
    const initialFeeds = @json($feeds ?? []);

    console.log('Initial feeds:', initialFeeds);

    // Create initial charts and store their instances
    const voltageChart = new Chart(voltageCtx, {
        type: 'line',
        data: {
            labels: initialFeeds.map(feed => new Date(feed.created_at).toLocaleTimeString()),
            datasets: [{
                label: 'Voltage (V)',
                data: initialFeeds.map(feed => parseFloat(feed.field1)),
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
            labels: initialFeeds.map(feed => new Date(feed.created_at).toLocaleTimeString()),
            datasets: [{
                label: 'Battery (%)',
                data: initialFeeds.map(feed => parseFloat(feed.field2)),
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

    // Function to fetch new data and update charts
    async function updateCharts() {
        try {
            //  API endpoint
            const response = await fetch('/api/v1/thingspeak-data', {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,

                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            console.log('Updated data received:', data);

            if (!data.feeds || !Array.isArray(data.feeds)) {
                console.error('Invalid data format received:', data);
                return;
            }

            // Update charts with new data
            const newLabels = data.feeds.map(feed => new Date(feed.created_at).toLocaleTimeString());
            const newVoltageData = data.feeds.map(feed => parseFloat(feed.field1));
            const newBatteryData = data.feeds.map(feed => parseFloat(feed.field2));

            voltageChart.data.labels = newLabels;
            voltageChart.data.datasets[0].data = newVoltageData;

            batteryChart.data.labels = newLabels;
            batteryChart.data.datasets[0].data = newBatteryData;

            // Update the charts
            voltageChart.update();
            batteryChart.update();

            console.log('Charts updated successfully');
        } catch (error) {
            console.error('Error fetching updated data:', error);
        }
    }

    // Update charts every 2 minutes
    setInterval(updateCharts, 120000);

    // Initial update
    updateCharts();
});
</script>

<style>
    .chart-container {
        position: relative;
        height: 450px;
        width: 90%;
    }
</style>
@endsection
