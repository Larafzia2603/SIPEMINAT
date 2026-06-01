@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center w-full px-4 py-3 text-base font-medium text-primary-700 bg-primary-50 rounded-lg transition-all duration-200'
            : 'flex items-center w-full px-4 py-3 text-base font-medium text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-all duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
