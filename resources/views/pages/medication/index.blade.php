<x-layout>
 <x-slot:title>Medication</x-slot:title>
 <x-sidebar :user="$user" />
 <div class="flex-grow">
  <div class="mx-4 my-24 max-w-full lg:my-5">
   <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
    <div>
     <h1 class="text-2xl font-bold text-slate-900 lg:text-3xl">Medications</h1>
    </div>

    <div class="flex flex-wrap gap-2 lg:gap-4">
     <button class="flex items-center gap-2 rounded-md bg-gray-200 px-3 py-2 text-sm lg:px-4 lg:text-base">
      <x-heroicon-o-funnel class="h-4 w-4 lg:h-5 lg:w-5" />
      <p>Filter</p>
     </button>
     <button class="flex items-center gap-2 rounded-md bg-gray-200 px-3 py-2 text-sm lg:px-4 lg:text-base">
      <x-gmdi-import-export-r class="h-4 w-4 lg:h-5 lg:w-5" />
      <p>Export</p>
     </button>
     <button class="flex items-center gap-2 rounded-md bg-green-500 px-3 py-2 text-sm text-white lg:px-4 lg:text-base" onclick="toggleCreateModal()">
      <x-heroicon-m-plus class="h-4 w-4 lg:h-5 lg:w-5" />
      <p>Add New Medication</p>
     </button>
    </div>
   </div>

   <!-- Medication List -->
   <div class="relative mt-10">
    <div class="overflow-x-auto">
     <div class="inline-block min-w-full align-middle">
      <div class="overflow-hidden">
       <table class="min-w-full">
        <thead class="bg-gray-50">
         <tr>
          <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Name</th>
          <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Dosage</th>
          <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Frequency</th>
          <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Type</th>
          <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Status</th>
          <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500"></th>
         </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
         @foreach ($medications as $medication)
          <tr class="hover:bg-gray-50">
           <td class="min-w-[120px] whitespace-nowrap px-6 py-4">
            <div class="flex items-center">
             <div class="text-sm font-medium text-gray-900">{{ $medication->name }}</div>
            </div>
           </td>
           <td class="min-w-[120px] whitespace-nowrap px-6 py-4 text-sm text-gray-500">
            {{ $medication->dosage }}
           </td>
           <td class="min-w-[120px] whitespace-nowrap px-6 py-4 text-sm text-gray-500">
            {{ $medication->frequency }}
           </td>
           <td class="min-w-[120px] whitespace-nowrap px-6 py-4 text-sm text-gray-500">
            {{ ucfirst($medication->medicationType) }}
           </td>
           <td class="w-1/12 min-w-[120px] whitespace-nowrap px-6 py-4">
            <div
             class="{{ $medication->status === 'active' ? 'bg-yellow-100 text-yellow-800' : ($medication->status === 'inactive' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800') }} flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold leading-5">
             <div class="{{ $medication->status === 'active' ? 'bg-yellow-600' : ($medication->status === 'inactive' ? 'bg-red-600' : 'bg-green-600') }} h-3 w-3 animate-pulse rounded-full"></div>
             <p>{{ ucfirst($medication->status) }}</p>
            </div>
           </td>
           <td class="min-w-[120px] whitespace-nowrap px-6 py-4 text-sm text-gray-700">
            <a class="rounded-lg border border-gray-400 px-2 py-2 hover:border-transparent hover:bg-gray-200 hover:text-gray-900" href="{{ route('medication.show', $medication) }}">
             View Details
            </a>
           </td>
          </tr>
         @endforeach
        </tbody>
       </table>
      </div>
     </div>
    </div>

    <div class="mt-6">
     {{ $medications->links() }}
    </div>
   </div>
  </div>

  <x-modals.create />
 </div>

 @push('scripts')
  <script src="{{ asset('js/createmed.js') }}"></script>
  <script>
   @if (Session::has('success'))
    toastr.options = {
     "closeButton": true,
     "progressBar": true,
     "positionClass": "toast-top-right",
     "timeOut": "3000",
     "toastClass": "toast custom-toast"
    }
    toastr.success("{{ Session::get('success') }}");
   @endif
  </script>
 @endpush
</x-layout>
