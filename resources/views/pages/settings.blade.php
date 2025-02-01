<x-layout>
 <x-slot:title>PH - Settings</x-slot:title>
 <x-sidebar :$user />

 <div class="flex-grow mx-4 my-24 max-w-full lg:my-5">
  <h1 class="text-3xl font-bold">Settings</h1>

  <div class="google my-8">
   <a class="flex items-center gap-4 rounded-full border border-gray-400 px-4" href="{{ route('google.login') }}">
    <img src="{{ asset('images/google.svg') }}" alt="google" width="50px" height="50px">
    <span class="uppercase">Connect your Google Account</span>
   </a>
  </div>
 </div>
</x-layout>
