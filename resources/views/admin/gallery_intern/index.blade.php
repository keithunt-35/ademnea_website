@extends('layouts.app')
@section('content')


<div class="relative p-3 mt-2 overflow-x-auto shadow-md sm:rounded-lg">
  <button type="button" data-modal-target="addevent" data-modal-show="addevent" class="text-white ml-4 mt-4 bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2">
    Add New Gallery
  </button>

 <table id="myTable" class="w-full text-sm text-left text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600 rounded-lg overflow-hidden">
  <thead class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 uppercase text-xs">
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Venue</th>
            <th>Date</th>
            <th>Description</th>
            <th>Photos</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($galleries as $gallery)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $gallery->title }}</td>
                <td>{{ $gallery->venue }}</td>
                <td>{{ \Carbon\Carbon::parse($gallery->date)->format('F j, Y') }}</td>
                <td>{{ \Illuminate\Support\Str::limit($gallery->description, 50) }}</td>
                <td>{{ $gallery->photos->count() }} photos</td>
                <td>
                    <!-- Actions like view, edit, delete -->
                  <a href="#" 
                    class="btn btn-success btn-sm"
                    onclick="openViewModal(
                        {{ $gallery->id }},
                        `{{ addslashes($gallery->title) }}`,
                        `{{ addslashes($gallery->venue) }}`,
                        `{{ $gallery->date }}`,
                        `{{ addslashes($gallery->description) }}`
                    )">View</a>

                    <button type="button" class="btn btn-warning btn-sm text-white" style="background-color: #ffc107; color: white;"
                        onclick="openEditModal(
                            {{ $gallery->id }},
                            `{{ addslashes($gallery->title) }}`,
                            `{{ addslashes($gallery->venue) }}`,
                            `{{ $gallery->date }}`,
                            `{{ addslashes($gallery->description) }}`
                        )">
                            Edit
                    </button>
                    <!-- Delete Button -->
                    <form method="POST" action="{{ route('gallery_interns.destroy', $gallery->id) }}" 
                          onsubmit="return confirm('Are you sure?');" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" style="background-color: red; color: white;">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">No gallery entries found.</td>
            </tr>
        @endforelse
    </tbody>
</table>






<!-- Add New Event Modal -->
<div id="addevent" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full">
  <div class="relative w-full max-w-2xl max-h-full">
<form action="{{ route('gallery_interns.store') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-700 rounded-lg shadow p-6">
    @csrf
    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Add New Gallery</h3>
        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="addevent" aria-label="Close">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </button>

      </div>
      <div class="p-6 space-y-6">
        <div class="grid grid-cols-6 gap-6">
          <div class="col-span-6 sm:col-span-3">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
            <input name="title" type="text" class="input-field">
          </div>
          <div class="col-span-6 sm:col-span-3">
            <label for="venue" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Venue</label>
            <input name="venue" type="text" class="input-field">
          </div>
          <div class="col-span-6 sm:col-span-3">
            <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date</label>
            <input name="date" type="date" class="input-field">
          </div>

          <div class="col-span-6 sm:col-span-6">
            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
            <textarea name="description" class="input-field h-24"></textarea>
          </div>
          <div class="col-span-6 sm:col-span-6">
            <label for="images" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Images</label>
            <input type="file" name="images[]" multiple accept="image/*" />
          </div>
        </div>
      </div>
      <div class="flex items-center p-6 space-x-2 border-t dark:border-gray-600">
        <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
            Save all
        </button>

      </div>
    </form>
  </div>
</div>




