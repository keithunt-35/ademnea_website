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

    <!-- Amplitude vs Frequency Chart -->
    <div class='bg-white mb-4'>
      <h3 class='mx-2 font-bold py-1 text-green-600'>Amplitude vs Frequency</h3>
      <canvas id="amplitudeFrequencyChart" width="400" height="200"></canvas>
    </div>

    <!-- Frequency Spectrum Chart -->
    <div class='bg-white'>
      <h3 class='mx-2 font-bold py-1 text-green-600'>Frequency Spectrum</h3>
      <canvas id="frequencySpectrumChart" width="400" height="200"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const data = {!! $data !!};
            const csvFilePath = '/hivevibration/vibration_2.csv';
  
            fetch(csvFilePath)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(csvData => {
                    console.log('CSV data fetched successfully');
                    const data = Papa.parse(csvData, { header: true }).data;
                    console.log('Parsed CSV data:', data);
  
                    // Extract amplitude and frequency data for plotting
                    const frequencyX = data.map(row => parseFloat(row['Frequency_X']));
                    const amplitudeX = data.map(row => parseFloat(row['Amplitude_X']));
                    const frequencyY = data.map(row => parseFloat(row['Frequency_Y']));
                    const amplitudeY = data.map(row => parseFloat(row['Amplitude_Y']));
                    const frequencyZ = data.map(row => parseFloat(row['Frequency_Z']));
                    const amplitudeZ = data.map(row => parseFloat(row['Amplitude_Z']));
  
                    const ctx1 = document.getElementById('amplitudeFrequencyChart').getContext('2d');
                    const amplitudeFrequencyChart = new Chart(ctx1, {
                        type: 'line',
                        data: {
                            labels: frequencyX, // Assuming all frequency columns have the same labels
                            datasets: [
                                // {
                                //     label: 'Amplitude X',
                                //     data: amplitudeX,
                                //     borderColor: 'red',
                                //     fill: false,
                                //     pointRadius: 0
                                // },
                                {
                                    label: 'Amplitude Y',
                                    data: amplitudeY,
                                    borderColor: 'green',
                                    fill: false,
                                    pointRadius: 0
                                },
                                // {
                                //     label: 'Amplitude Z',
                                //     data: amplitudeZ,
                                //     borderColor: 'blue',
                                //     fill: false,
                                //     pointRadius: 0
                                // }
                            ]
                        },
                        options: {
                            responsive: true,
                            title: {
                                display: true,
                                text: 'Amplitude vs Frequency'
                            },
                            scales: {
                                x: {
                                    display: true,
                                    title: {
                                        display: true,
                                        text: 'Frequency'
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
  
                    // Extract frequency and FFT amplitude data for plotting
                    const frequency = data.map(row => parseFloat(row['Frequency_X']));  // Assuming the frequencies are the same for X, Y, and Z
                    const fftAmplitudeX = data.map(row => parseFloat(row['FFT_Amplitude_X']));
                    const fftAmplitudeY = data.map(row => parseFloat(row['FFT_Amplitude_Y']));
                    const fftAmplitudeZ = data.map(row => parseFloat(row['FFT_Amplitude_Z']));
  
                    console.log('Frequency data:', frequency);
                    console.log('FFT Amplitude X data:', fftAmplitudeX);
                    console.log('FFT Amplitude Y data:', fftAmplitudeY);
                    console.log('FFT Amplitude Z data:', fftAmplitudeZ);
  
                    const ctx2 = document.getElementById('frequencySpectrumChart').getContext('2d');
                    const frequencySpectrumChart = new Chart(ctx2, {
                        type: 'line',
                        data: {
                            labels: frequency, // Frequency values for the x-axis
                            datasets: [
                                // {
                                //     label: 'FFT Amplitude X',
                                //     data: fftAmplitudeX,
                                //     borderColor: 'red',
                                //     fill: false,
                                //     pointRadius: 0
                                // },
                                {
                                    label: 'FFT Amplitude Y',
                                    data: fftAmplitudeY,
                                    borderColor: 'green',
                                    fill: false,
                                    pointRadius: 0
                                },
                                // {
                                //     label: 'FFT Amplitude Z',
                                //     data: fftAmplitudeZ,
                                //     borderColor: 'blue',
                                //     fill: false,
                                //     pointRadius: 0
                                // }
                            ]
                        },
                        options: {
                            responsive: true,
                            title: {
                                display: true,
                                text: 'Frequency Spectrum'
                            },
                            scales: {
                                x: {
                                    display: true,
                                    title: {
                                        display: true,
                                        text: 'Frequency'
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


                // Initial fetch and chart rendering
            fetchAndUpdateCharts();

// Set interval to automatically refresh data and update charts
setInterval(fetchAndUpdateCharts, 60000); // Update every 60 seconds
        });
    </script>
  </div>

@endsection
