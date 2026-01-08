<div class="fixed grid place-items-center inset-0 bg-black/20 z-50">
    <div class="max-w-[600px] w-[90%] px-[24px] py-[26px] space-y-4 bg-white rounded-2xl">
        <div class="flex justify-between items-center">
            <h3 class="text-xl font-semibold text-neutral-600">Upload Bulk Invoice</h3>
        </div>

        @if ($uploaded_file)
            <div class="flex flex-row justify-between items-center bg-white p-2">
                <div class="flex flex-row items-center">
                    <div class="ml-3 flex flex-col gap-1">
                        <span class="text-xs text-neutral-600">{{ $uploaded_file->getClientOriginalName() }}</span>
                        <span
                            class="text-[10px] text-neutral-300">{{ $this->format_file_size($uploaded_file->getSize()) }}</span>
                    </div>
                </div>
                <button type="button" wire:click="removeFile()">
                    <x-icon.trash fill="#5D5D5D" /></button>
            </div>
        @else
            <div class="rounded-lg bg-neutral-300 flex flex-col gap-2" x-data="dragDrop"
                @drop.prevent="drop" @dragover.prevent
                x-bind:class="dropingFile ? ' border border-rp-neutral-400 opacity-70' :
                    'bg-neutral-50'"
                x-on:drop="dropingFile = false" x-on:dragover.prevent="dropingFile = true"
                x-on:dragleave.prevent="dropingFile = false">
                <div class="flex flex-col gap-2 justify-center items-center h-36 border border-neutral-300 rounded-lg cursor-pointer"
                    tabindex="0" @keyup.enter="$refs.uploadFiles.click();" @click="$refs.uploadFiles.click();">
                    <x-icon.upload />
                    <p class="text-rp-neutral-400">Upload file here</p>
                    <input type="file" x-ref="uploadFiles" class="hidden" wire:model.live="uploaded_file"
                        accept=".xlsx">
                </div>
            </div>
        @endif

        <div class="flex flex-row text-sm gap-1 mt-3">
            <x-icon.important />
            <p>IMPORTANT: RePay follows a very specific format for uploading excel files.
                <br>Please use our formatted excel file in order to ensure a smooth process for uploading bulk invoices.
                <br><br>For bulk invoices with only single charge transactions,
                <span role="button" tabindex="0" @keyup.enter="$wire.downloadFormatSingleCharge"
                    class="underline font-semibold {{ $is_admin ? 'text-primary-600' : 'text-rp-dark-pink-600' }} cursor-pointer"
                    wire:click="downloadFormatSingleCharge">
                    download it here.
                </span>
                <br><br>For bulk invoices that has inclusions and multiple items,
                <span role="button" tabindex="0" @keyup.enter="$wire.downloadFormatMultipleItems"
                    class="underline font-semibold {{ $is_admin ? 'text-primary-600' : 'text-rp-dark-pink-600' }} cursor-pointer"
                    wire:click="downloadFormatMultipleItems">
                    download it here.
                </span>
            </p>
        </div>

        @error('uploaded_file')
            <p class="text-xs text-red-500">{{ $message }}</p>
        @enderror

        <div class="flex flex-row gap-1 pt-2">
            <x-button.outline-button color="{{ $is_admin ? 'primary' : 'red' }}" size="sm" class="w-1/2"
                wire:click="$dispatch('closeUploadInvoicesModal');">Cancel</x-button.outline-button>
            <x-button.filled-button color="{{ $is_admin ? 'primary' : 'red' }}" size="sm" class="w-1/2"
                wire:click="submitUploadedInvoice">Confirm</x-button.filled-button>
        </div>
    </div>

    <x-loader.black-screen wire:loading.delay.longer wire:target="submitUploadedInvoice" class="z-60" />
</div>
@script
    <script>
        Alpine.data('dragDrop', () => ({
            dropingFile: false,
            drop(e) {
                if (event.dataTransfer.files.length > 0) {
                    if (event.dataTransfer.files.length > 1) {
                        this.$dispatch('notify', {
                            title: "Only One File Allowed",
                            message: "You can only have one uploaded file in total.",
                            type: "warning"
                        });
                        return;
                    }
                    @this.upload('uploaded_file', e.dataTransfer.files[0])
                }
            }
        }));
    </script>
@endscript
