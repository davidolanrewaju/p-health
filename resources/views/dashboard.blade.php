<x-layout>
	<x-slot:title>Dashboard</x-slot:title>
	<x-sidebar :name="$user->name" :email="$user->email" />

	<div class="m-4">
		<h1 class="text-3xl font-bold text-slate-900">Welcome to your screen, <span class="text-green-600">{{ $user->name }}</span>!</h1>
	</div>
</x-layout>
