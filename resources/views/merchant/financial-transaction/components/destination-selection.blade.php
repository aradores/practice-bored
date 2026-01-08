<div class="absolute mt-1 right-0 w-96 rounded-lg shadow-md p-4 bg-white text-rp-neutral-700 flex flex-col gap-2 z-20"
    x-data="destinationSelection{{ $destination_event }}">

    <div class="flex justify-between items-start">
        <h2 class="font-semibold">
            <template x-if="active_tab == 'providers'">
                <span x-text="selected_provider_codes.length"></span>
            </template>
            <template x-if="active_tab == 'billers'">
                <span x-text="selected_biller_names.length"></span>
            </template>

            selected
        </h2>
        <x-button.outline-button color="red" class="!p-2.5 text-sm" @click="select_all(active_tab)">
            Select All
        </x-button.outline-button>
    </div>

    <x-input.search icon_position="left" x-model="search_term" placeholder="Search" />

    {{-- Tabs --}}
    <template x-if="tabs.length > 1">
        <div class="flex justify-between">
            <template x-for="tab in tabs" key="selection_tab">
                <div class=" w-1/2 p-2 cursor-pointer"
                    :class="active_tab == tab ? 'text-primary-700 font-bold border-b-2 border-primary-700' :
                        'hover:border-b hover:border-rp-neutral-500 hover:bg-gray-100'"
                    @click="active_tab = tab">
                    <p class="text-center capitalize text-sm" x-text="tab"></p>
                </div>
            </template>
        </div>
    </template>

    {{-- Tab content --}}
    <div class="flex flex-col gap-2 max-h-64 overflow-y-auto">

        {{--  Biller list --}}
        <div x-cloak x-show="active_tab=='billers'">
            <template x-for="biller in filtered_biller_list" :key="biller">
                <label
                    class="flex items-center justify-between p-3 rounded-lg cursor-pointer hover:bg-gray-100 transition">
                    <p class="font-bold text-sm text-rp-neutral-500" x-text="biller"></p>
                    <input type="checkbox" class="form-checkbox w-5 h-5 text-rp-red-500" :value="biller"
                        x-model="selected_biller_names" />
                </label>
            </template>
        </div>

        {{--  Provider list --}}
        <div x-cloak x-show="active_tab=='providers'">
            <template x-for="provider in filtered_provider_list" :key="provider.code">
                <label
                    class="flex items-center justify-between p-3 rounded-lg cursor-pointer hover:bg-gray-100 transition">
                    <p class="font-bold text-sm text-rp-neutral-500" x-text="provider.name"></p>
                    <input type="checkbox" class="form-checkbox w-5 h-5 text-rp-red-500" :value="provider.code"
                        x-model="selected_provider_codes" />
                </label>
            </template>
        </div>
    </div>

    <!-- Footer Buttons -->
    <div class="flex justify-end gap-2">
        <x-button.outline-button color="red" class="!p-2.5 text-sm !border" @click="cancel_selection">
            Cancel
        </x-button.outline-button>

        <x-button.filled-button color="red" class="!p-2.5 text-sm" @click="apply_selection">
            Apply
        </x-button.filled-button>
    </div>
</div>

@script
    <script>
        Alpine.data('destinationSelection{{ $destination_event }}', () => ({
            destination_event: @js($destination_event),
            tabs: [],
            active_tab: '',
            search_term: '',

            biller_list: @json($this->billers),
            filtered_biller_list: [],

            provider_list: @json($this->providers),
            filtered_provider_list: [],

            applied_biller_names_selection: @js($selected_biller_names),
            selected_biller_names: [],

            applied_provider_codes_selection: @js($selected_provider_codes),
            selected_provider_codes: [],

            init() {
                if (this.provider_list.length >= 1) {
                    this.tabs.push('providers');
                }

                if (this.biller_list.length >= 1) {
                    this.tabs.push('billers');
                }

                this.active_tab = this.tabs[0];

                this.filtered_biller_list = this.biller_list;
                this.filtered_provider_list = this.provider_list;

                this.selected_biller_names = this.applied_biller_names_selection;
                this.selected_provider_codes = this.applied_provider_codes_selection;

                this.$watch('search_term', (val) => {
                    if (val == '') {
                        this.filtered_provider_list = this.provider_list;
                        this.filtered_biller_list = this.biller_list;
                        return;
                    }

                    this.filtered_biller_list = this.biller_list.filter((biller) => biller.toLowerCase()
                        .includes(val.toLowerCase()));

                    this.filtered_provider_list = this.provider_list.filter((provider) => provider.name
                        .toLowerCase()
                        .includes(val.toLowerCase()));
                });
            },

            select_all(tab) {
                if (tab == 'providers') {
                    this.selected_provider_codes = this.filtered_provider_list.map((provider) => provider.code);
                } else {
                    this.selected_biller_names = this.filtered_biller_list;
                }
            },

            cancel_selection() {
                this.selected_biller_names = this.applied_biller_names_selection;
                this.selected_provider_codes = this.applied_provider_codes_selection;
                this.$wire.dispatch('close' + this.destination_event);
            },

            apply_selection() {
                this.$wire.dispatch("set" + this.destination_event, {
                    biller_names: this.selected_biller_names,
                    provider_codes: this.selected_provider_codes,
                });
            }
        }));
    </script>
@endscript
