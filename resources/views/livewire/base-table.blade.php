<div>
    {{-- Filters section - override renderFilters() method to add custom filters --}}
    @if(method_exists($this, 'renderFilters'))
        <div class="mb-6 space-y-4">
            {!! $this->renderFilters() !!}
        </div>
    @endif

    {{-- DEBUG: Show if columnRenderers exist --}}
    @if(count($this->columnRenderers()) > 0)
        <div class="mb-4 p-4 bg-yellow-100 text-yellow-800 rounded">
            <strong>DEBUG:</strong> Found {{ count($this->columnRenderers()) }} custom column renderer(s):
            {{ implode(', ', array_keys($this->columnRenderers())) }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    @foreach($headers as $column => $label)
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            @if(in_array($column, $sortableColumns))
                                <button wire:click="sortBy('{{ $column }}')" class="flex items-center space-x-1 hover:text-gray-700">
                                    <span>{{ $label }}</span>
                                    @if($sortField === $column)
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            @if($sortDirection === 'asc')
                                                <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"/>
                                            @else
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                            @endif
                                        </svg>
                                    @endif
                                </button>
                            @else
                                <span>{{ $label }}</span>
                            @endif
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($data as $row)
                    <tr class="hover:bg-gray-50">
                        @foreach($headers as $column => $label)
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{-- DEBUG: Show which renderer is being used --}}
                                @php
                                    $renderers = $this->columnRenderers();
                                    $hasRenderer = isset($renderers[$column]);
                                @endphp

                                @if($hasRenderer)
                                    <span class="text-xs text-gray-400">[custom]</span>
                                @endif

                                {!! $this->renderColumn($row, $column) !!}
                            </td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($headers) }}" class="px-6 py-4 text-center text-gray-500">
                            No data available
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Smart Pagination --}}
    @if($data->hasPages())
        <div class="mt-4 flex flex-col sm:flex-row items-center justify-between gap-4">
            {{-- Results Info --}}
            <div class="text-sm text-gray-700">
                Showing <span class="font-medium">{{ $data->firstItem() }}</span>
                to <span class="font-medium">{{ $data->lastItem() }}</span>
                of <span class="font-medium">{{ $data->total() }}</span> results
            </div>

            {{-- Pagination Links --}}
            <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                {{-- Previous Button --}}
                @if ($data->onFirstPage())
                    <span class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 cursor-not-allowed">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                @else
                    <button wire:click="previousPage" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                @endif

                {{-- Smart Page Numbers --}}
                @php
                    $currentPage = $data->currentPage();
                    $lastPage = $data->lastPage();
                    $onEachSide = $paginationLinks ?? 2;

                    // Calculate range
                    $start = max(1, $currentPage - $onEachSide);
                    $end = min($lastPage, $currentPage + $onEachSide);

                    // Adjust if we're near the start or end
                    if ($currentPage <= $onEachSide) {
                        $end = min($lastPage, ($onEachSide * 2) + 1);
                    }
                    if ($currentPage > $lastPage - $onEachSide) {
                        $start = max(1, $lastPage - ($onEachSide * 2));
                    }
                @endphp

                {{-- First Page + Ellipsis --}}
                @if($start > 1)
                    <button wire:click="gotoPage(1)" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20">
                        1
                    </button>
                    @if($start > 2)
                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300">
                            ...
                        </span>
                    @endif
                @endif

                {{-- Page Numbers --}}
                @for ($page = $start; $page <= $end; $page++)
                    @if ($page == $currentPage)
                        <span class="relative z-10 inline-flex items-center bg-blue-600 px-4 py-2 text-sm font-semibold text-white focus:z-20">
                            {{ $page }}
                        </span>
                    @else
                        <button wire:click="gotoPage({{ $page }})" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20">
                            {{ $page }}
                        </button>
                    @endif
                @endfor

                {{-- Ellipsis + Last Page --}}
                @if($end < $lastPage)
                    @if($end < $lastPage - 1)
                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300">
                            ...
                        </span>
                    @endif
                    <button wire:click="gotoPage({{ $lastPage }})" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20">
                        {{ $lastPage }}
                    </button>
                @endif

                {{-- Next Button --}}
                @if ($data->hasMorePages())
                    <button wire:click="nextPage" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                @else
                    <span class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 cursor-not-allowed">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                @endif
            </nav>
        </div>
    @endif
    <script>
        // Create a global confirm function
        window.confirmAction = function (options) {
            return new Promise((resolve) => {
                const {
                    title = 'Confirm Action',
                    message = 'Are you sure?',
                    confirmText = 'Confirm',
                    cancelText = 'Cancel',
                    type = 'info' // info, success, warning, danger
                } = options;

                // You can use a fancy modal here, or use browser confirm for simplicity
                if (confirm(`${title}\n\n${message}`)) {
                    resolve(true);
                } else {
                    resolve(false);
                }
            });
        };
    </script>

</div>
