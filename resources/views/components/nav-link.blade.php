@props(['active' => false, 'icon', 'link' => '#'])

<li class="{{ $active ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }} flex items-center gap-4 rounded-lg px-4 py-2"
    @if ($active) aria-current="page" @endif>
    @if ($icon)
        <x-dynamic-component class="h-5 w-5 text-green-700" :component="$icon" />
    @endif
    <a class="block text-sm font-medium" href="{{ $link }}">
        {{ $slot }}
    </a>
</li>
