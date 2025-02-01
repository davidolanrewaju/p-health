<x-layout>
	<x-slot:title>Home</x-slot:title>


	<div class="flex h-full min-h-screen w-full items-center justify-center bg-slate-100">
		<div class="w-full px-4 text-center md:w-8/12 lg:w-5/12">
			<h1 class="text-4xl font-extralight text-slate-900 md:text-6xl">Welcome to <span class="font-extrabold text-green-500">PLASU</span> <span class="font-light text-zinc-500">Health</span>!</h1>
			<div class="mt-10 flex flex-col items-center justify-center gap-5 md:flex-row">
				<a class="rounded-full block border-2 w-40 md:w-52 border-green-500 px-8 py-2 md:px-10 md:py-3 text-center text-lg md:text-xl uppercase text-green-500 hover:border-transparent hover:text-white hover:bg-green-800" href="{{ route('login') }}">Log In</a>
				<a class="rounded-full block border-2 border-transparent w-40 md:w-52 bg-green-500 px-8 py-2 md:px-10 md:py-3 text-center text-lg md:text-xl uppercase text-white hover:bg-green-800" href="{{ route('register') }}">Register</a>
			</div>
            <div class="google flex items-center justify-center my-8">
               <a href="{{route('google.login')}}" class="px-4 flex items-center gap-4 border rounded-full border-gray-400">
                <img src="{{asset('images/google.svg')}}" alt="google" width="50px" height="50px">
                <span class="uppercase">Login with Google</span>
               </a> 
            </div>
		</div>
	</div>
</x-layout>
