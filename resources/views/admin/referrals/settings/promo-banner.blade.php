<div class="flex flex-col gap-3 pb-5 border-b border-[#BBC5CD]" x-data="image_{{ $type }}">
    <h2 class="text-primary-600 font-bold text-xl mb-3" wire:ignore>{{ $title }}<span class="inline-block">{{ $dimensions_guide }}</span></h2>
    <div class="flex flex-col">
        <div class="text-rp-neutral-500">Upload Image</div>
        @if ($this->media_image)
            <div class="bg-rp-neutral-50 rounded-xl p-4 text-rp-neutral-600 grid grid-cols-2 items-center"
                @drop.prevent="drop" @dragover.prevent x-bind:class="dropingFile ? ' !bg-rp-neutral-200' : ''"
                x-on:drop="dropingFile = false" x-on:dragover.prevent="dropingFile = true"
                x-on:dragleave.prevent="dropingFile = false">
                <div class="flex flex-row gap-4">
                    <div class="w-[120px] h-[80px] rounded-[4px] overflow-hidden">
                        <img src="{{ $this->media_image_url }}" alt="{{ $title }}"
                            class="w-full h-full object-cover">
                    </div>
                    <div class="flex flex-col text-sm">
                        <div class="font-bold">{{ $this->media_image->file_name }}</div>
                        <div>{{ $this->media_file_size }}</div>
                    </div>
                </div>
                <div class="justify-self-end flex flex-row gap-2">
                    <button type="button" @click="$refs.uploadImage.click();">
                        <x-icon.edit-image />
                    </button>
                    <button type="button" wire:click="removeImage">
                        <x-icon.trash />
                    </button>
                </div>
            </div>
        @else
            <div class="p-10 bg-rp-neutral-50 shadow-custom-inset rounded-lg border border-rp-neutral-200 flex flex-col items-center gap-4"
                @drop.prevent="drop" @dragover.prevent x-bind:class="dropingFile ? ' !bg-rp-neutral-200' : ''"
                x-on:drop="dropingFile = false" x-on:dragover.prevent="dropingFile = true"
                x-on:dragleave.prevent="dropingFile = false">
                <x-icon.upload />
                <div class="text-rp-neutral-600 font-bold">Drag and drop image file to upload</div>
                <x-button.filled-button color="primary-reverse" @click="$refs.uploadImage.click();"
                    class="w-[169px] !border-0">
                    add images
                </x-button.filled-button>
            </div>
        @endif
        <input wire:model="uploaded_image" type="file" x-ref="uploadImage" class="hidden"
            accept="image/png, image/jpeg">
        @error('uploaded_image')
            <p class="text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>
</div>
@script
    <script>
        Alpine.data('image_{{ $type }}', () => ({
            dropingFile: false,
            drop(e) {
                if (event.dataTransfer.files.length > 0) {
                    const file = e.dataTransfer.files[0];
                    this.uploadFile(file)
                }
            },
            uploadFile(file) {
                this.$wire.upload('uploaded_image', file);
            }
        }));
    </script>
@endscript
