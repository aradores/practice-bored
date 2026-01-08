<x-main.content class="!px-16 !py-10" x-data>
    <livewire:components.layout.admin.user-details-header :user="$user" />
    <div class="date-picker flex mt-4">
        <p class="my-auto pe-5">Sort by:</p>
        <x-date-picker.date-range-picker
            id="list"
            :from="$date_from"
            :to="$date_to"
            :maxDateToday="false"
            placeholder="Select a date range"
        />
    </div>
    <div class="search-filter flex flex-row gap-5 p-6 bg-white rounded-xl mb-5 mt-6">
        <x-input.search icon_position="left" wire:model.live='searchTerm' class="w-full" />

        <div class="dropdown">
            <div x-data="{ isOpen: false, openedWithKeyboard: false }" class="relative w-full"
                x-on:keydown.esc.window="isOpen = false, openedWithKeyboard = false">
                <button type="button" x-on:click="isOpen = ! isOpen"
                    class="w-48 rounded inline-flex gap-2 whitespace-nowrap rounded-radius border border-outline bg-surface-alt px-4 py-3 text-sm font-medium tracking-wide transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-outline-strong dark:border-outline-dark dark:bg-surface-dark-alt dark:focus-visible:outline-outline-dark-strong"
                    aria-haspopup="true" x-on:keydown.space.prevent="openedWithKeyboard = true"
                    x-on:keydown.enter.prevent="openedWithKeyboard = true"
                    x-on:keydown.down.prevent="openedWithKeyboard = true"
                    x-bind:class="isOpen || openedWithKeyboard ? 'text-on-surface-strong dark:text-on-surface-dark-strong' :
                        'text-on-surface dark:text-on-surface-dark'"
                    x-bind:aria-expanded="isOpen || openedWithKeyboard">
                    <div class="m-auto">
                        <svg width="18" height="17" viewBox="0 0 18 17" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M3.08583 0H14.8308C15.3867 0 15.8617 -6.51926e-08 16.2417 0.0474999C16.6442 0.0983333 17.0333 0.2125 17.3533 0.5125C17.6783 0.818333 17.8075 1.19917 17.8642 1.595C17.9167 1.95917 17.9167 2.41167 17.9167 2.92833V3.575C17.9167 3.9825 17.9167 4.33333 17.8867 4.6275C17.8533 4.94417 17.7825 5.24 17.6108 5.52417C17.44 5.80667 17.2108 6.01167 16.9458 6.195C16.6967 6.36833 16.3792 6.5475 16.0042 6.75833L13.5525 8.13833C12.9942 8.4525 12.8 8.56583 12.67 8.67833C12.3725 8.93667 12.2017 9.22417 12.1217 9.58333C12.0875 9.7375 12.0833 9.93083 12.0833 10.5192V12.7958C12.0833 13.5467 12.0833 14.1842 12.0058 14.675C11.9242 15.1958 11.7333 15.6958 11.2333 16.0083C10.7442 16.3142 10.2067 16.2858 9.68333 16.1617C9.17917 16.0425 8.55833 15.7992 7.81333 15.5083L7.74167 15.48C7.39167 15.3433 7.08667 15.2242 6.845 15.0992C6.585 14.965 6.34333 14.7983 6.15917 14.5383C5.97167 14.275 5.8975 13.9933 5.86333 13.705C5.83333 13.4425 5.83333 13.1275 5.83333 12.7758V10.5192C5.83333 9.93083 5.83 9.7375 5.795 9.58333C5.71953 9.22845 5.52629 8.90952 5.24667 8.67833C5.11667 8.56583 4.92167 8.4525 4.36417 8.13833L1.9125 6.75833C1.5375 6.5475 1.22 6.36833 0.970833 6.195C0.705833 6.01167 0.476667 5.80667 0.305833 5.52417C0.134167 5.24 0.0633333 4.94333 0.0308333 4.6275C-4.96705e-08 4.33417 0 3.9825 0 3.575V2.92833C0 2.41167 -3.10441e-08 1.95917 0.0525 1.595C0.109167 1.19917 0.238333 0.818333 0.563333 0.5125C0.883333 0.2125 1.27167 0.0983333 1.675 0.0474999C2.055 -6.51926e-08 2.53 0 3.08583 0ZM1.83167 1.28833C1.55333 1.32333 1.465 1.38 1.41917 1.42417C1.3775 1.4625 1.32417 1.53 1.28917 1.7725C1.25167 2.0375 1.25 2.39917 1.25 2.97083V3.54583C1.25 3.99083 1.25 4.2775 1.27333 4.49917C1.295 4.705 1.33167 4.80417 1.37667 4.87833C1.4225 4.95417 1.49917 5.04 1.68333 5.16833C1.87833 5.30333 2.14417 5.45417 2.55 5.6825L4.9775 7.04917L5.04417 7.08667C5.51083 7.34917 5.8275 7.5275 6.06583 7.73417C6.54785 8.1408 6.88186 8.69543 7.01583 9.31167C7.08333 9.6175 7.08333 9.96167 7.08333 10.445V12.7442C7.08333 13.1375 7.08417 13.3792 7.10583 13.5608C7.12417 13.7258 7.155 13.7817 7.1775 13.8142C7.2025 13.8492 7.2525 13.9033 7.41833 13.9892C7.595 14.08 7.83917 14.1758 8.22417 14.3267C9.025 14.64 9.56417 14.8492 9.97167 14.9458C10.3708 15.0408 10.5025 14.9917 10.57 14.9492C10.6267 14.9133 10.7142 14.8408 10.7717 14.48C10.8317 14.0992 10.8333 13.5608 10.8333 12.7433V10.445C10.8333 9.96167 10.8333 9.6175 10.9017 9.31167C11.0354 8.69554 11.3691 8.14093 11.8508 7.73417C12.0892 7.5275 12.4067 7.34833 12.8717 7.08667L12.9392 7.04917L15.3667 5.6825C15.7725 5.45417 16.0383 5.30333 16.2333 5.16833C16.4175 5.04 16.4942 4.95417 16.54 4.87833C16.585 4.80417 16.6217 4.705 16.6425 4.49917C16.6658 4.2775 16.6667 3.99083 16.6667 3.545V2.97C16.6667 2.39917 16.665 2.03667 16.6275 1.7725C16.5925 1.53 16.5383 1.4625 16.4983 1.42417C16.4517 1.38083 16.3633 1.32333 16.085 1.28833C15.7933 1.25083 15.3975 1.25 14.7917 1.25H3.125C2.51917 1.25 2.12417 1.25083 1.83167 1.28833Z"
                            fill="#647887" />
                    </svg>
                    </div>
                    <p class="w-full text-start text-xs truncate overflow-hidden whitespace-nowrap">
                        {{ collect($filters)->firstWhere('value', $selectedFilter)['label'] ?? 'Filters' }}
                    </p>
                    <svg aria-hidden="true" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" class="size-4 rotate-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>

                <div x-cloak x-show="isOpen || openedWithKeyboard" x-transition x-trap="openedWithKeyboard"
                    x-on:click.outside="isOpen = false, openedWithKeyboard = false"
                    x-on:keydown.down.prevent="$focus.wrap().next()" x-on:keydown.up.prevent="$focus.wrap().previous()"
                    class="absolute top-11 right-0 bg-white rounded-xl shadow-xl flex flex-col p-3 w-96" role="menu">
                    @foreach ($filters as $filter)
                        <button class="text-start m-3"
                            @click="$wire.set('selectedFilter', {{ (int) $filter['value'] }})">
                            <span
                                @class([
                                    'w-3 h-3 rounded-full relative inline-block bg-gray-500',
                                    'bg-yellow-500' => $filter['activity_type_color'] === 'yellow',
                                    'bg-green-500' => $filter['activity_type_color'] === 'green',
                                    'bg-red-500' => $filter['activity_type_color'] === 'red',
                                ])></span>
                            {{ $filter['label'] }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
<div class="overflow-x-auto">
    <x-table.rounded>
        <x-slot:table_header class="[&>*]:text-nowrap">
            <x-table.rounded.th class="w-40">Date & Time</x-table.rounded.th>
            <x-table.rounded.th class="w-32">Recorded by</x-table.rounded.th>
            <x-table.rounded.th class="w-32">Reference ID</x-table.rounded.th>
            <x-table.rounded.th class="w-48">Activity Type</x-table.rounded.th>
            <x-table.rounded.th class="w-64">Description / Details</x-table.rounded.th>
            <x-table.rounded.th class="w-24">Status</x-table.rounded.th>
        </x-slot:table_header>

        <x-slot:table_data>
            <tr>
                <td class="pt-8"></td>
            </tr>
            @foreach ($data['data'] as $key => $item)
                <x-table.rounded.row>
                    <x-table.rounded.td>{{ $item['date_time'] ?? '' }}</x-table.rounded.td>
                    <x-table.rounded.td>{{ $item['recorded_by'] ?? '' }} </x-table.rounded.td>
                    <x-table.rounded.td>{{ $item['reference_id'] ?? '' }}</x-table.rounded.td>
                    <x-table.rounded.td>
                        <span @class([
                            'w-3 h-3 rounded-full relative inline-block',
                            'bg-yellow-500' => $item['activity_type_color'] === 'yellow',
                            'bg-green-500' => $item['activity_type_color'] === 'green',
                            'bg-red-500' => $item['activity_type_color'] === 'red',
                        ])>
                        </span>
                            {{ $item['activity_type'] ?? '' }}
                    </x-table.rounded.td>

                    <x-table.rounded.td>
                        <div 
                            wire:key="desc-{{ $item['reference_id'] ?? $key }}"
                            x-data="{
                                expanded: false,
                                truncated: `{{ addslashes(Str::words($item['description'] ?? '-', 5, '...')) }}`,
                                full: `{{ addslashes($item['description'] ?? '-') }}`,
                                hasButton: {{ str_word_count($item['description'] ?? '-') > 5 ? 'true' : 'false' }}
                            }"
                            class="flex items-start justify-between gap-2 w-full"
                        >
                            <span 
                                class="text-gray-700 whitespace-pre-wrap flex-1"
                                x-text="expanded ? full : truncated"
                            ></span>

                            <button 
                                x-show="hasButton"
                                @click="expanded = !expanded"
                                class="text-blue-500 hover:underline text-sm flex-shrink-0"
                            >
                                <template x-if="!expanded">
                                    <x-icon.solid-arrow-down />
                                </template>
                                <template x-if="expanded">
                                    <x-icon.solid-arrow-up />
                                </template>
                            </button>
                        </div>
                    </x-table.rounded.td>


                    <x-table.rounded.td>
                        <div @class([
                            'w-28 text-center px-2 py-1 text-sm font-medium rounded-md border',
                            'bg-gray-200 border-gray-500 text-gray-500' => $item['status_color'] === 'gray',
                            'bg-green-200 text-green-500 border-green-500' => $item['status_color'] === 'green',
                            'bg-red-200 text-red-500 border-red-500' => $item['status_color'] === 'red',
                        ])>
                            {{ $item['status'] ?? '' }}
                        </div>
                    </x-table.rounded.td>
                </x-table.rounded.row>
            @endforeach
        </x-slot:table_data>
    </x-table.rounded>
</div>
    <div class="pagination mt-5 w-full flex justify-end">
        @foreach ($elements as $element)
            @if (is_string($element))
                <button class="h-full px-4 py-2 bg-white border-r cursor-default">{{ $element }}</button>
            @else
                <button wire:click="gotoPage({{ $element }})"
                    class="h-full border-r px-4 py-2 {{ $element == $data['pagination']['current_page'] ? 'cursor-default bg-rp-blue-600 text-white' : 'cursor-pointer bg-white' }}">{{ $element }}</button>
            @endif
        @endforeach
    </div>
</x-main.content>