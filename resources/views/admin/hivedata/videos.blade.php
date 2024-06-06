@extends('layouts.app')
@section('content')

 @php
  $hive_id = session('hive_id');
@endphp



@include('datanavbar')

<!-- Display the hive_id at the top of the page -->
<h1 style="text-align: left; font-weight: bold; font-size: 1em; margin-bottom: 20px; color: green;">Hive ID: {{ $hive_id }}</h1>

<div class="relative p-3 mt-10 overflow-x-auto shadow-md sm:rounded-lg">
    <table id="myTable" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    #
                </th>
                <!-- <th scope="col" class="px-6 py-3">
                    Hive ID
                </th> -->
                <th scope="col" class="px-6 py-3">
                    Videos
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
        @foreach($videos as $video)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                {{ $count }}
                </th>
                <td class="px-6 py-4">
                {{ $video->hive_id }}
                </td>
                <td class="px-6 py-4">
                <video width="100px" height="100px"
                    controls="controls"/>
                    
                <source src="{{ URL("hivevideo/"."".$video->path) }}"
                    type="video/mp4">
                </video>
                </td>
                <td class="px-6 py-4">
                {{ $video->created_at }}
                </td>
            </tr>
            @php
                $count = $count + 1
                @endphp
            @endforeach  
        </tbody>
    </table>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log("DOM content loaded.");
        
        const playlistItems = document.querySelectorAll('.playlist-item');

        playlistItems.forEach(function(item) {
            item.addEventListener('click', function(event) {
                event.preventDefault();
                const videoSource = this.getAttribute('data-video');
                console.log(videoSource);
                document.getElementById('mainVideo').src = "{{ URL('hivevideo') }}/" + videoSource;
                document.getElementById('mainVideo').load();
            });
        });
    });
</script>

@endsection

@section('page_scripts')

@endsection

