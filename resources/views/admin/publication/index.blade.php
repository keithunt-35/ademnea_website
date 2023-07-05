@extends('layouts.app')
@section('content')


<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table id="myTable" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    #
                </th>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Title
                </th>
                <th scope="col" class="px-6 py-3">
                    Publisher
                </th>
                <th scope="col" class="px-6 py-3">
                  Year of Publication
                </th>
                <th scope="col" class="px-6 py-3">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
        @foreach($publication as $item)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                {{ $loop->iteration }}
                </th>
                <td class="px-6 py-4">
                {{ $item->name }}
                </td>
                <td class="px-6 py-4">
                {{ $item->title }}
                </td>
                <td class="px-6 py-4">
                {{ $item->publisher }}
                </td>
                <td class="px-6 py-4">
                {{ $item->year }}
                </td>
                <td class="px-6 py-4">
                    <a href="#" type="button" data-modal-target="editUserModal" data-modal-show="editUserModal" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    {{-- <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a> --}}
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