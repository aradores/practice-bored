@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation"
        class="flex flex-row items-center h-10 gap-0 mt-4 overflow-hidden border rounded-md w-max">
        {{-- Previous Page Link --}}
        <button aria-disabled="{{ $paginator->onFirstPage() }}" {{ $paginator->onFirstPage() ? 'disabled' : null }}
            wire:click="previousPage('{{ $paginator->getPageName() }}')"
            class="{{ $paginator->onFirstPage() ? 'cursor-not-allowed opacity-50' : '' }} px-4 h-full py-2 border-r bg-white flex items-center">
            <svg width="7" height="13" viewBox="0 0 7 13" fill="none">
                <path d="M6 11.5001L1 6.50012L6 1.50012" stroke="#647887" stroke-width="1.66667" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </button>

        <!-- Pagination Elements -->
        @if ($paginator->lastPage() < 5) {{-- 5 --}}
            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                <div wire:click="gotoPage({{ $i }}, '{{ $paginator->getPageName() }}')"
                    class="{{ $i === $paginator->currentPage() ? 'cursor-default bg-rp-blue-600 text-white' : 'cursor-pointer bg-white' }} h-full border px-4 py-2  cursor-pointer">
                    {{ $i }}</div>
            @endfor
        @else
            @if ($paginator->currentPage() <= 3)
                @for ($i = 1; $i < 4; $i++)
                    <div wire:click="gotoPage({{ $i }}, '{{ $paginator->getPageName() }}')"
                        wire:key="{{ $i }}"
                        class="{{ $i === $paginator->currentPage() ? 'cursor-default bg-rp-blue-600 text-white' : 'cursor-pointer bg-white' }} cursor-pointer px-4 py-2 font-bold border  hover:opacity-50 transition-opacity rounded-4px">
                        {{ $i }}
                    </div>
                @endfor
                <button class="px-4 py-2 font-bold bg-white text-dark-gray-400 border border-neutral-100 rounded-4px">
                    ...
                </button>
                <button wire:click="gotoPage({{ $paginator->lastPage() }}, '{{ $paginator->getPageName() }}')"
                    class="cursor-pointer px-4 py-2 font-bold bg-white text-dark-gray-400 border border-neutral-100 hover:opacity-50 transition-opacity rounded-4px">
                    {{ $paginator->lastPage() }}
                </button>
            @elseif ($paginator->currentPage() > 3 && $paginator->currentPage() < $paginator->lastPage() - 2)
                <button wire:click="gotoPage({{ 1 }}, '{{ $paginator->getPageName() }}')"
                    class="cursor-pointer px-4 py-2 font-bold bg-white text-dark-gray-400 border border-neutral-100 hover:opacity-50 transition-opacity rounded-4px ">
                    1
                </button>
                <button class="px-4 py-2 font-bold bg-white text-dark-gray-400 border border-neutral-100 rounded-4px">
                    ...
                </button>
                @for ($i = $paginator->currentPage() - 1; $i <= $paginator->currentPage() + 1; $i++)
                    <div wire:key="{{ $i }}"
                        class="{{ $i === $paginator->currentPage() ? 'cursor-default bg-rp-blue-600 text-white ' : 'cursor-pointer bg-white' }} cursor-pointer px-4 py-2 font-bold  border  hover:opacity-50 transition-opacity rounded-4px"
                        wire:click="gotoPage({{ $i }}, '{{ $paginator->getPageName() }}')">
                        {{ $i }}
                    </div>
                @endfor
                <button class="px-4 py-2 font-bold bg-white text-dark-gray-400 border border-neutral-100 rounded-4px">
                    ...
                </button>
                <button wire:click="gotoPage({{ $paginator->lastPage() }}, '{{ $paginator->getPageName() }}')"
                    class="cursor-pointer px-4 py-2 font-bold bg-white text-dark-gray-400 border border-neutral-100 hover:opacity-50 transition-opacity rounded-4px">
                    {{ $paginator->lastPage() }}
                </button>
            @else
                <button wire:click="gotoPage({{ 1 }}, '{{ $paginator->getPageName() }}')"
                    class="cursor-pointer px-4 py-2 font-bold bg-white text-dark-gray-400 border border-neutral-100 hover:opacity-50 transition-opacity rounded-4px">
                    1
                </button>
                <button class="px-4 py-2 font-bold bg-white text-dark-gray-400 border border-neutral-100 rounded-4px">
                    ...
                </button>
                @for ($i = $paginator->lastPage() - 2; $i <= $paginator->lastPage(); $i++)
                    <div wire:key="{{ $i }}"
                        class="{{ $i === $paginator->currentPage() ? 'cursor-default bg-rp-blue-600 text-white ' : 'cursor-pointer bg-white' }} cursor-pointer px-4 py-2 font-bold bg-white border  hover:opacity-50 transition-opacity rounded-4px"
                        wire:click="gotoPage({{ $i }}, '{{ $paginator->getPageName() }}')">
                        {{ $i }}
                    </div>
                @endfor
            @endif
        @endif

        <button aria-disabled="{{ !$paginator->hasMorePages() }}"
            {{ !$paginator->hasMorePages() ? 'disabled' : null }}
            wire:click="nextPage('{{ $paginator->getPageName() }}')"
            class="{{ !$paginator->hasMorePages() ? 'cursor-not-allowed opacity-50' : '' }} px-4 h-full py-2 border-r bg-white flex items-center"
            rel="next">
            <svg width="7" height="13" viewBox="0 0 7 13" fill="none">
                <path d="M1 1.50012L6 6.50012L1 11.5001" stroke="#647887" stroke-width="1.66667" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </button>
    </nav>
@endif
