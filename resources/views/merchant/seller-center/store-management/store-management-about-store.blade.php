<div class="pt-8">
    <div class="flex items-center gap-5 mb-5">
        <h1 class="text-rp-neutral-700 text-[28px] font-bold">About Store</h1>
        @if ($can_update)
            {{-- EDIT FEATURED ABOUT SECTION BUTTON --}}
            <div class="h-[25px]">
                <button @click="$wire.showAboutModal=true">
                    <x-icon.edit />
                </button>
            </div>
        @endif
    </div>

    {{-- DEFAULT STORE BANNER --}}
    @if ($banner_image = $this->description_banner())
        <img class="object-cover h-[44rem] max-h-[44rem] w-full mb-8 rounded-lg"
            src="{{ $banner_image['image'] }}" alt="description_banner">
    @endif

    {{-- STORE DESCRIPTION --}}
    @if ($this->merchant_description)
        <p class="break-all text-start text-rp-neutral-600">
            {!! nl2br(htmlspecialchars($this->merchant_description)) !!}
        </p>
    @else
        <p class="italic">
            No description added ...
        </p>
    @endif

    {{-- ABOUT STORE MODAL --}}
    <x-modal x-model="$wire.showAboutModal" aria-modal="true">
        <x-modal.form-modal title="About Store" class="w-[720px]" @click.outside="$wire.showAboutModal = false">
            <div class="space-y-3">
                {{-- Image Upload Input --}}
                <x-input.input-group>
                    <x-slot:label><span class="text-[#F0146C]">*</span>Banner Image</x-slot:label>
                    <livewire:components.input.interactive-upload-images :uploaded_images="$banner" :max="1"
                        function="updateDescriptionBanner" deleteFunction="updateDeleteDescriptionImage" :key="'upload-image-description-banner'" />
                </x-input.input-group>

                <x-input.input-group>
                    <x-slot:label><span class="text-[#F0146C]">*</span>Description</x-slot:label>

                    <x-input.textarea x-ref="description" name="" id="" cols="30" rows="10"
                        maxlength="1200" wire:model='description' />
                    <p class="text-right text-[11px]"><span x-html="$wire.description.length"></span>/<span
                            x-html="$refs.description.maxLength"></span></p>

                </x-input.input-group>
            </div>
            <x-slot:action_buttons>
                <x-button.outline-button class="w-1/2"
                    @click="$wire.showAboutModal=false">cancel</x-button.outline-button>
                <x-button.filled-button class="w-1/2" wire:click="save"
                    wire:target="save">submit</x-button.filled-button>
            </x-slot:action_buttons>
        </x-modal.form-modal>
    </x-modal>
</div>
