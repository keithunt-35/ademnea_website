@extends('layouts.app')
@section('content')


<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table id="myTable"class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    #
                </th>
                <th scope="col" class="px-6 py-3">
                    Category
                </th>
                <th scope="col" class="px-6 py-3">
                    Country
                </th>
                <th scope="col" class="px-6 py-3">
                    Instructions
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
        @foreach($scholarship as $item)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                {{ $item->id }}
                </th>
                <td class="px-6 py-4">
                {{ $item->category }}
                </td>
                <td class="px-6 py-4">
                {{ $item->country}}
                </td>
                <td class="px-6 py-4">
                <details>
                    <summary>Scholarship {{ $item->id }}</summary>
                    {!! $item->instructions !!}
                </details>
                </td>
                <td class="px-6 py-4">
                  <!-- Modal toggle -->
                  <a href="#" type="button" data-modal-target="{{ $item->category}}" data-modal-toggle="{{ $item->category }}" class="font-medium text-green-600 dark:text-blue-500 hover:underline">View</a>
                  <a href="#" type="button" data-modal-target="editUserModal" data-modal-show="editUserModal" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                  <a href="#" type="button" data-modal-target="{{ $item->id }}" data-modal-toggle="{{ $item->id }}" class="font-medium text-red-600 dark:text-blue-500 hover:underline">Delete</a>
                  
                </td>
            </tr>
            @endforeach   
        </tbody>
    </table>
</div>

 <!-- Large Modal -->
 @foreach($scholarship as $item)
 <div id="{{ $item->category}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
     <div class="relative w-full max-w-4xl max-h-full">
         <!-- Modal content -->
         <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
             <!-- Modal header -->
             <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                 <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                 DESCRIPTION
             </h3>
                 <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="{{ $item->category }}">
                     <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                     <span class="sr-only">Close modal</span>
                 </button>
             </div>
              <!-- Modal body -->
              <div class="p-6 space-y-6">
                 {{-- <div class="row"> <!--<h4 class="col-4">NAME</h4>--><h4 class="col-4">TITLE</h4></div> --}}
                 <div class="row"> <!--<h4 class="col-4">{{ $item->id }}</h4>--> <h4 class="col-4">{{ $item->category}} </h4><h4 class="col-4"> {{ $item->title }} </h4></div>
                 <hr> 
                 <p>
                    {{ $item->description }}
                    </p> 
                </div>
             <!-- Modal footer -->
             <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                 <button data-modal-hide="{{ $item->name }}"type="button" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-greeb-700 dark:focus:ring-green-800">Back</button>
                 {{-- <button data-modal-hide="{{ $item->name }}"type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Decline</button> --}}
             </div>
         </div>
     </div>
 </div>
 @endforeach
<!-- adding deletig functionality-->
<!-- Add jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@foreach($scholarship as $item)
<!-- Delete user -->
<div id="{{ $item->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
<div class="relative w-full max-w-md max-h-full">
    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
       
        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="{{ $item->id }}">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            <span class="sr-only">Close modal</span>
        </button>
        <div class="p-6 text-center">
            <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this?</h3>
            <!-- added id to the button Yes, I'm sure-->
            <form method="POST" action="{{ url('/admin/scholarship' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <button id="delete-user-btn" data-modal-hide="{{ $item->id }}"  type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                    Yes, I'm sure
                </button>
            </form>
            <button id="cancel-button" data-modal-hide="{{ $item->id }}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                No, cancel
            </button>
        </div>
    </div>
</div>
</div> 
@endforeach
     

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
        lengthMenu: [-1,2,10, 20, 50, 100], // Set entries per page to 6
        pageLength: -1,
        responsive: true
    });
});

         // Event listener for delete button
    $("#delete-user-btn").on("click", function() {
        var confirmDelete = confirm("Confirm delete?");
        if (confirmDelete) {
            var form = $(this).closest('form');
            form.submit();
        }
    });

        // Event listener for cancel button click
document.getElementById("cancel-button").addEventListener("click", function() {
    // Redirect to the table page
    window.location.href = "{{ url('admin/scholarship') }}"; // Replace with the actual URL of the table page
});

</script>
@endsection

