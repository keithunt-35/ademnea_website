@extends('layouts.app')
@section('content')

<!-- Dependencies for Date Picker -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@php
    $hive_id = session('hive_id');
@endphp

@include('datanavbar')

<!-- Hive header -->
<h1 style="text-align: left; font-weight: bold; font-size: 1em; margin-bottom: 20px; color: green;">Hive: {{ $hive_id }}</h1>

<!-- Download button -->
<div class="flex justify-end mb-4">
    <a href="{{ route('voc.export', ['hive_id' => $hive_id]) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
        Download
    </a>
</div>

<!-- Data Table (no loop yet) -->
<div class="relative p-3 mt-10 overflow-x-auto shadow-md sm:rounded-lg">
    <table id="myTable" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">#</th>
                <th scope="col" class="px-6 py-3">VOC (ppb)</th>
                <th scope="col" class="px-6 py-3">Date</th>
            </tr>
        </thead>
        <tbody>
        @php $count = 1; @endphp
        @foreach($voc as $item)
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                {{ $count++ }}
            </th>
            <td class="px-6 py-4">
                {{ $item->record }}
            </td>
            <td class="px-6 py-4">
                {{ $item->created_at }}
            </td>
        </tr>
        @endforeach
        </tbody>

    </table>
</div>
@endsection

<!-- Pagination and DataTables scripts -->
@section('page_scripts')
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<script>
  $(document).ready(function() {
    $('#myTable').DataTable({
      responsive: true
    });
  });
</script>
@endsection
