 <!-- Create Medication Modal -->
 <div class="fixed inset-0 z-50 hidden overflow-y-auto" id="medicationModal">
  <div class="my-4 flex min-h-screen items-center justify-center px-4 lg:my-20">
   <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

   <div class="relative w-full max-w-2xl rounded-lg bg-white p-4 lg:p-8">
    <div class="mb-6 flex items-center justify-between">
     <h2 class="text-2xl font-bold uppercase">Add New Medication</h2>
     <x-heroicon-c-x-mark class="h-10 w-10 cursor-pointer" onclick="toggleCreateModal()" />
    </div>
    <form action="{{ route('medication.store') }}" method="POST">
     @csrf
     <div class="grid grid-cols-2 gap-4">
      <div>
       <label class="block font-bold text-gray-700">Name</label>
       <input class="mt-1 w-full rounded-md border px-2 py-1" name="name" type="text" required>
       @error('name')
        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
       @enderror
      </div>
      <div>
       <label class="block font-bold text-gray-700">Dosage</label>
       <input class="mt-1 w-full rounded-md border px-2 py-1" name="dosage" type="text" required>
       @error('dosage')
        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
       @enderror
      </div>
      <div>
       <label class="block font-bold text-gray-700">Frequency</label>
       <input class="mt-1 w-full rounded-md border px-2 py-1" name="frequency" type="text" required>
       @error('frequency')
        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
       @enderror
      </div>
      <div>
       <label class="block font-bold text-gray-700">Type</label>
       <select class="mt-1 w-full rounded-md border px-2 py-1" name="medicationType" required>
        <option value="tablet">Tablet</option>
        <option value="liquid">Liquid</option>
        <option value="injection">Injection</option>
        <option value="capsule">Capsule</option>
       </select>
       @error('medicationType')
        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
       @enderror
      </div>
      <div>
       <label class="block font-bold text-gray-700">Start Date</label>
       <input class="mt-1 w-full rounded-md border px-2 py-1" name="startDate" type="date" required>
       @error('startDate')
        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
       @enderror
      </div>
      <div>
       <label class="block font-bold text-gray-700">End Date</label>
       <input class="mt-1 w-full rounded-md border px-2 py-1" name="endDate" type="date" required>
       @error('endDate')
        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
       @enderror
      </div>
      <div class="col-span-2">
       <label class="block font-bold text-gray-700">Instructions</label>
       <textarea class="mt-1 w-full rounded-md border px-2 py-1" name="instructions" required></textarea>
       @error('instructions')
        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
       @enderror
      </div>
      <div class="col-span-2">
       <label class="flex items-center">
        <input class="mr-2" name="requiresFasting" type="checkbox">
        <span class="font-bold text-gray-700">Requires Fasting</span>
       </label>
      </div>
     </div>
     <div class="col-span-2 mt-4">
      <label class="block font-bold text-gray-700">Schedule</label>
      <div class="mt-2 grid grid-cols-2 gap-4">
       <div>
        <label class="block text-sm font-bold text-gray-700">Times</label>
        <div class="space-y-2">
         <div class="flex items-center gap-2">
          <input class="rounded-md border px-2 py-1" name="schedule[times][]" type="time" required>
          <button class="text-green-500" type="button" onclick="addTimeField()">
           <x-heroicon-m-plus class="h-5 w-5" />
          </button>
         </div>
         <div id="additional-times"></div>
        </div>
       </div>

       <div>
        <label class="block text-sm font-bold text-gray-700">Days of Week</label>
        <div class="grid grid-cols-2 items-center space-y-2">
         @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
          <label class="flex items-center">
           <input class="mr-2" name="schedule[daysOfWeek][]" type="checkbox" value="{{ $day }}">
           <span>{{ $day }}</span>
          </label>
         @endforeach
         @error('schedule.daysOfWeek')
          <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
         @enderror
        </div>
       </div>
      </div>
     </div>
     <div class="mt-6 flex justify-end gap-4">
      <button class="rounded-md bg-gray-200 px-4 py-2" type="button" onclick="closeModal()">Cancel</button>
      <button class="rounded-md bg-green-500 px-4 py-2 text-white" type="submit">Save Medication</button>
     </div>
    </form>
   </div>
  </div>
 </div>