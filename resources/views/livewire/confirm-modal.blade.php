<div style="color: red">
<div
    x-data="{ open: @entangle('show') }"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
>
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
        <h2 class="text-lg font-semibold mb-2">{{ $title }}</h2>

        <p class="text-gray-600 mb-6">
            {{ $message }}
        </p>

        <div class="flex justify-end space-x-3">
            <button
                wire:click="cancel"
                class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300"
            >
                {{ $cancelText }}
            </button>

            <button
                wire:click="confirm"
                class="px-4 py-2 rounded text-white {{ $confirmClass }}"
            >
                {{ $confirmText }}
            </button>
        </div>
    </div>
</div>


</div>
