{{-- @extends('layouts.app')
@section('content')
<!-- Include jQuery -->
 <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
 <!-- Include DataTables CSS and JS files -->
<link href="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js" rel="stylesheet"/>
<script src="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css"></script>
<!-- Include DataTables Responsive CSS and JS files -->
   <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css" rel="stylesheet"/>
   <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

   <div class="table-responsive">
    <table id="myTable" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    ID
                </th>
                <th scope="col" class="px-6 py-3">
                    DESCRIPTION
                </th>
                <th scope="col" class="px-6 py-3">
                    ARTICLE
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($newsletter as $item)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-6 py-4">
                    {{ $item->id }}
                </td>
                <td class="px-6 py-4">
                    {{ $item->description }}
                </td>
                <td class="px-6 py-4">
                    {{ $item->article }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            paging: true,
            searching: true,
            responsive: true
        });
    });
    </script>
@endsection --}}
@extends('layouts.app')
@section('content')
<div class="table-responsive">
    <table id="myTable" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    ID
                </th>
                <th scope="col" class="px-6 py-3">
                    DESCRIPTION
                </th>
                <th scope="col" class="px-6 py-3">
                    ARTICLE
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($newsletter as $item)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-6 py-4">
                    {{ $item->id }}
                </td>
                <td class="px-6 py-4">
                    {{ $item->description }}
                </td>
                <td class="px-6 py-4">
                    {{ $item->article }}
                </td>
            </tr>
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
    $(document).ready(function() {
        $('#myTable').DataTable({
            paging: true, // Enable pagination
            lengthMenu: [2, 10, 20, 50, -1], // Set entries per page to 6
            pageLength: 2,
            responsive: true
        });
    });
</script>
@endsection
