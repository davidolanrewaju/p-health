<!-- Success Modal -->
 <div class="fixed inset-0 z-50 overflow-y-auto" id="successModal">
  <div class="flex min-h-screen items-center justify-center px-4">
   <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

   <div class="relative w-full max-w-md rounded-lg bg-white p-8 text-center">
    <div class="mx-auto mb-4 h-12 w-12 text-green-500">
     <x-heroicon-o-check-circle class="h-full w-full" />
    </div>
    <h3 class="mb-4 text-xl font-medium">Medication Added Successfully!</h3>
    <button class="rounded-md bg-green-500 px-4 py-2 text-white" onclick="closeSuccessModal()">Close</button>
   </div>
  </div>
 </div>

  {{-- @if (session('success'))
  {{-- <x-modals.success />
  <div class="relative rounded border border-green-400 bg-red-100 px-4 py-3 text-green-700" role="alert">
   <strong class="font-bold">Congratulations!</strong>
   <span class="block sm:inline">Medication updated successfully</span>
   <span class="absolute bottom-0 right-0 top-0 px-4 py-3">
    <svg class="h-6 w-6 fill-current text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
     <title>Close</title>
     <path
      d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
    </svg>
   </span>
  </div>
 @endif --}}