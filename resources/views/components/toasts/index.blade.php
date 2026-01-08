<div x-data="notifications">
    <template x-if="notification != null">
        <div x-show="notification.visible"
            class="fixed bottom-3 left-[50%] translate-x-[-50%] z-[9999] shadow-lg w-[90vw] max-w-[796px] gap-6 p-4 rounded-xl bg-white"
            :class="{
                'border-l-success-600': notification.type === 'success',
                'border-l-error-600': notification.type === 'error',
                'border-l-warning-500': notification.type === 'warning',
                'border-l-[#1ba2dc]': notification.type === 'info'
            }">
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-2">
                    <template x-if="notification.type === 'success'">
                        <svg width="44" height="45" viewBox="0 0 44 45" fill="none">
                            <rect y="0.5" width="44" height="44" rx="12" fill="#149D8C" />
                            <path
                                d="M22 12.5C16.49 12.5 12 16.99 12 22.5C12 28.01 16.49 32.5 22 32.5C27.51 32.5 32 28.01 32 22.5C32 16.99 27.51 12.5 22 12.5ZM26.78 20.2L21.11 25.87C20.97 26.01 20.78 26.09 20.58 26.09C20.38 26.09 20.19 26.01 20.05 25.87L17.22 23.04C16.93 22.75 16.93 22.27 17.22 21.98C17.51 21.69 17.99 21.69 18.28 21.98L20.58 24.28L25.72 19.14C26.01 18.85 26.49 18.85 26.78 19.14C27.07 19.43 27.07 19.9 26.78 20.2Z"
                                fill="white" />
                        </svg>
                    </template>
                    <template x-if="notification.type === 'error'">
                        <svg width="44" height="45" viewBox="0 0 44 45" fill="none">
                            <rect y="0.5" width="44" height="44" rx="12" fill="#F70068" />
                            <path
                                d="M26.19 12.5H17.81C14.17 12.5 12 14.67 12 18.31V26.68C12 30.33 14.17 32.5 17.81 32.5H26.18C29.82 32.5 31.99 30.33 31.99 26.69V18.31C32 14.67 29.83 12.5 26.19 12.5ZM25.36 24.8C25.65 25.09 25.65 25.57 25.36 25.86C25.21 26.01 25.02 26.08 24.83 26.08C24.64 26.08 24.45 26.01 24.3 25.86L22 23.56L19.7 25.86C19.55 26.01 19.36 26.08 19.17 26.08C18.98 26.08 18.79 26.01 18.64 25.86C18.35 25.57 18.35 25.09 18.64 24.8L20.94 22.5L18.64 20.2C18.35 19.91 18.35 19.43 18.64 19.14C18.93 18.85 19.41 18.85 19.7 19.14L22 21.44L24.3 19.14C24.59 18.85 25.07 18.85 25.36 19.14C25.65 19.43 25.65 19.91 25.36 20.2L23.06 22.5L25.36 24.8Z"
                                fill="white" />
                        </svg>
                    </template>
                    <template x-if="notification.type === 'warning'">
                        <svg width="44" height="45" viewBox="0 0 44 45" fill="none">
                            <rect y="0.5" width="44" height="44" rx="12" fill="#F79009" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M12 22.5C12 16.977 16.477 12.5 22 12.5C27.523 12.5 32 16.977 32 22.5C32 28.023 27.523 32.5 22 32.5C16.477 32.5 12 28.023 12 22.5ZM22 16.75C21.8011 16.75 21.6103 16.829 21.4697 16.9697C21.329 17.1103 21.25 17.3011 21.25 17.5L21.25 23.5C21.25 23.6989 21.329 23.8897 21.4697 24.0303C21.6103 24.171 21.8011 24.25 22 24.25C22.1989 24.25 22.3897 24.171 22.5303 24.0303C22.671 23.8897 22.75 23.6989 22.75 23.5L22.75 17.5C22.75 17.086 22.414 16.75 22 16.75ZM22 27.5C21.7348 27.5 21.4804 27.3946 21.2929 27.2071C21.1054 27.0196 21 26.7652 21 26.5C21 26.2348 21.1054 25.9804 21.2929 25.7929C21.4804 25.6054 21.7348 25.5 22 25.5C22.2652 25.5 22.5196 25.6054 22.7071 25.7929C22.8946 25.9804 23 26.2348 23 26.5C23 26.7652 22.8946 27.0196 22.7071 27.2071C22.5196 27.3946 22.2652 27.5 22 27.5Z"
                                fill="white" />
                        </svg>
                    </template>
                    <template x-if="notification.type === 'info'">
                        <svg width="40" height="40"
                            viewBox="0 0 50 50" fill="none">
                            <path
                                d="M22.5 37.5H27.5V22.5H22.5V37.5ZM25 0C11.2 0 0 11.2 0 25C0 38.8 11.2 50 25 50C38.8 50 50 38.8 50 25C50 11.2 38.8 0 25 0ZM25 45C13.975 45 5 36.025 5 25C5 13.975 13.975 5 25 5C36.025 5 45 13.975 45 25C45 36.025 36.025 45 25 45ZM22.5 17.5H27.5V12.5H22.5V17.5Z"
                                fill="#1ba2dc" />
                        </svg>
                    </template>
                    <div>
                        {{-- Title --}}
                        <h6 class="text-lg font-bold text-rp-neutral-700" x-text="notification.title"></h6>
                        {{-- Description --}}
                        <p class="text-sm" x-text="notification.message"></p>
                    </div>
                </div>
                <div @click="remove()" class="cursor-pointer">
                    <svg width="14" height="15" viewBox="0 0 14 15" fill="none">
                        <path d="M1.18848 13.4056L12.9998 1.59424" stroke="#A8B5BE" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M12.9998 13.4056L1.18848 1.59424" stroke="#A8B5BE" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
        </div>
    </template>
</div>
