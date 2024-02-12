@extends('layouts.app')
@section('content')


<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@php
    $hive_id = session('hive_id');
@endphp

@include('datanavbar')

<div class="relative p-3 mt-10 overflow-x-auto shadow-md sm:rounded-lg">

    <div class="card-header">
        <div class="row">
            <div class="col col-9"><b>Pick Date Range</b></div>
            <div class="col col-3">
                <div>
                <h3 class='mx-2 font-bold py-1 text-green-600'>Select a date-range</h3>
                <!-- Date range picker -->
                    <div id="reportrange" class="border-2 border-green-800 rounded-lg hover:bg-green-800"
                        style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 260px; ">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span></span> <i class="fa fa-caret-down"></i>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    {{-- javascript for the date range picker --}}
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
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                }
            }, cb);

            cb(start, end);
        });
    </script>
    
    <br>
    {{-- table begins here  --}}

    <table id="myTable" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    #
                </th>
                <th scope="col" class="px-6 py-3">
                    Hive ID
                </th>
                <th scope="col" class="px-6 py-3">
                 Honey Section (°C)
                </th>
                <th scope="col" class="px-6 py-3">
                 Brood Section (°C)
                </th>
                <th scope="col" class="px-6 py-3">
                 Exterior (°C)
                </th>
                <th scope="col" class="px-6 py-3">
                    Date
                </th>
            </tr>
        </thead>
        <tbody>
        @php
            $count =  1
            @endphp
        @foreach($temperatures as $temperature)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                {{ $count }}
                </th>
                <td class="px-6 py-4">
                {{ $temperature->hive_id }}
                </td>
                <td class="px-6 py-4">
                {{ explode('*', $temperature->record)[0] }}
                </td>
                <td class="px-6 py-4">
                {{ explode('*', $temperature->record)[1] }}
                </td>
                <td class="px-6 py-4">
                {{ explode('*', $temperature->record)[2] }}
                </td>
                <td class="px-6 py-4">
                {{ $temperature->created_at }}
                </td>
            </tr>
            @php
                $count = $count + 1
                @endphp
            @endforeach
        </tbody>
    </table>
</div>

@endsection
<!-- added pagination and search-->
@section('page_scripts')
<!-- Include DataTables JS file -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<script>

//   $(document).ready(function() {
//   $('#myTable').DataTable({
//      responsive: true,
//   });
// });

</script>

<script type="text/javascript">
    $(function() {
    
      var start = moment().subtract(1, 'days'); //by default , just display data for the previous day or 24 hours
      var end = moment();
      var hiveId = {{ $hive_id }}; 
      var myChart = echarts.init(document.getElementById('chart'));
    
      function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY')); 
    
        // Format dates for the server
        var startDate = start.format('YYYY-MM-DD HH:mm:ss');
        var endDate = end.format('YYYY-MM-DD HH:mm:ss');

        // if(startDate && endDate){
        // location.href = '/hive_data/temperaturedata?hive_id =' + hiveId+ '?startDate='+startDate+'?endDate='+startDate;
        // }

        // Send AJAX request to server
        $.ajax({
            url: '/hive_data/temperaturedata?hive_id =' + $hiveId,
            method: 'GET',
            data: {
                start: startDate,
                end: endDate,
                table: 'hive_temperatures' // name of the table you want to fetch data from
            },
            success: function(response) {
    
                // handle the response data
                myChart.setOption({
                  // chart configuration options here
                    title: {
                                text: 'Temperatures'
                            },
                    tooltip: {
                              trigger: 'axis'
                          },
                    legend: {},
                    toolbox: {
                              show: true,
                              feature: {
                              dataZoom: {
                                  show: false, 
                                  yAxisIndex: 'none'
                              },
                              dataView: { show: false, readOnly: false },
                              magicType: { show: false, type: ['line', 'bar'] },
                              restore: { show: false },
                              saveAsImage: { show: true }
                              }
                          },
                    xAxis: {
                              type: 'category',
                              boundaryGap: false,
                              data: response.dates // assuming you returned the dates under the key 'dates'
                          },
                    yAxis: {
                              type: 'value',
                              min: 10,
                              max: 40,
                              axisLabel: {
                              formatter: '{value} °C'
                              },
                              splitNumber: 10
                          },
                    series: [
                      {
                            name: 'Brood Section',
                            type: 'line',
                            data: response.broodSection,
                            markPoint: {
                                        data: [
                                              { type: 'max', name: 'Max' },
                                              { type: 'min', name: 'Min' }
                                              ]
                                        },
                            markLine: {
                                        data: [{ type: 'average', name: 'Avg' }]
                                       },
                                      //  color: 'red' 
                          },
                        {
                            name: 'Exterior',
                            type: 'line',
                            data: response.exterior,
                            markPoint: {
                                        data: [
                                              { type: 'max', name: 'Max' },
                                              { type: 'min', name: 'Min' }
                                              ]
                                        },
                            markLine: {
                                        data: [{ type: 'average', name: 'Avg' }]
                                       },
                            
                            // color: 'green' 
                           
                        },
                       
                          {
                            name: 'Honey Section',
                            type: 'line',
                            data: response.honeySection,
                            markPoint: {
                            data: [
                                  { type: 'max', name: 'Max' },
                                  { type: 'min', name: 'Min' }
                                ]
                              },
                              markLine: {
                                data: [{ type: 'average', name: 'Avg' }]
                              },
                              // color: 'blue' 
                        },
                    ]
                });
            }
    
        });
    }
    
    $('#reportrange').daterangepicker({
        ranges: {
           'Today': [moment().startOf('day'), moment().endOf('day')],
           'Yesterday': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days').endOf('day')],
           'Last 7 Days': [moment().subtract(6, 'days').startOf('day'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days').startOf('day'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);
    
    cb(start, end);
    });
    </script>

<div class='bg-white'>
    <div id="chart" style="width: 100%; height: 480px;" class='p-1'></div>
      <script>
      // JavaScript code to create and configure the chart
      var myChart = echarts.init(document.getElementById('chart'));
      </script>
</div>

@endsection