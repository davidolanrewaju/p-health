<x-layout>
 <x-slot:title>Notifications</x-slot:title>
 <x-sidebar :user="$user" />

 <div class="flex-grow">
  <div class="mx-4 my-24 max-w-full lg:my-5">
   <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
    <div>
     <h1 class="text-2xl font-bold text-slate-900 lg:text-3xl">Notifications</h1>
    </div>
    <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
     @csrf
     <button class="rounded-md bg-gray-200 px-3 py-2 text-sm lg:px-4 lg:text-base" type="submit">
      <p>Mark All as Read</p>
     </button>
    </form>

   </div>

   <div class="mt-6 space-y-4">
    @forelse ($notifications as $notification)
     <div class="{{ $notification->read_at ? 'bg-gray-200' : 'bg-white' }} flex items-center justify-between p-4 shadow">
      <div class="flex-1">
       <p class="text-gray-800">{{ $notification->data['details'] }}</p>
       <span class="text-sm text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
      </div>
      @if (!$notification->read_at)
       <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
        @csrf
        <button class="ml-4 rounded-md bg-green-400 px-3 py-1 text-sm text-white hover:bg-green-600" type="submit">
         Mark as Read
        </button>
       </form>
      @endif
      <form action="{{ route('notifications.delete', $notification->id) }}" method="POST">
       @csrf
       @method('DELETE')
       <button class="ml-4 rounded-md bg-red-400 px-3 py-1 text-sm text-white hover:bg-red-600" type="submit">
        Delete
       </button>
      </form>
     </div>
    @empty
     <p class="flex items-center justify-center text-center text-gray-500">No notifications found</p>
    @endforelse
   </div>
  </div>
 </div>
</x-layout>
