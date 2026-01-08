@push('headscripts')
    @vite('resources/js/qrCode.js')

    {{-- Drop In UI --}}
    <script src="https://pgw-ui.2c2p.com/sdk/js/pgw-sdk-4.2.1.js"></script>
    <link rel="stylesheet" href="https://pgw-ui.2c2p.com/sdk/css/pgw-sdk-style-4.2.1.css">
@endpush

<div x-data="hostedCheckout" class="h-full w-full flex flex-col gap-7 px-8 md:px-16 lg:px-20 xl:px-56 py-8">
    <div class="flex flex-row justify-between">
        <h1 class="text-primary-600 text-2xl font-bold">Checkout</h1>
        <button type="button" @click="isCancelPaymentModalVisible=true">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path
                    d="M14.1535 12.0008L19.5352 6.61748C19.6806 6.47704 19.7966 6.30905 19.8764 6.12331C19.9562 5.93757 19.9982 5.7378 19.9999 5.53565C20.0017 5.3335 19.9632 5.13303 19.8866 4.94593C19.8101 4.75883 19.697 4.58885 19.5541 4.44591C19.4111 4.30296 19.2412 4.18992 19.0541 4.11337C18.867 4.03682 18.6665 3.9983 18.4644 4.00006C18.2622 4.00181 18.0624 4.04381 17.8767 4.1236C17.691 4.20339 17.523 4.31937 17.3825 4.46478L11.9992 9.84654L6.61748 4.46478C6.47704 4.31937 6.30905 4.20339 6.12331 4.1236C5.93757 4.04381 5.7378 4.00181 5.53565 4.00006C5.3335 3.9983 5.13303 4.03682 4.94593 4.11337C4.75883 4.18992 4.58885 4.30296 4.44591 4.44591C4.30296 4.58885 4.18992 4.75883 4.11337 4.94593C4.03682 5.13303 3.9983 5.3335 4.00006 5.53565C4.00181 5.7378 4.04381 5.93757 4.1236 6.12331C4.20339 6.30905 4.31937 6.47704 4.46478 6.61748L9.84654 11.9992L4.46478 17.3825C4.31937 17.523 4.20339 17.691 4.1236 17.8767C4.04381 18.0624 4.00181 18.2622 4.00006 18.4644C3.9983 18.6665 4.03682 18.867 4.11337 19.0541C4.18992 19.2412 4.30296 19.4111 4.44591 19.5541C4.58885 19.697 4.75883 19.8101 4.94593 19.8866C5.13303 19.9632 5.3335 20.0017 5.53565 19.9999C5.7378 19.9982 5.93757 19.9562 6.12331 19.8764C6.30905 19.7966 6.47704 19.6806 6.61748 19.5352L11.9992 14.1535L17.3825 19.5352C17.523 19.6806 17.691 19.7966 17.8767 19.8764C18.0624 19.9562 18.2622 19.9982 18.4644 19.9999C18.6665 20.0017 18.867 19.9632 19.0541 19.8866C19.2412 19.8101 19.4111 19.697 19.5541 19.5541C19.697 19.4111 19.8101 19.2412 19.8866 19.0541C19.9632 18.867 20.0017 18.6665 19.9999 18.4644C19.9982 18.2622 19.9562 18.0624 19.8764 17.8767C19.7966 17.691 19.6806 17.523 19.5352 17.3825L14.1535 11.9992V12.0008Z"
                    fill="#647887" />
            </svg>
        </button>
    </div>

    @if ($stop_loading_payment == true && $isRedirectToMerchantModalVisible == false)
        <div class="flex flex-col items-center justify-center gap-6 text-neutral-800">
            <p class="text-center text-sm text-neutral-600">Processing your payment. Please refresh this page.</p>
            <x-button.filled-button color="primary" wire:click="checkQrPaymentStatus" wire:target="checkQrPaymentStatus"
                onclick="window.location.reload();" class="w-96 py-4 text-xl font-bold">
                Refresh
            </x-button.filled-button>
        </div>
    @else
        <div class="flex flex-row gap-8">
            {{-- Payment options --}}
            <div class="w-3/5 flex flex-col gap-4">
                {{-- QRPH --}}
                @if ($qr_code_data)
                    <div class="flex flex-col gap-6 rounded-lg shadow-small-dark px-4 py-4 border"
                        @click="$wire.set('paymentOption', 'qr')"
                        :class="{
                            'border border-primary-600': $wire.paymentOption === 'qr',
                            'border-transparent !hover:border-primary-600 hover:cursor-pointer': $wire
                                .paymentOption !== 'qr'
                        }">
                        <div class="p-3 flex flex-row items-center justify-between">
                            <div class="flex flex-row items-center gap-3">
                                <div class="p-2.5 bg-primary-600 rounded-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <g clip-path="url(#clip0_30911_18355)">
                                            <path
                                                d="M5.67195 0.03479C8.04349 -0.0060369 10.4311 0.019867 12.7982 0.0618202C13.8434 0.474031 14.7503 1.35871 15.6431 2.03756C15.288 2.27126 13.3362 4.05075 12.9323 4.0468C1.24504 4.25601 4.80278 2.32898 4.23925 14.5568C4.22731 14.7381 4.13875 14.9186 3.95998 14.976C2.94396 15.1137 1.59093 15.0808 0.572969 15.0295C0.203204 15.0016 0.0288705 14.8997 0 14.5024C0.00777283 11.1129 -0.0205425 7.71869 0.0532994 4.33681C0.257614 1.53046 3.04445 -0.27662 5.67195 0.03479Z"
                                                fill="white" />
                                            <path
                                                d="M20.0348 8.92591L23.5995 8.91943C24.0337 8.95998 23.9651 9.47102 23.9604 9.79932C23.9246 12.2596 23.909 14.7174 23.9312 17.1783C24.495 22.0263 21.5308 24.4857 16.9112 23.9198C15.7301 23.9077 14.5455 23.913 13.3643 23.9198C12.4793 23.9249 11.3653 24.1267 10.5728 23.6455L8.35447 21.9753C8.3256 21.937 8.5932 21.676 8.63484 21.6366C11.0069 18.839 14.8059 20.1037 17.9758 19.8391C18.8867 19.7971 19.6431 19.6718 19.7228 18.5836C19.7067 16.3043 19.7283 14.0205 19.7494 11.7449C19.8272 11.2176 19.4446 8.95181 20.0345 8.92563L20.0348 8.92591Z"
                                                fill="white" />
                                            <path
                                                d="M17.6559 11.9876C17.5279 19.5904 6.37808 19.589 6.25122 11.9876C6.37919 4.38508 17.5288 4.38621 17.6559 11.9876Z"
                                                fill="white" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_30911_18355">
                                                <rect width="24" height="24" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                                <span class="text-neutral-800 text-xl font-bold">QRPH</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <g clip-path="url(#clip0_30911_18355)">
                                        <path
                                            d="M5.67195 0.03479C8.04349 -0.0060369 10.4311 0.019867 12.7982 0.0618202C13.8434 0.474031 14.7503 1.35871 15.6431 2.03756C15.288 2.27126 13.3362 4.05075 12.9323 4.0468C1.24504 4.25601 4.80278 2.32898 4.23925 14.5568C4.22731 14.7381 4.13875 14.9186 3.95998 14.976C2.94396 15.1137 1.59093 15.0808 0.572969 15.0295C0.203204 15.0016 0.0288705 14.8997 0 14.5024C0.00777283 11.1129 -0.0205425 7.71869 0.0532994 4.33681C0.257614 1.53046 3.04445 -0.27662 5.67195 0.03479Z"
                                            fill="white" />
                                        <path
                                            d="M20.0348 8.92591L23.5995 8.91943C24.0337 8.95998 23.9651 9.47102 23.9604 9.79932C23.9246 12.2596 23.909 14.7174 23.9312 17.1783C24.495 22.0263 21.5308 24.4857 16.9112 23.9198C15.7301 23.9077 14.5455 23.913 13.3643 23.9198C12.4793 23.9249 11.3653 24.1267 10.5728 23.6455L8.35447 21.9753C8.3256 21.937 8.5932 21.676 8.63484 21.6366C11.0069 18.839 14.8059 20.1037 17.9758 19.8391C18.8867 19.7971 19.6431 19.6718 19.7228 18.5836C19.7067 16.3043 19.7283 14.0205 19.7494 11.7449C19.8272 11.2176 19.4446 8.95181 20.0345 8.92563L20.0348 8.92591Z"
                                            fill="white" />
                                        <path
                                            d="M17.6559 11.9876C17.5279 19.5904 6.37808 19.589 6.25122 11.9876C6.37919 4.38508 17.5288 4.38621 17.6559 11.9876Z"
                                            fill="white" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_30911_18355">
                                            <rect width="24" height="24" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                        </div>
                        <div class="flex flex-col gap-4" x-show="$wire.paymentOption === 'qr'">
                            <div class="flex flex-col items-center justify-center gap-6 text-neutral-800">
                                <span class="text-xl font-bold">Scan to Pay</span>
                                <div class="shadow-small-dark bg-[#F5F6F8] p-2" wire:ignore>
                                    <div id="canvas" class="rounded-lg"></div>
                                </div>
                                <p class="text-center text-sm text-neutral-600">
                                    Scan the QR Code using your banking app to complete the payment.
                                </p>
                                @if (app()->environment(['local', 'alpha']))
                                    <x-button.outline-button color="primary" wire:click="simulate_qr_payment"
                                         wire:target="simulate_qr_payment"
                                        wire:loading.attr="disabled" :disabled="$qr_pay_simulated">
                                        Simulate Payment
                                    </x-button.outline-button>
                                @endif
                                <x-button.filled-button color="primary" wire:click="checkQrPaymentStatus"
                                    wire:target="checkQrPaymentStatus" wire:loading.attr="disabled"
                                    class="w-96 py-4 text-xl font-bold">
                                    Check Status
                                </x-button.filled-button>
                            </div>
                            <div class="py-3 flex flex-row gap-2.5 justify-center items-center">
                                <span class="text-[10px]">Powered by:</span>
                                <img src="{{ url('/images/repay-logo-colored.svg') }}" class="object-contain h-5"
                                    alt="Repay Logo">
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Credit/Debit card --}}
                <div class="flex flex-col gap-6 rounded-lg border shadow-small-dark px-4 py-4"
                    @click="$wire.set('paymentOption', 'card')"
                    :class="{
                        'border border-primary-600': $wire.paymentOption === 'card',
                        'border-transparent !hover:border-primary-600 hover:cursor-pointer': $wire
                            .paymentOption !== 'card'
                    }">
                    <div class="p-3 flex flex-row items-center justify-between">
                        <div class="flex flex-row items-center gap-3">
                            <div class="p-2.5 bg-primary-600 rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17"
                                    viewBox="0 0 20 17" fill="none">
                                    <mask id="mask0_30880_11213" style="mask-type:luminance" maskUnits="userSpaceOnUse"
                                        x="-1" y="0" width="21" height="17">
                                        <path
                                            d="M12 0.5H8.00001C4.22901 0.5 2.34301 0.5 1.17201 1.672C0.328006 2.515 0.0920059 3.729 0.0260059 5.75H19.974C19.908 3.729 19.672 2.515 18.828 1.672C17.657 0.5 15.771 0.5 12 0.5ZM8.00001 16.5H12C15.771 16.5 17.657 16.5 18.828 15.328C19.999 14.156 20 12.271 20 8.5C20 8.05867 19.9993 7.642 19.998 7.25H0.00200594C5.93811e-06 7.642 -0.000660822 8.05867 5.84478e-06 8.5C5.84478e-06 12.271 5.72205e-06 14.157 1.17201 15.328C2.34401 16.499 4.22901 16.5 8.00001 16.5Z"
                                            fill="white" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M3.25 12.5C3.25 12.3011 3.32902 12.1103 3.46967 11.9697C3.61032 11.829 3.80109 11.75 4 11.75H8C8.19891 11.75 8.38968 11.829 8.53033 11.9697C8.67098 12.1103 8.75 12.3011 8.75 12.5C8.75 12.6989 8.67098 12.8897 8.53033 13.0303C8.38968 13.171 8.19891 13.25 8 13.25H4C3.80109 13.25 3.61032 13.171 3.46967 13.0303C3.32902 12.8897 3.25 12.6989 3.25 12.5ZM9.75 12.5C9.75 12.3011 9.82902 12.1103 9.96967 11.9697C10.1103 11.829 10.3011 11.75 10.5 11.75H12C12.1989 11.75 12.3897 11.829 12.5303 11.9697C12.671 12.1103 12.75 12.3011 12.75 12.5C12.75 12.6989 12.671 12.8897 12.5303 13.0303C12.3897 13.171 12.1989 13.25 12 13.25H10.5C10.3011 13.25 10.1103 13.171 9.96967 13.0303C9.82902 12.8897 9.75 12.6989 9.75 12.5Z"
                                            fill="black" />
                                    </mask>
                                    <g mask="url(#mask0_30880_11213)">
                                        <path d="M-2 -3.5H22V20.5H-2V-3.5Z" fill="#F5F6F8" />
                                    </g>
                                </svg>
                            </div>
                            <span class="text-neutral-800 text-xl font-bold">Credit/Debit card</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" x-show="$wire.paymentOption === 'card'">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.58 20 4 16.42 4 12C4 7.58 7.58 4 12 4C16.42 4 20 7.58 20 12C20 16.42 16.42 20 12 20Z"
                                    fill="#7F56D9" />
                                <path
                                    d="M12 17C14.7614 17 17 14.7614 17 12C17 9.23858 14.7614 7 12 7C9.23858 7 7 9.23858 7 12C7 14.7614 9.23858 17 12 17Z"
                                    fill="#7F56D9" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25"
                                viewBox="0 0 24 25" fill="none" x-show="$wire.paymentOption !== 'card'">
                                <path
                                    d="M12 2.5C6.48 2.5 2 6.98 2 12.5C2 18.02 6.48 22.5 12 22.5C17.52 22.5 22 18.02 22 12.5C22 6.98 17.52 2.5 12 2.5ZM12 20.5C7.58 20.5 4 16.92 4 12.5C4 8.08 7.58 4.5 12 4.5C16.42 4.5 20 8.08 20 12.5C20 16.92 16.42 20.5 12 20.5Z"
                                    fill="#7F56D9" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col gap-6" x-show="$wire.paymentOption === 'card'">
                        <div class="flex flex-row px-4 gap-4 max-h-12">
                            @foreach ($card_channel_imgs as $image_url)
                                <img src="{{ $image_url }}" class="object-contain h-full w-fit">
                            @endforeach
                        </div>
                        <div class="flex flex-col items-center justify-center gap-6 text-neutral-800">
                            <x-button.filled-button color="primary" class="w-96 py-4 text-xl font-bold"
                                wire:click="payWithCard" wire:loading.attr="disabled">
                                Pay {{ Number::currency($this->amountCardPayment, 'PHP') }}
                            </x-button.filled-button>
                        </div>
                    </div>
                </div>

                @if (!empty($digital_channel_imgs))
                    <div class="flex flex-col gap-6 rounded-lg border shadow-small-dark px-4 py-4"
                        @click="$wire.set('paymentOption', 'digital')"
                        :class="{
                            'border border-primary-600': $wire.paymentOption === 'digital',
                            'border-transparent !hover:border-primary-600 hover:cursor-pointer': $wire
                                .paymentOption !== 'digital'
                        }">
                        <div class="p-3 flex flex-row items-center justify-between">
                            <div class="flex flex-row items-center gap-3">
                                <div class="p-2.5 bg-primary-600 rounded-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="18"
                                        viewBox="0 0 21 18" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M19.1001 5.504C19.0451 5.5 18.9841 5.5 18.9201 5.5H16.3951C14.3271 5.5 12.5581 7.128 12.5581 9.25C12.5581 11.372 14.3281 13 16.3951 13H18.9201C18.9841 13 19.0451 13 19.1021 12.996C19.5271 12.9704 19.9283 12.7911 20.231 12.4916C20.5336 12.1921 20.7171 11.7927 20.7471 11.368C20.7511 11.308 20.7511 11.243 20.7511 11.183V7.317C20.7511 7.257 20.7511 7.192 20.7471 7.132C20.7171 6.70726 20.5336 6.30793 20.231 6.00842C19.9283 5.7089 19.5271 5.52963 19.1021 5.504H19.1001ZM16.1721 10.25C16.7041 10.25 17.1351 9.802 17.1351 9.25C17.1351 8.698 16.7041 8.25 16.1721 8.25C15.6391 8.25 15.2081 8.698 15.2081 9.25C15.2081 9.802 15.6391 10.25 16.1721 10.25Z"
                                            fill="white" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M18.918 14.5C18.9526 14.4986 18.987 14.5054 19.0184 14.5198C19.0499 14.5342 19.0775 14.5558 19.099 14.5829C19.1206 14.61 19.1354 14.6418 19.1424 14.6757C19.1493 14.7096 19.1481 14.7446 19.139 14.778C18.939 15.49 18.62 16.098 18.109 16.608C17.36 17.358 16.411 17.689 15.239 17.847C14.099 18 12.644 18 10.806 18H8.694C6.856 18 5.4 18 4.261 17.847C3.089 17.689 2.14 17.357 1.391 16.609C0.643 15.86 0.311 14.911 0.153 13.739C1.19209e-07 12.599 0 11.144 0 9.306V9.194C0 7.356 1.19209e-07 5.9 0.153 4.76C0.311 3.588 0.643 2.639 1.391 1.89C2.14 1.142 3.089 0.81 4.261 0.652C5.401 0.5 6.856 0.5 8.694 0.5H10.806C12.644 0.5 14.1 0.5 15.239 0.653C16.411 0.811 17.36 1.143 18.109 1.891C18.62 2.403 18.939 3.01 19.139 3.722C19.1481 3.75537 19.1493 3.79042 19.1424 3.82432C19.1354 3.85822 19.1206 3.89 19.099 3.91708C19.0775 3.94417 19.0499 3.96579 19.0184 3.9802C18.987 3.9946 18.9526 4.00139 18.918 4H16.394C13.557 4 11.057 6.24 11.057 9.25C11.057 12.26 13.557 14.5 16.394 14.5H18.918ZM3.75 4.5C3.55109 4.5 3.36032 4.57902 3.21967 4.71967C3.07902 4.86032 3 5.05109 3 5.25C3 5.44891 3.07902 5.63968 3.21967 5.78033C3.36032 5.92098 3.55109 6 3.75 6H7.75C7.94891 6 8.13968 5.92098 8.28033 5.78033C8.42098 5.63968 8.5 5.44891 8.5 5.25C8.5 5.05109 8.42098 4.86032 8.28033 4.71967C8.13968 4.57902 7.94891 4.5 7.75 4.5H3.75Z"
                                            fill="#F5F6F8" />
                                    </svg>
                                </div>
                                <span class="text-neutral-800 text-xl font-bold">Digital Wallet</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" x-show="$wire.paymentOption === 'digital'">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.58 20 4 16.42 4 12C4 7.58 7.58 4 12 4C16.42 4 20 7.58 20 12C20 16.42 16.42 20 12 20Z"
                                        fill="#7F56D9" />
                                    <path
                                        d="M12 17C14.7614 17 17 14.7614 17 12C17 9.23858 14.7614 7 12 7C9.23858 7 7 9.23858 7 12C7 14.7614 9.23858 17 12 17Z"
                                        fill="#7F56D9" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25"
                                    viewBox="0 0 24 25" fill="none" x-show="$wire.paymentOption !== 'digital'">
                                    <path
                                        d="M12 2.5C6.48 2.5 2 6.98 2 12.5C2 18.02 6.48 22.5 12 22.5C17.52 22.5 22 18.02 22 12.5C22 6.98 17.52 2.5 12 2.5ZM12 20.5C7.58 20.5 4 16.92 4 12.5C4 8.08 7.58 4.5 12 4.5C16.42 4.5 20 8.08 20 12.5C20 16.92 16.42 20.5 12 20.5Z"
                                        fill="#7F56D9" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex flex-col gap-6" x-show="$wire.paymentOption === 'digital'">
                            <div class="flex flex-row px-4 gap-4 max-h-12">
                                @foreach ($digital_channel_imgs as $image_url)
                                    <img src="{{ $image_url }}" class="object-contain h-full w-fit">
                                @endforeach
                            </div>
                            <div class="flex flex-col items-center justify-center gap-6 text-neutral-800">
                                <x-button.filled-button color="primary" class="w-96 py-4 text-xl font-bold"
                                    wire:click="payWithDigitalWallet" wire:loading.attr="disabled">
                                    Pay {{ Number::currency($this->amountDigitalWallet, 'PHP') }}
                                </x-button.filled-button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Order summary --}}
            <div class="w-2/5 h-fit p-4 rounded-lg shadow-small-dark flex flex-col justify-between text-neutral-800">
                <div class="py-3 text-center font-bold text-xl uppercase">
                    Order Summary
                </div>
                <div class="pb-20 flex flex-col gap-10 mx-7 border-b-[1.5px]">
                    <div class="text-center flex flex-col">
                        <span class="text-xs">Sent to:</span>
                        <span class="text-xl font-bold">{{ $merchant->name }}</span>
                        <span class="text-xs">Destination: Repay</span>
                    </div>
                    <div class="flex flex-col w-full gap-3">
                        <div class="flex flex-row justify-between items-center text-sm">
                            <span>Amount</span>
                            <span>{{ Number::currency($checkout_session->amount, 'PHP') }}</span>
                        </div>
                        @if ($this->service_fee > 0)
                            <div class="flex flex-row justify-between items-center text-sm">
                                <span>Service Fee</span>
                                <span>{{ Number::currency($this->service_fee, 'PHP') }}</span>
                            </div>
                        @endif
                        <div class="flex flex-row justify-between items-center font-bold">
                            <span class="text-sm">Total</span>
                            <span
                                class="text-2xl">{{ Number::currency($checkout_session->amount + $this->service_fee, 'PHP') }}</span>
                        </div>
                        <div class="flex flex-row justify-between items-center text-sm">
                            <span>Reference Number</span>
                            <span>{{ $payment_2c2p->ref_no }}</span>
                        </div>
                        <div class="flex flex-row justify-between items-center text-sm">
                            <span>Date Created</span>
                            <span>{{ $checkout_session->created_at->timezone('Asia/Manila')->format('F d, Y - h:i A') }}</span>
                        </div>
                    </div>
                </div>
                <div class="py-3 flex flex-row gap-2.5 justify-center items-center">
                    <span class="text-[10px]">Powered by:</span>
                    <img src="{{ url('/images/repay-logo-colored.svg') }}" class="object-contain h-5"
                        alt="Repay Logo">
                </div>
            </div>
        </div>
        <div id="pgw-ui-container"></div>
    @endif

    <x-modal x-model="isCancelPaymentModalVisible">
        <x-modal.confirmation-modal title="Leave Payment Page?"
            message="You have attempted to go back to the merchant page. This will cancel the payment process.">
            <x-slot:action_buttons>
                <x-button.outline-button color="primary" wire:click="cancelPayment" <x-button.outline-button
                    color="primary" wire:click="cancelPayment" class="w-1/2">Continue</x-button.outline-button>
                <x-button.filled-button color="primary" class="w-1/2"
                    @click="isCancelPaymentModalVisible=false;">Cancel</x-button.filled-button>
            </x-slot:action_buttons>
        </x-modal.confirmation-modal>
    </x-modal>

    <x-modal x-model="isRedirectToMerchantModalVisible">
        <x-modal.confirmation-modal title="Redirecting Confirmation"
            message="We’re redirecting you to complete your payment. Please don’t close or refresh this window.">
            <x-slot:action_buttons>
                <x-button.filled-button color="primary" wire:click="redirectNow"
                    class="w-full">Ok</x-button.filled-button>
            </x-slot:action_buttons>
        </x-modal.confirmation-modal>
    </x-modal>

    <x-modal x-model="noQrPaymentFoundModalVisible">
        <x-modal.confirmation-modal title="No Payment Found"
            message="We were unable to find a payment for this reference number.">
            <x-slot:action_buttons>
                <x-button.filled-button color="primary" @click="noQrPaymentFoundModalVisible=false" class="w-full">Go
                    Back</x-button.filled-button>
            </x-slot:action_buttons>
        </x-modal.confirmation-modal>
    </x-modal>

    {{-- Loader --}}
    <x-loader.black-screen wire:loading.delay.longer
        wire:target="simulate_qr_payment,checkQrPaymentStatus,cancelPayment">
        <x-loader.clock />
    </x-loader.black-screen>
