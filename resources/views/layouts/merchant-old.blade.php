<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
        <title>{{ config('app.name', 'REPAY') }} | Digital Banking Solution</title>

        {{-- Favicon --}}
        <link rel="icon" href="{{url('/favicon.png')}}">
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/store/left_sidebar.js'])
        @stack('headscripts')

        <!-- Styles -->
        @livewireStyles
        @stack('styles')
    </head>
    <body x-data>
        <div class="bg-rp-neutral-50">
            <!-- Page Content -->
            <div class="min-h-screen flex flex-row w-full">
                
                @livewire('merchant.components.left-sidebar')
            
                <div class="min-h-full max-w-[calc(100%-80px)] min-w-[calc(100%-300px)] w-full">
                    <div class="bg-white w-full">
                        @livewire('merchant.components.header')
                    </div>
                    <main class="h-auto w-full">
                        {{ $slot }}
                    </main>
                </div>
            </div>
        </div>
        <div>
            <footer>
                <div class="bg-footer2 py-5 text-center">
                    <div class="container text-white mx-auto px-3">
                        RePay.ph is regulated by the Banko Sentral ng Pilipinas. All trademarks pertaining to RePay.ph are owned by RePay Digital Solutions. All rights reserved © {{ now()->format('Y') }}.
                    </div>
                </div>
            </footer>
        </div>
        @stack('modals')
        @stack('scripts')
        @livewireScripts
        <x-toasts />
        @if(session()->has('notify'))
            <div x-data="{
                init () {
                    this.$nextTick(() => {
                        this.$dispatch('notify', {{ json_encode(session('notify')) }});
                    })
                }
            }"></div>
        @endif
    </body>
</html>


