@extends('layouts.app')

@section('content')

@php
  $hive_id = session('hive_id');
@endphp
>

@include('datanavbar')

<div class="relative p-3 mt-10 overflow-x-auto shadow-md sm:rounded-lg">

<!-- Display the hive_id at the top of the page -->
<h1 style="text-align: left; font-weight: bold; font-size: 1em; margin-bottom: 20px; color: green;">Hive ID: {{ $hive_id }}</h1>

    <table id="myTable"class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    #
                </th>
                <!-- <th scope="col" class="px-6 py-3">
                    Hive ID
                </th> -->
                <th scope="col" class="px-6 py-3">
                    Photo
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
        @foreach($photos as $photo)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
           
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                {{ $count }}
                </th>
                <td class="px-6 py-4">
                {{ $photo->hive_id }}
                </td>
                <td class="px-6 py-4">
                    <a href="{{ URL("hiveimage/"."".$photo->path) }}" target="_blank"><img src="{{ URL("hiveimage/"."".$photo->path) }}" alt=""" height="100" width="100"></a>
                </td>
                <td class="px-6 py-4">
                {{ $photo->created_at }}
                </td>
            </tr>
            @php
                $count = $count + 1
                @endphp
            @endforeach 
        </tbody>
    </table>
</div>

<script src="{{ asset('js/lightbox-plus-jquery.js') }}"></script>

@endsection

@section('page_scripts')

@endsection 
