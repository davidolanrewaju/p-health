{{-- {{ dump($errors->all()) }} --}}
@props(['medication'])
<div class="fixed inset-0 z-50 hidden overflow-y-auto" id="editModal">
 <div class="mx-auto my-4 flex min-h-screen items-center justify-center px-4 lg:my-20">
  <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

  <div class="relative w-full max-w-2xl rounded-lg bg-white p-4 lg:p-8">
   <div class="mb-6 flex items-center justify-between">
    <h2 class="text-2xl font-bold uppercase">Edit Medication</h2>
    <x-heroicon-c-x-mark class="h-10 w-10 cursor-pointer" onclick="toggleEditModal()" />
   </div>
   <form action="{{ route('medication.update', $medication->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="grid grid-cols-2 gap-4">
     <div>
      <label class="block font-bold text-gray-700">Name</label>
      <input class="mt-1 w-full rounded-md border px-2 py-1" name="name" type="text" value="{{ old('name', $medication->name) }}">
      @error('name')
       <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
      @enderror
     </div>

     <div>
      <label class="block font-bold text-gray-700">Dosage</label>
      <input class="mt-1 w-full rounded-md border px-2 py-1" name="dosage" type="text" value="{{ old('dosage', $medication->dosage) }}">
      @error('dosage')
       <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
      @enderror
     </div>

     <div>
      <label class="block font-bold text-gray-700">Frequency</label>
      <input class="mt-1 w-full rounded-md border px-2 py-1" name="frequency" type="text" value="{{ old('frequency', $medication->frequency) }}">
      @error('frequency')
       <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
      @enderror
     </div>

     <div>
      <label class="block font-bold text-gray-700">Type</label>
      <select class="mt-1 w-full rounded-md border px-2 py-1" name="medicationType">
       <option value="tablet" {{ old('medicationType', $medication->medicationType) == 'tablet' ? 'selected' : '' }}>Tablet</option>
       <option value="liquid" {{ old('medicationType', $medication->medicationType) == 'liquid' ? 'selected' : '' }}>Liquid</option>
       <option value="injection" {{ old('medicationType', $medication->medicationType) == 'injection' ? 'selected' : '' }}>Injection</option>
       <option value="capsule" {{ old('medicationType', $medication->medicationType) == 'capsule' ? 'selected' : '' }}>Capsule</option>
      </select>
      @error('medicationType')
       <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
      @enderror
     </div>

     <div>
      <label class="block font-bold text-gray-700">Start Date</label>
      <input class="mt-1 w-full rounded-md border px-2 py-1" name="startDate" type="date" value="{{ old('startDate', date('Y-m-d', strtotime($medication->startDate))) }}">
      @error('startDate')
       <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
      @enderror
     </div>

     <div>
      <label class="block font-bold text-gray-700">End Date</label>
      <input class="mt-1 w-full rounded-md border px-2 py-1" name="endDate" type="date" value="{{ old('endDate', date('Y-m-d', strtotime($medication->endDate))) }}">
      @error('endDate')
       <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
      @enderror
     </div>

     <div class="col-span-2">
      <label class="block font-bold text-gray-700">Instructions</label>
      <textarea class="mt-1 w-full rounded-md border px-2 py-1" name="instructions">{{ old('instructions', $medication->instructions) }}</textarea>
      @error('instructions')
       <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
      @enderror
     </div>

     <div class="col-span-2">
      <label class="flex items-center">
       <input class="mr-2" name="requiresFasting" type="checkbox" {{ old('requiresFasting', $medication->requiresFasting) ? 'checked' : '' }}>
       <span class="font-bold text-gray-700">Requires Fasting</span>
      </label>
      @error('requiresFasting')
       <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
      @enderror
     </div>

     @php
      $schedule = is_string($medication->schedule) ? json_decode($medication->schedule, true) : $medication->schedule;
      $selectedDays = $schedule['daysOfWeek'] ?? [];
      $times = $schedule['times'] ?? [];
     @endphp


     <div class="col-span-2 mt-4">
      <label class="block font-bold text-gray-700">Schedule</label>
      <div class="mt-2 grid grid-cols-2 gap-4">
       <div>
        <label class="block text-sm font-bold text-gray-700">Times</label>
        <div class="space-y-2">
         @foreach ($times as $index => $time)
          <div class="flex items-center gap-2">
           <input class="rounded-md border px-2 py-1" name="schedule[times][]" type="time" value="{{ old('schedule.times.' . $index, $time) }}">
           @if ($index === 0)
            <button class="text-green-500" type="button" onclick="addTimeField()">
             <x-heroicon-m-plus class="h-5 w-5" />
            </button>
           @endif
           @if ($index > 0)
            <button class="text-red-500" type="button" onclick="this.parentElement.remove()">
             <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
               d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
               clip-rule="evenodd" />
             </svg>
            </button>
           @endif
          </div>
         @endforeach
         <div id="additional-times"></div>
        </div>
        @error('schedule.times')
         <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
       </div>

       <div class="days-of-week">
        <label class="block text-sm font-bold text-gray-700">Days of Week</label>
        <div class="grid grid-cols-2 items-center space-y-2">
         @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
          <label class="flex items-center">
           <input class="mr-2" name="schedule[daysOfWeek][]" type="checkbox" value="{{ $day }}" {{ in_array($day, old('schedule.daysOfWeek', $selectedDays)) ? 'checked' : '' }}>
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

     <div class="col-span-2 mt-6 flex justify-end gap-4">
      <button class="rounded-md bg-gray-200 px-4 py-2" type="button" onclick="toggleEditModal()">Cancel</button>
      <button class="rounded-md bg-green-500 px-4 py-2 text-white" type="submit">Save Medication</button>
     </div>
   </form>
  </div>
 </div>
</div>
