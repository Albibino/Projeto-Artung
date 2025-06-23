@props(['href' => null])

@if($href)
    <a
        href="{{ $href }}"
        {{ $attributes->merge([
            'class' => 'inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-gray-400 transition'
        ]) }}>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15 19l-7-7 7-7" />
        </svg>
        <span>{{ $slot ?? 'Voltar' }}</span>
    </a>
@else
    <button
        type="button"
        onclick="window.history.back()"
        {{ $attributes->merge([
            'class' => 'inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-gray-400 transition'
        ]) }}>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15 19l-7-7 7-7" />
        </svg>
        <span>{{ $slot ?? 'Voltar' }}</span>
    </button>
@endif