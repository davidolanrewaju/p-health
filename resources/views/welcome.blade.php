<x-layout>
	<x-slot:title>Home</x-slot:title>


	<div class="flex h-full min-h-screen w-full items-center justify-center bg-slate-100">
		<div class="w-full px-4 text-center md:w-8/12 lg:w-5/12">
			<h1 class="text-4xl font-extralight text-slate-900 md:text-6xl">Welcome to <span class="font-extrabold text-green-500">PLASU</span> <span class="font-light text-zinc-500">Health</span>!</h1>
			<div class="mt-10 flex flex-col items-center justify-center gap-5 md:flex-row">
				<a class="block border-2 w-40 border-green-500 px-8 py-2 md:px-10 md:py-3 text-center text-lg uppercase text-green-500 hover:border-transparent hover:text-white hover:bg-green-800" href="{{ route('login') }}">Log In</a>
				<a class="block border-2 border-transparent w-40 bg-green-500 px-8 py-2 md:px-10 md:py-3 text-center text-lg uppercase text-white hover:bg-green-800" href="{{ route('register') }}">Register</a>
			</div>
		</div>
	</div>
</x-layout>
