@props(['type' => 'info'])

@php
    $classes = match($type) {
        'success' => 'bg-green-100 border-green-500 text-green-700',
        'danger' => 'bg-red-100 border-red-500 text-red-700',
        'warning' => 'bg-yellow-100 border-yellow-500 text-yellow-700',
        'info' => 'bg-blue-100 border-blue-500 text-blue-700',
        default => 'bg-gray-100 border-gray-500 text-gray-700',
    };
@endphp

<div {{ $attributes->merge(['class' => "border-l-4 p-4 rounded-md $classes"]) }}>
    <p>{{ $slot }}</p>
</div>
