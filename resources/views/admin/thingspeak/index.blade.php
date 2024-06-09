@extends('layouts.app')


@section('content')


<body>
    {{-- @include('datanavbar') --}}
    {{-- <canvas id="myChart" width="400" height="200"></canvas> --}}
    <canvas id="myChart" width="400" height="200"></canvas>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        async function fetchData() {
            const response = await fetch('/thingspeak/data');
            const data = await response.json();

            return data.map(record => ({
                x: new Date(record.created_at),
                y: record.field1
            }));
        }

        async function plotChart() {
            const dataPoints = await fetchData();

            const ctx = document.getElementById('myChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    datasets: [{
                        label: 'Field1 Data',
                        data: dataPoints,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        fill: false
                    }]
                },
                options: {
                    scales: {
                        x: {
                            type: 'time',
                            time: {
                                unit: 'minute'
                            }
                        }
                    }
                }
            });
        }

        plotChart();
    </script>
</body>
@endsection