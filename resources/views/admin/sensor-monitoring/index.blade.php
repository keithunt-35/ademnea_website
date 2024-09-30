{{-- @extends('layouts.app')
@section('content')


<div>
    <h1>Sensor Fault monitoring will be here</h1>
    
</div>


@endsection --}}
<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Sensor Data Visualization</h2>

    <!-- Temperature Chart -->
    <div>
        <h3>Temperature Data</h3>
        <canvas id="temperatureChart"></canvas>
        <select id="dateRange">
            <option value="today">Today</option>
            <option value="yesterday">Yesterday</option>
            <option value="last7days">Last 7 Days</option>
            <option value="last30days">Last 30 Days</option>
        </select>
    </div>

    <!-- Humidity Chart -->
    <div>
        <h3>Humidity Data</h3>
        <canvas id="humidityChart"></canvas>
        <select id="dateRange">
            <option value="today">Today</option>
            <option value="yesterday">Yesterday</option>
            <option value="last7days">Last 7 Days</option>
            <option value="last30days">Last 30 Days</option>
        </select>
    </div>

    <!-- Weight Chart -->
    <div>
        <h3>Weight Data</h3>
        <canvas id="weightChart"></canvas>
        <select id="dateRange">
            <option value="today">Today</option>
            <option value="yesterday">Yesterday</option>
            <option value="last7days">Last 7 Days</option>
            <option value="last30days">Last 30 Days</option>
        </select>
    </div>

    <!-- Carbon Dioxide Chart -->
    <div>
        <h3>Carbon Dioxide Data</h3>
        <canvas id="co2Chart"></canvas>
        <select id="dateRange">
            <option value="today">Today</option>
            <option value="yesterday">Yesterday</option>
            <option value="last7days">Last 7 Days</option>
            <option value="last30days">Last 30 Days</option>
        </select>
    </div>
</div>

<!-- Scripts for rendering charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Fetch temperature data from the API
        fetch("/api/v1/hives/1/temperature/{'hive_id'}? range=${range}")
            .then(response => response.json())
            .then(data => {
                const labels = data.data.map(record => new Date(record.date).toLocaleDateString());
                const interiorTemperature = data.data.map(record => record.interiorTemperature);
                const exteriorTemperature = data.data.map(record => record.exteriorTemperature);

                // Create the temperature chart
                new Chart(document.getElementById('temperatureChart').getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Interior Temperature',
                                data: interiorTemperature,
                                borderColor: 'rgba(255, 99, 132, 1)',
                                fill: false
                            },
                            {
                                label: 'Exterior Temperature',
                                data: exteriorTemperature,
                                borderColor: 'rgba(54, 162, 235, 1)',
                                fill: false
                            }
                        ]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });

        // Fetch humidity data from the API
        fetch("/api/v1/hives/1/humidity{'hive_id'}? range=${range}")
            .then(response => response.json())
            .then(data => {
                const labels = data.data.map(record => new Date(record.date).toLocaleDateString());
                const interiorHumidity = data.data.map(record => record.interiorHumidity);
                const exteriorHumidity = data.data.map(record => record.exteriorHumidity);

                // Create the humidity chart
                new Chart(document.getElementById('humidityChart').getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Interior Humidity',
                                data: interiorHumidity,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                fill: false
                            },
                            {
                                label: 'Exterior Humidity',
                                data: exteriorHumidity,
                                borderColor: 'rgba(153, 102, 255, 1)',
                                fill: false
                            }
                        ]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });

        // Fetch weight data from the API
        fetch("/api/v1/hives/1/weight?{'hive_id'}? range=${range}")
            .then(response => response.json())
            .then(data => {
                const labels = data.data.map(record => new Date(record.date).toLocaleDateString());
                const weight = data.data.map(record => record.weight);

                // Create the weight chart
                new Chart(document.getElementById('weightChart').getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Weight',
                                data: weight,
                                borderColor: 'rgba(255, 159, 64, 1)',
                                fill: false
                            }
                        ]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });

        // Fetch carbon dioxide data from the API
        fetch("/api/v1/hives/1/carbondioxide{'hive_id'}? range=${range}")
            .then(response => response.json())
            .then(data => {
                const labels = data.data.map(record => new Date(record.date).toLocaleDateString());
                const carbondioxide = data.data.map(record => record.carbondioxide);

                // Create the carbon dioxide chart
                new Chart(document.getElementById('co2Chart').getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Carbon Dioxide',
                                data: carbondioxide,
                                borderColor: 'rgba(255, 206, 86, 1)',
                                fill: false
                            }
                        ]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
    });
</script>
@endsection
