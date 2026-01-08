<div class="flex flex-col gap-3 pb-5 border-b border-[#BBC5CD]" x-data="{
    show_add_faq_modal: $wire.entangle('show_add_faq_modal').live,
    show_delete_faq_modal: $wire.entangle('show_delete_faq_modal').live,
}">
    <div class="flex flex-row items-center gap-2.5">
        <h2 class="text-primary-600 font-bold text-xl" wire:ignore>{{ $title }}</h2>
        <button type="button" wire:click="showAddFaqModal">
            <x-icon.add-filled />
        </button>
    </div>
    @foreach ($this->faqs as $faq)
        <div class="bg-rp-neutral-50 rounded-2xl p-4 w-full flex flex-col gap-1 text-rp-neutral-600">
            <div class="flex flex-row justify-between items-center">
                <div class="font-bold">{{ $faq->question }}</div>
                <div class="flex flex-row gap-2.5">
                    <button type="button" wire:click="showAddFaqModal({{ $faq->id }})">
                        <x-icon.edit />
                    </button>
                    <button type="button" wire:click="showDeleteFaqModal({{ $faq->id }})">
                        <x-icon.close />
                    </button>
                </div>
            </div>
            <p>{!! nl2br(htmlspecialchars($faq->answer)) !!}</p>
        </div>
    @endforeach
    @if ($show_add_faq_modal)
        <template x-teleport="body">
            <x-modal x-model="show_add_faq_modal">
                <x-modal.form-modal title="{{ $selected_faq_id ? 'Edit' : 'Add' }} FAQ" class="!gap-8 !w-[761px] !p-10">
                    <div>
                        <x-input.input-group class="mb-6">
                            <x-slot:label><span class="text-red-500 mr-1">*</span>Question</x-slot:label>
                            <x-input type="text" wire:model="question" />
                            @error('question')
                                <p class="text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </x-input.input-group>

                        <x-input.input-group>
                            <x-slot:label><span class="text-red-500 mr-1">*</span>Answer</x-slot:label>
                            <x-input.textarea wire:model='answer' maxlength="1000" rows="7" />
                            @error('answer')
                                <p class="text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </x-input.input-group>
                    </div>
                    <x-slot:action_buttons>
                        <x-button.outline-button color="primary" class="grow" @click="$wire.dispatch('closeModal')">
                            cancel
                        </x-button.outline-button>
                        <x-button.filled-button color="primary" class="grow" wire:click="addFaq">
                            confirm
                        </x-button.filled-button>
                    </x-slot:action_buttons>
                </x-modal.form-modal>
            </x-modal>
        </template>
    @elseif ($show_delete_faq_modal)
        <template x-teleport="body">
            <x-modal x-model="show_delete_faq_modal">
                <x-modal.form-modal title="Delete this FAQ" :showCloseButton="false" class="!gap-0 !w-[447px] !p-6">
                    <p class="text-center mt-3 mb-8">
                        Are you sure you want to delete this FAQ? This cannot be undone.
                    </p>
                    <x-slot:action_buttons>
                        <x-button.outline-button color="primary" class="grow" @click="$wire.dispatch('closeModal')">
                            go back
                        </x-button.outline-button>
                        <x-button.filled-button color="primary" class="grow" wire:click="deleteFaq">
                            confirm
                        </x-button.filled-button>
                    </x-slot:action_buttons>
                </x-modal.form-modal>
            </x-modal>
        </template>
    @endif
</div>
