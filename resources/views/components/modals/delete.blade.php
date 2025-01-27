@props(['medication'])
<div class="fixed inset-0 z-50 hidden overflow-y-auto" id="deleteModal">
 <div class="my-4 flex min-h-screen items-center justify-center px-4">
  <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

  <div class="relative w-full max-w-md rounded-lg bg-white p-4 lg:p-6">
   <div class="mb-6 flex items-center justify-between">
    <h2 class="text-xl font-bold text-gray-900">Delete Medication</h2>
    <x-heroicon-c-x-mark class="h-6 w-6 cursor-pointer text-gray-500 hover:text-gray-700" onclick="toggleDeleteModal()" />
   </div>

   <div class="mb-6">
    <p class="text-gray-600">Are you sure you want to delete this medication? This action cannot be undone.</p>
    <p class="mt-2 font-medium text-gray-900">{{ $medication->name }}</p>
   </div>

   <form action="{{ route('medication.delete', $medication->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <div class="flex justify-end gap-3">
     <button class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50" type="button" onclick="closeModal()">
      Cancel
     </button>
     <button class="rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700" type="submit">
      Delete Medication
     </button>
    </div>
   </form>
  </div>
 </div>
</div>
