@props([
    'href'   => null,
    'type'   => 'button',
])

@php
    $baseClasses = 'inline-flex items-center px-4 py-2 bg-cyan-300 hover:bg-cyan-400 text-gray-800 font-semibold rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-gray-400 transition'
@endphp

@if($href)
    <a
        href="{{ $href }}"
        {{ $attributes->merge(['class' => $baseClasses]) }}
    >
        {{ $slot }}
    </a>
@else

    <button
        type="{{ $type }}"
        {{ $attributes->merge(['class' => $baseClasses]) }}
    >
        {{ $slot }}
    </button>
@endif
