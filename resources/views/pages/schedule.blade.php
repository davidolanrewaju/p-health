<x-layout>
 <x-slot:title>PH - Schedule</x-slot:title>
 <x-sidebar :$user />

 @php
  $currentDate = now();
  //   $daysInMonth = Carbon\Carbon::now()->daysInMonth;
  //   $firstDayOfMonth = Carbon\Carbon::now()->startOfMonth()->dayOfWeek;
  $daysInMonth = $currentDate->daysInMonth;
  $firstDayOfMonth = $currentDate->copy()->startOfMonth()->dayOfWeek;
  $weeks = [];
  $week = [];

  // Add empty days for the first week
  for ($i = 0; $i < $firstDayOfMonth; $i++) {
      $week[] = null;
  }

  // Build the calendar array
  for ($day = 1; $day <= $daysInMonth; $day++) {
      $week[] = $day;

      if (count($week) === 7) {
          $weeks[] = $week;
          $week = [];
      }
  }

  // Fill the last week with empty days if needed
  while (count($week) < 7 && !empty($week)) {
      $week[] = null;
  }
  if (!empty($week)) {
      $weeks[] = $week;
  }

  // Helper function to get medications for a specific day
  function getDayMedications($medications, $day)
  {
      return $medications->filter(function ($medication) use ($day) {
          $scheduleDate = Carbon\Carbon::parse($medication->startDate);
          return $scheduleDate->day === $day && in_array(Carbon\Carbon::now()->setDay($day)->format('l'), $medication->schedule['daysOfWeek']);
      });
  }
 @endphp

 <div class="mx-4 my-24 max-w-full flex-grow overflow-auto lg:my-5">
  <div class="header">
   <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">Your Schedule</h1>
  </div>

  <div class="flex items-center justify-between border-b px-6 py-4">
   <h2 class="text-lg font-semibold text-gray-900">
    {{ $currentDate->format('F Y') }}
   </h2>
   <div class="flex space-x-4">
    <a class="p-2 text-gray-600 hover:text-gray-900" href="?month={{ $currentDate->copy()->subMonth()->format('Y-m') }}">
     <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
     </svg>
    </a>
    <a class="p-2 text-gray-600 hover:text-gray-900" href="?month={{ $currentDate->copy()->addMonth()->format('Y-m') }}">
     <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
     </svg>
    </a>
   </div>
  </div>

  <div class="grid grid-cols-7 gap-px bg-gray-200">
   <!-- Days of Week Headers -->
   @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayHeader)
    <div class="bg-gray-50 py-2 text-center text-sm font-semibold text-gray-900">
     {{ $dayHeader }}
    </div>
   @endforeach

   <!-- Calendar Days -->
   @foreach ($weeks as $week)
    @foreach ($week as $day)
     <div class="{{ $day === $currentDate->day ? 'bg-blue-50' : '' }} relative min-h-[120px] bg-white p-2">
      @if ($day)
       <span class="{{ $day === $currentDate->day ? 'font-bold' : '' }} text-sm">
        {{ $day }}
       </span>
       <div class="mt-2">
        @foreach (getDayMedications($medications, $day) as $medication)
         <div
          class="{{ $medication->status === 'active' ? 'bg-yellow-100 text-yellow-800' : ($medication->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }} mb-1 rounded px-2 py-1 text-xs"
          title="{{ $medication->instructions }}">
          <div class="font-semibold">{{ $medication->name }}</div>
          <div>{{ $medication->dosage }}</div>
          @foreach ($medication->schedule['times'] as $time)
           <div class="text-xs">{{ \Carbon\Carbon::parse($time)->format('g:i A') }}</div>
          @endforeach
         </div>
        @endforeach
       </div>
      @endif
     </div>
    @endforeach
   @endforeach
  </div>
 </div>
</x-layout>
