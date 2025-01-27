<x-layout>
 <x-slot:title>Medication</x-slot:title>
 <x-sidebar :user="$user" />

 <div class="flex-grow">
  <div class="mx-auto my-24 max-w-4xl px-2 md:px-4 lg:p-6 lg:my-0">
   <div class="overflow-hidden rounded-lg bg-white shadow">
    <!-- Header -->
    <div class="border-b border-gray-200 bg-green-500 px-6 py-4">
     <div class="flex items-center gap-3">
      <h1 class="text-2xl font-bold text-white">{{ $medication->name }}</h1>
      <div
       class="{{ $medication->status === 'active' ? 'bg-yellow-100 text-yellow-800' : ($medication->status === 'inactive' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800') }} flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold leading-5">
       <div class="{{ $medication->status === 'active' ? 'bg-yellow-600' : ($medication->status === 'inactive' ? 'bg-red-600' : 'bg-green-600') }} h-3 w-3 animate-pulse rounded-full"></div>
       <p>{{ ucfirst($medication->status) }}</p>
      </div>
     </div>
    </div>

    <!-- Content -->
    <div class="px-6 py-4">
     <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
      <!-- Left Column -->
      <div class="space-y-4">
       <div>
        <h3 class="font-bold text-gray-800">Dosage</h3>
        <p class="mt-1 text-gray-500">{{ $medication->dosage }}</p>
       </div>

       <div>
        <h3 class="font-bold text-gray-800">Frequency</h3>
        <p class="mt-1 text-gray-500">{{ $medication->frequency }}</p>
       </div>

       <div>
        <h3 class="font-bold text-gray-800">Type</h3>
        <p class="mt-1 text-gray-500">{{ ucfirst($medication->medicationType) }}</p>
       </div>

       <div>
        <h3 class="font-bold text-gray-800">Instructions</h3>
        <p class="mt-1 text-gray-500">{{ $medication->instructions }}</p>
       </div>
      </div>

      <!-- Right Column -->
      <div class="space-y-4">
       <div>
        <h3 class="font-bold text-gray-800">Duration</h3>
        <p class="mt-1 text-gray-500">
         {{ \Carbon\Carbon::parse($medication->startDate)->format('M d, Y') }} -
         {{ \Carbon\Carbon::parse($medication->endDate)->format('M d, Y') }}
        </p>
       </div>

       <div>
        <h3 class="font-bold text-gray-800">Schedule</h3>
        <div class="mt-1 space-y-2">
         <p class="text-gray-500">Times: {{ implode(', ', $medication->schedule['times']) }}</p>
         <p class="text-gray-500">Days: {{ implode(', ', $medication->schedule['daysOfWeek']) }}</p>
        </div>
       </div>
      </div>
     </div>
    </div>

    <!-- Footer -->
    <div class="border-t border-gray-200 bg-gray-50 px-6 py-4">
     <div class="flex justify-end space-x-3">
      <a class="cursor-pointer rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500" onclick="toggleEditModal()">
       Edit Medication
      </a>
      <a class="cursor-pointer rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500" onclick="toggleDeleteModal()">
       Delete
      </a>
     </div>
    </div>
   </div>
  </div>

  <!--Edit Medication -->
  <div>
   <x-modals.edit :medication="$medication" />
  </div>

  <!-- Delete Medication -->
  <div>
   <x-modals.delete :medication="$medication" />
  </div>
 </div>


 @push('scripts')
  <script src="{{ asset('js/showmed.js') }}"></script>
  <script>
   @if (Session::has('success'))
    toastr.options = {
     "closeButton": true,
     "progressBar": true,
     "positionClass": "toast-top-right",
     "timeOut": "3000"
     "toastClass": "toast custom-toast"
    }
    toastr.success("{{ Session::get('success') }}");
   @endif
  </script>
 @endpush
</x-layout>
