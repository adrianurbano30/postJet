@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block px-3 py-2 text-base font-medium  rounded-md bg-gray-700 text-white'
            : 'block px-3 py-2 text-base font-medium  rounded-md hover:bg-gray-700 text-gray-700 transition duration-700';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
