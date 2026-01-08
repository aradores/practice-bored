@props([
    'label' => '',
    'data' => ''
])
<div {{ $attributes->merge(['class' => "text-sm flex flex-col-reverse lg:flex-row justify-between gap-2 py-2 [&:not(:last-child)]:border-b [&:not(:last-child)]:border-rp-neutral-100 w-full"]) }}>
    <p {{ $label->attributes->merge(['class' => "xl:w-2/5 break-words"]) }}>{{ $label }}</p>
    <p {{ $data->attributes->merge(['class' => "text-rp-neutral-600 font-bold w-3/5 break-words text-left lg:text-right" ]) }}>{{ $data }}</p>
</div>