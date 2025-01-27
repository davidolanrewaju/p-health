<x-layout>
	<x-slot name="title">Register</x-slot>
	<div class="flex h-full min-h-screen w-full items-center justify-center bg-slate-100">
		<div class="px-8 w-full md:w-8/12 lg:w-5/12">
			<x-logo />
			<form class="mt-8" method="POST" action="{{ route('register') }}">
				@csrf

				<!-- Name -->
				<div>
					<x-input-label for="name" :value="__('Name')" />
					<x-text-input class="mt-1 block w-full" id="name" name="name" type="text" :value="old('name')" required autofocus autocomplete="name" />
					<x-input-error class="mt-2" :messages="$errors->get('name')" />
				</div>

				<!-- Email Address -->
				<div class="mt-4">
					<x-input-label for="email" :value="__('Email')" />
					<x-text-input class="mt-1 block w-full" id="email" name="email" type="email" :value="old('email')" required autocomplete="username" />
					<x-input-error class="mt-2" :messages="$errors->get('email')" />
				</div>

				<!-- Password -->
				<div class="mt-4">
					<x-input-label for="password" :value="__('Password')" />

					<x-text-input class="mt-1 block w-full" id="password" name="password" type="password" required autocomplete="new-password" />

					<x-input-error class="mt-2" :messages="$errors->get('password')" />
				</div>

				<!-- Confirm Password -->
				<div class="mt-4">
					<x-input-label for="password_confirmation" :value="__('Confirm Password')" />

					<x-text-input class="mt-1 block w-full" id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" />

					<x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
				</div>

				<div class="mt-4 flex items-end justify-between">
					<a class="rounded-md text-sm text-gray-600 underline hover:text-gray-900" href="{{ route('login') }}">
						{{ __('Already registered?') }}
					</a>
					<x-primary-button>
						{{ __('Register') }}
					</x-primary-button>
				</div>
			</form>
		</div>
	</div>
</x-layout>
