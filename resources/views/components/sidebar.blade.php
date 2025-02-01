@props(['user'])

<!-- Hamburger Button -->
<button class="fixed mb-10 left-4 top-4 z-50 rounded-md bg-green-500 p-2 lg:hidden" id="hamburger">
 <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
 </svg>
</button>

<!-- Sidebar -->
<div class="fixed inset-y-0 left-0 z-40 flex h-screen w-64 -translate-x-full transform flex-col justify-between border-e bg-white transition duration-200 ease-in-out lg:relative lg:translate-x-0"
 id="sidebar">
 <button class="absolute right-4 top-4 rounded-md bg-green-500 p-2 lg:hidden" id="close-sidebar">
  <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
  </svg>
 </button>

 <div class="px-4 py-20 lg:py-6">
  <a href="{{route('dashboard')}}" class="grid h-14 w-full place-content-center rounded-md bg-green-500 text-2xl text-gray-600">
   <h1 class="font-extrabold text-slate-900">PLASU<span class="font-light text-zinc-100">Health</span></h1>
  </a>

  <ul class="mt-6 space-y-3">
   <x-nav-link :active="request()->is('dashboard')" icon="heroicon-s-home" link="/dashboard">
    Dashboard
   </x-nav-link>

   <x-nav-link :active="request()->is('medications*')" icon="gmdi-medication-liquid-r" link="/medications">
    My Medications
   </x-nav-link>

   <x-nav-link :active="request()->is('schedule*')" icon="healthicons-f-i-schedule-school-date-time" link="/schedule">
    Schedule
   </x-nav-link>

   <x-nav-link :active="request()->is('notifications*')" icon="heroicon-o-bell" link="/notifications">
    @if ($user->unreadNotifications->count() === 0)
        Notifications
    @else
        Notifications({{ $user->unreadNotifications->count() }})
    @endif
   </x-nav-link>

   <x-nav-link :active="request()->is('settings*')" icon="gmdi-settings" link="/settings">
    Settings
   </x-nav-link>
  </ul>
 </div>

 <!-- Keep existing profile section -->
 <div class="sticky inset-x-0 border-gray-100">
  <form class="mx-4 my-8" action="{{route('logout')}}" method="post">
   <button class="flex w-full items-center justify-between rounded-lg bg-slate-200 px-4 py-2 hover:bg-green-600" type="submit">
    <p class="text-sm font-medium">Logout</p>
    <x-gmdi-logout-r class="h-6 w-5" />
   </button>
  </form>

  <a class="flex items-center gap-2 bg-slate-200 p-4 hover:bg-slate-800 hover:text-white" href="#">
   <img class="size-10 rounded-full object-cover" src="{{ asset('images/profile.jpg') }}" alt="" />

   <div>
    <p class="text-sm">
     <strong class="block font-bold">{{ $user->name }}</strong>
     <span>{{ $user->email }}</span>
    </p>
   </div>
  </a>
 </div>
</div>

<!-- Overlay -->
<div class="fixed inset-0 z-30 hidden bg-black opacity-50 lg:hidden" id="sidebar-overlay"></div>
