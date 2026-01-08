@props(['has_error' => false])

@php
    if ($has_error) {
        $style = "bg-red-100";
    } else {
        $style = "odd:bg-transparent even:bg-white";
    }
@endphp

<tr {{ $attributes->merge(['class' => "$style break-words overflow-hidden"]) }}>
    {{ $slot }} 
</tr>