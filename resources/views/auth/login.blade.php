<x-layout>
    <x-slot:title>Login</x-slot:title>
	<div class="flex h-full min-h-screen w-full items-center justify-center bg-slate-100">
		<div class="px-8 w-full md:w-8/12 lg:w-5/12">
			<x-logo />
			<form class="mt-8" method="POST" action="{{ route('login') }}">
				@csrf

				<!-- Email Address -->
				<div>
					<x-input-label for="email" :value="__('Email')" />
					<x-text-input class="mt-1 block w-full" id="email" name="email" type="email" :value="old('email')" required autofocus autocomplete="username" />
					<x-input-error class="mt-2" :messages="$errors->get('email')" />
				</div>

				<!-- Password -->
				<div class="mt-4">
					<x-input-label for="password" :value="__('Password')" />

					<x-text-input class="mt-1 block w-full" id="password" name="password" type="password" required autocomplete="current-password" />

					<x-input-error class="mt-2" :messages="$errors->get('password')" />
				</div>

				<!-- Remember Me -->
				<div class="mt-4 block">
					<label class="inline-flex items-center" for="remember_me">
						<input class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" id="remember_me" name="remember" type="checkbox">
						<span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
					</label>
				</div>

				<div class="mt-4 flex items-center justify-end">
					<x-primary-button>
						{{ __('Log in') }}
					</x-primary-button>
				</div>
			</form>
		</div>
	</div>
</x-layout>
