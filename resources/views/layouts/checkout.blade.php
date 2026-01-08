<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'REPAY') }} | Digital Banking Solution</title>

    {{-- Favicon --}}
    <link rel="icon" href="{{ url('/favicon.png') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('headscripts')
    @stack('styles')

    <!-- Styles -->
    @livewireStyles
</head>

<body class="antialiased scrollbar-hide min-h-screen overflow-auto flex flex-col justify-between bg-white">
    <div>
        <header class="md:h-[87px] h-16 border border-neutral-100 px-5 md:px-10 xl:px-36 md:py-5 flex items-center">
            <div class="py-2">
                <img src="{{ url('/images/repay-logo-colored.svg') }}" class="object-contain h-fit" alt="Repay Logo">
            </div>
        </header>
        <main>
            {{ $slot }}
        </main>
    </div>
    <footer class="mt-auto">
        <div class="bg-footer2 py-5 text-center">
            <div class="container text-white mx-auto px-3">
                RePay.ph is regulated by the Banko Sentral ng Pilipinas. All trademarks pertaining to RePay.ph are
                owned by RePay Digital Solutions. All rights reserved © {{ now()->format('Y') }}.
            </div>
        </div>
    </footer>

    @stack('modals')
    @stack('scripts')
    @livewireScripts
    <x-toasts />
    @if (session()->has('notify'))
        <div x-data="{
            init() {
                this.$nextTick(() => {
                    this.$dispatch('notify', {{ json_encode(session('notify')) }});
                })
            }
        }"></div>
    @endif
</body>

</html>
