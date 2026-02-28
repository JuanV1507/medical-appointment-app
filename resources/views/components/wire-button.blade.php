@props([
    'href' => null,
    'type' => 'button',
    'color' => 'gray',
    'xs' => false,
])

@php
$baseClasses = 'inline-flex items-center justify-center rounded-md font-medium transition';

$sizes = [
    'xs' => 'px-2 py-1 text-xs',
    'default' => 'px-4 py-2 text-sm',
];

$colors = [
    'blue' => 'bg-blue-600 hover:bg-blue-700 text-white',
    'red' => 'bg-red-600 hover:bg-red-700 text-white',
    'gray' => 'bg-gray-600 hover:bg-gray-700 text-white',
];

$sizeClass = $xs ? $sizes['xs'] : $sizes['default'];
$colorClass = $colors[$color] ?? $colors['gray'];
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "$baseClasses $sizeClass $colorClass"]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => "$baseClasses $sizeClass $colorClass"]) }}>
        {{ $slot }}
    </button>
@endif