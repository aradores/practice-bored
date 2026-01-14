<!-- resources/views/admin/components/forms/base-form.blade.php -->
<div>
    <!-- Form Content -->
    @yield('form-content')

    <!-- Confirmation Modal -->
    @if($showConfirmation)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4">
            <div class="w-full max-w-md rounded-lg bg-white shadow-lg">
                <!-- Modal Header -->
                <div class="border-b px-6 py-4">
                    <h3 class="text-lg font-semibold">{{ $confirmationTitle }}</h3>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-4">
                    <p class="text-gray-600">{{ $confirmationMessage }}</p>
                </div>

                <!-- Modal Footer -->
                <div class="border-t px-6 py-4 flex justify-end space-x-3">
                    <button
                        wire:click="cancel"
                        type="button"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition disabled:opacity-50"
                        wire:loading.attr="disabled"
                        wire:target="submit"
                    >
                        Cancel
                    </button>
                    <button
                        wire:click="submit"
                        type="button"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md transition disabled:opacity-50 flex items-center"
                        wire:loading.attr="disabled"
                        wire:target="submit"
                    >
                        <svg wire:loading wire:target="submit" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span wire:loading.remove wire:target="submit">Yes, Proceed</span>
                        <span wire:loading wire:target="submit">Processing...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Success/Error Messages -->
    @if($successMessage)
        <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-green-700">{{ $successMessage }}</p>
            </div>
        </div>
    @endif

    @if($errorMessage)
        <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-red-700">{{ $errorMessage }}</p>
            </div>
        </div>
    @endif
</div>