<!-- Edit Modal -->
<div id="editevent" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full">
  <div class="relative w-full max-w-2xl max-h-full mx-auto">
    <form id="editForm" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-700 rounded-lg shadow p-6">
      @csrf
      @method('PUT')

      <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Edit Gallery</h3>
        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="editevent" aria-label="Close">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
          </svg>
        </button>
      </div>

      <div class="p-6 space-y-6">
        <div class="grid grid-cols-6 gap-6">
          <!-- Title -->
          <div class="col-span-6 sm:col-span-3">
            <label for="edit_title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
            <input type="text" name="title" id="edit_title" class="input-field">
          </div>

          <!-- Venue -->
          <div class="col-span-6 sm:col-span-3">
            <label for="edit_venue" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Venue</label>
            <input type="text" name="venue" id="edit_venue" class="input-field">
          </div>

          <!-- Date -->
          <div class="col-span-6 sm:col-span-3">
            <label for="edit_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date</label>
            <input type="date" name="date" id="edit_date" class="input-field">
          </div>

          <!-- Description -->
          <div class="col-span-6 sm:col-span-6">
            <label for="edit_description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
            <textarea name="description" id="edit_description" class="input-field h-24"></textarea>
          </div>

          <!-- Images -->
          <div class="col-span-6 sm:col-span-6">
            <label for="edit_photos" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Add New Photos (optional)</label>
            <input type="file" name="images[]" id="edit_photos" multiple accept="image/*">
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">You can upload multiple photos.</p>
          </div>
        </div>
      </div>

      <div class="flex items-center p-6 space-x-2 border-t dark:border-gray-600">
        <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
          Save Changes
        </button>
        <button type="button" class="text-gray-700 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg text-sm px-5 py-2.5" data-modal-hide="editevent">
          Cancel
        </button>
      </div>
    </form>
  </div>
</div>

</div>


<!-- View Gallery Modal -->
<div id="viewevent" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full">
  <div class="relative w-full max-w-2xl max-h-full mx-auto">
    <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-6">
      <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">View Gallery</h3>
        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="viewevent" aria-label="Close">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
          </svg>
        </button>
      </div>

      <div class="p-6 space-y-6">
        <div class="grid grid-cols-6 gap-6">

          <div class="col-span-6 sm:col-span-3">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
            <p id="view_title" class="text-gray-700 dark:text-gray-300"></p>
          </div>

          <div class="col-span-6 sm:col-span-3">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Venue</label>
            <p id="view_venue" class="text-gray-700 dark:text-gray-300"></p>
          </div>

          <div class="col-span-6 sm:col-span-3">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date</label>
            <p id="view_date" class="text-gray-700 dark:text-gray-300"></p>
          </div>

          <div class="col-span-6 sm:col-span-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
            <p id="view_description" class="text-gray-700 dark:text-gray-300 whitespace-pre-line"></p>
          </div>

        </div>
      </div>

      <div class="flex items-center p-6 space-x-2 border-t dark:border-gray-600">
        <button type="button" class="text-gray-700 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg text-sm px-5 py-2.5" data-modal-hide="viewevent">
          Close
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Utility Styles (optional) -->
<style>
  .input-field {
    shadow-sm: true;
    background-color: #f9fafb;
    border: 1px solid #d1d5db;
    color: #111827;
    padding: 0.625rem;
    border-radius: 0.5rem;
    width: 100%;
  }
</style>

 
<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Your custom script -->
<script>
function openEditModal(id, title, venue, date, description) {
    document.getElementById('edit_title').value = title;
    document.getElementById('edit_venue').value = venue;
    document.getElementById('edit_date').value = date;
    document.getElementById('edit_description').value = description;

    const form = document.getElementById('editForm');
    const base = "{{ url('admin/gallery_interns') }}";
    form.action = `${base}/${id}`;

    document.getElementById('editevent').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

// Close modal on "Cancel" or "X" button
document.querySelectorAll('[data-modal-hide="editevent"]').forEach(btn => {
    btn.addEventListener('click', () => {
        document.getElementById('editevent').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    });
});


function openViewModal(id, title, venue, date, description) {
    document.getElementById('view_title').textContent = title;
    document.getElementById('view_venue').textContent = venue;
    document.getElementById('view_date').textContent = date;
    document.getElementById('view_description').textContent = description;

    document.getElementById('viewevent').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

// Close modal on button click
document.querySelectorAll('[data-modal-hide="viewevent"]').forEach(btn => {
    btn.addEventListener('click', () => {
        document.getElementById('viewevent').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    });
});
</script>


 @endsection
 