</div>

@script
    <script>
        Alpine.data('hostedCheckout', () => ({
            isCancelPaymentModalVisible: false,
            isRedirectToMerchantModalVisible: $wire.entangle('isRedirectToMerchantModalVisible'),
            noQrPaymentFoundModalVisible: $wire.entangle('noQrPaymentFoundModalVisible'),
            qrCodeData: @js($qr_code_data),

            init() {
                if (this.qrCodeData == null) {
                    this.$wire.paymentOption = 'card';
                }

                const qrCode = new QRCodeStyling({
                    width: 250,
                    height: 250,
                    type: "svg",
                    data: "{{ $qr_code_data }}",
                    image: "{{ $qr_code_image }}",
                    dotsOptions: {
                        color: "#000000",
                        type: "rounded"
                    },
                    backgroundOptions: {
                        color: "#FFFFFF",
                    },
                    imageOptions: {
                        crossOrigin: "anonymous",
                        margin: 0
                    },
                });

                qrCode.append(document.getElementById("canvas"));

                this.$wire.on('render2c2pPayment', (paymentToken) => {
                    const token = paymentToken.paymentToken;

                    const uiRequestFull = {
                        url: "https://sandbox-pgw-ui.2c2p.com/payment/4.1/#/token/" + token,
                        templateId: "ikea",
                        mode: "Dialog",
                        appBar: true,
                        cancelConfirmation: true
                    };

                    PGWSDK.paymentUI(uiRequestFull);
                });

                this.$watch('isRedirectToMerchantModalVisible', (value) => {
                    if (value) {
                        setTimeout(() => {
                            this.$wire.redirectNow();
                        }, 5000);
                    }
                })
            },

        }));
    </script>
@endscript
