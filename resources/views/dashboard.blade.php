<x-layout>
 <x-slot:title>Dashboard</x-slot:title>
 <x-sidebar :$user />

 <div class="flex-grow mx-2 sm:mx-4 my-20 sm:my-24 lg:my-5 max-w-full">
  <div class="header">
   <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Welcome to your screen, <span class="text-green-600">{{ $user->name }}</span>!</h1>
  </div>

  <div class="cards my-4 sm:my-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-10">
    <div class="card flex items-center gap-4 sm:gap-7 rounded-lg bg-green-50 px-4 sm:px-6 py-3 sm:py-4">
      <div class="h-5 sm:h-6 w-5 sm:w-6 rounded-full bg-green-500"></div>
      <div>
        <div class="card-header">
          <h2 class="text-lg sm:text-xl font-bold uppercase text-slate-900">Completed</h2>
        </div>
        <div class="card-body text-start">
          <p class="text-lg sm:text-xl text-slate-900">{{ $medications->where('status', 'completed')->count() }}</p>
        </div>
      </div>
    </div>

    <div class="card flex items-center gap-4 sm:gap-7 rounded-lg bg-yellow-50 px-4 sm:px-6 py-3 sm:py-4">
      <div class="h-5 sm:h-6 w-5 sm:w-6 rounded-full bg-yellow-500"></div>
      <div>
        <div class="card-header">
          <h2 class="text-lg sm:text-xl font-bold uppercase text-slate-900">Active</h2>
        </div>
        <div class="card-body text-start">
          <p class="text-lg sm:text-xl text-slate-900">{{ $medications->where('status', 'active')->count() }}</p>
        </div>
      </div>
    </div>

    <div class="card flex items-center gap-4 sm:gap-7 rounded-lg bg-red-50 px-4 sm:px-6 py-3 sm:py-4">
      <div class="h-5 sm:h-6 w-5 sm:w-6 rounded-full bg-red-500"></div>
      <div>
        <div class="card-header">
          <h2 class="text-lg sm:text-xl font-bold uppercase text-slate-900">Inactive</h2>
        </div>
        <div class="card-body text-start">
          <p class="text-lg sm:text-xl text-slate-900">{{ $medications->where('status', 'inactive')->count() }}</p>
        </div>
      </div>
    </div>
  </div>

  <div class="upcoming-medications mt-20 sm:mt-10">
    <h2 class="text-xl sm:text-2xl font-bold mb-3 sm:mb-4">Upcoming Medications</h2>
    <div class="grid gap-3 sm:gap-4">
      @foreach($medications->where('status', 'active')->sortBy('startDate') as $medication)
        <div class="bg-white p-3 sm:p-4 shadow-lg">
          <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-2 sm:gap-0">
            <h3 class="font-semibold text-base sm:text-lg">{{ $medication->name }}</h3>
            <div class="text-xs sm:text-sm text-gray-600">
              Times:
              @foreach($medication->schedule['times'] as $time)
                <span class="ml-1 sm:ml-2">{{ $time }}</span>
              @endforeach
            </div>
          </div>
          <p class="text-sm sm:text-base text-gray-600">{{ $medication->dosage }} - {{ $medication->frequency }}</p>
          <p class="text-xs sm:text-sm text-gray-500 mt-1">{{ $medication->instructions }}</p>
        </div>
      @endforeach
    </div>
  </div>
 </div>
</x-layout>
