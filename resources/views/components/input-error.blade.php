<!-- resources/views/components/input-error.blade.php -->
@if ($errors->has($for))
    <p {{ $attributes->merge(['class' => 'mt-1 text-sm text-red-600']) }}>
        {{ $errors->first($for) }}
    </p>
@endif
