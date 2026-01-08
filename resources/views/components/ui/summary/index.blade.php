@props(['headerTitle' => 'Summary'])
<div class="flex flex-col gap-3 w-full h-full px-5 py-[30px] overflow-auto break-words bg-white rounded-[20px] border-[1.5px] border-rp-neutral-100">
    @if (!empty($actionHeader))
        {{ $actionHeader }}
    @else
        <h1 class="text-2xl font-bold text-rp-neutral-700 mb-10">{{ __($headerTitle) }}</h1>
    @endif


    @if (!empty($profile))
        <div>
            {{ $profile }}
        </div>
    @endif

    <div class=" bg-white flex flex-col gap-9 rounded-2xl w-full">
        {{ $body }}
    </div>

    @if (!empty($action))
        <div class="mt-auto">
            {{ $action }}
        </div>
    @endif

    {{-- @if (!empty($footer))
        <div class="mt-3">
            {{ $footer }}
        </div>
    @endif --}}
</div>