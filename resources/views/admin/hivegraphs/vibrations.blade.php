@extends('layouts.app')

@section('content')

<div class="relative">

  <body>

    {{-- data nav bar goes here --}}
    @include('datanavbar')

    <!-- Choose date range -->
    <div class="flex flex-row space-x-4 items-center justify-between h-8 mb-4 bg-white">
      <div>
        <h3 class='mx-2 font-bold py-1 text-green-600'>Hive : <span class="font-extrabold">{{ $hive_id }}</span></h3>
      </div>
      <div>
        <h3 class='mx-2 font-bold py-1 text-green-600'>Select a date-range</h3>
        <!-- Date range picker -->
        <div id="reportrange" class="border-2 border-green-800 rounded-lg hover:bg-green-800"
            style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 260px;">
            <i class="fa fa-calendar"></i>&nbsp;
            <span></span> <i class="fa fa-caret-down"></i>
        </div>
      </div>
    </div>

    <script type="text/javascript">
      $(function() {
          var start = moment().subtract(29, 'days');
          var end = moment();

          function cb(start, end) {
              $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
          }

          $('#reportrange').daterangepicker({
              startDate: start,
              endDate: end,
              ranges: {
                  'Today': [moment(), moment()],
                  'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                  'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                  'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                  'This Month': [moment().startOf('month'), moment().endOf('month')],
                  'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
              }
          }, cb);

          cb(start, end);
      });
    </script>
  </body>
    <!-- Vibration Data Chart -->
    <div class='bg-white'>
      <h3 class='mx-2 font-bold py-1 text-green-600'>Vibration Data</h3>
      <canvas id="vibrationChart" width="400" height="200"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const hiveId = '{{ $hive_id }}';
            const csvFilePath = '/vibrations/vibration.csv';
  
            fetch(csvFilePath)
                .then(response => response.text())
                .then(csvData => {
                    const data = Papa.parse(csvData, { header: true }).data;
  
                    // Process the data
                    const labels = data.map(row => row['Time']);
                    const xValues = data.map(row => parseFloat(row['X']));
  
                    const ctx = document.getElementById('vibrationChart').getContext('2d');
                    const vibrationChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'X',
                                    data: xValues,
                                    borderColor: 'green',
                                    fill: false
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            title: {
                                display: true,
                                text: 'Vibration Data'
                            },
                            scales: {
                                x: {
                                    display: true,
                                    title: {
                                        display: true,
                                        text: 'Time'
                                    }
                                },
                                y: {
                                    display: true,
                                    title: {
                                        display: true,
                                        text: 'Amplitude'
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error fetching or parsing the CSV file:', error));
        });
      </script>
  </div>

@endsection