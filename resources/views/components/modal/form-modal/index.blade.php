@props(['title', 'subtitle' => null, 'showCloseButton' => true])

<div
    {{ $attributes->merge(['class' => 'absolute flex flex-col gap-8 bg-white p-10 rounded-2xl w-[600px] max-w-[90%] max-h-[95%] overflow-y-auto']) }}>
    {{-- CLOSE BUTTON --}} {{-- visible is accessible from the modal component --}}
    @if ($showCloseButton)
        <button class="absolute top-6 right-6" @click="$dispatch('closeModal');visible=false">
            <x-icon.close-no-border />
        </button>
    @endif
    @if (!empty($title))
        <div>
            <h3 class="text-2xl font-bold {{ $showCloseButton ? 'text-left' : 'text-center' }}">{{ $title }}</h3>
            @if (isset($subtitle) && !empty($subtitle))
                <p>{{ $subtitle }}</p>
            @endif
        </div>
    @endif
    <div class="">
        {{ $slot }}
    </div>
    <div class="w-full flex flex-row gap-2">
        @if (isset($action_buttons) && $action_buttons->isNotEmpty())
            {{ $action_buttons }}
        @endif
    </div>
</div>
