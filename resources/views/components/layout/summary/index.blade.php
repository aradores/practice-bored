@props(['headerTitle' => 'Summary'])
<div class="min-w-[35%] max-w-[35%] w-[35%] h-full px-5 py-[30px] overflow-auto break-words">
    @if (!empty($actionHeader))
        {{ $actionHeader }}
    @else
        <h1 class="text-[23.04px] font-bold text-rp-neutral-700 mb-10">{{ __($headerTitle) }}</h1>
    @endif


    @if (!empty($profile))
        <div>
            {{ $profile }}
        </div>
    @endif

    <div class="p-9 bg-white flex flex-col gap-9 rounded-2xl w-full">
        {{ $body }}
    </div>

    @if (!empty($action))
        <div class="mt-10">
            {{ $action }}
        </div>
    @endif

    @if (!empty($footer))
        <div class="mt-3">
            {{ $footer }}
        </div>
    @endif
</div>