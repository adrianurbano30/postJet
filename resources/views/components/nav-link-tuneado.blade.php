@props(['active'])

@php
$classes = ($active ?? false)
            ? 'text-base text-gray-700 font-bold  block px-4 py-2  rounded-lg border-2 border-gray-800 transition duration-700'
            : 'text-base text-gray-600 font-bold  hover:bg-gray-300 rounded-xl  hover:text-black  block px-4 py-2 transition duration-700';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
