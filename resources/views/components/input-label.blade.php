@props(['value'])

<label {{ $attributes->merge(['class' => 'font-quicksand block font-bold text-sm text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>
