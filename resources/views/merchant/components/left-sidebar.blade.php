<aside class="relative bg-white z-10 transition-all border-r border-r-rp-neutral-100" :class="$store.left_sidebar.is_minimized ? 'w-[80px]' : 'w-[300px]'">
    {{-- sidebar resize button --}}
    <div class="absolute w-12 h-12 flex items-center justify-center top-10 -right-6 rounded-full bg-white shadow-lg z-20 cursor-pointer hover:bg-rp-neutral-100" @click="$store.left_sidebar.toggleSidebarSize()">
        <template x-if="$store.left_sidebar.is_minimized">
            <x-icon.double-arrow-right />
        </template>
        <template x-if="!$store.left_sidebar.is_minimized">
            <x-icon.double-arrow-left />
        </template>
    </div>
    <div class="overflow-hidden h-full">
        <div class="bg-white overflow-hidden  relative max-w-[300px] w-[300px] px-5 pb-5 pt-3 min-h-full flex flex-col justify-between gap-8">
            <div class="space-y-4">
                <div>
                    <a href="{{ route('home') }}" class="block w-full h-[48px]">
                        {{-- for improvement: apply better sizing for image --}}
                        <div x-cloak x-show="$store.left_sidebar.is_minimized === true" class="w-max h-[38px]">
                            <img src="{{ url('/images/isolated-repay-logo-colored.png') }}" class="w-full h-full" alt="Repay Logo">
                        </div>
                        <div x-cloak x-show="$store.left_sidebar.is_minimized === false">
                            <x-logo.colored-repay-logo />
                        </div>
                    </a>
                    {{-- Horizontal Line --}}
                    <div class="w-full h-[1px] bg-rp-neutral-100"></div>
                </div>
                <nav class="w-full space-y-7" wire:ignore>
                    <div>
                        <p class="text-rp-neutral-500 text-sm text-ellipsis whitespace-nowrap overflow-hidden" 
                        :class="$store.left_sidebar.is_minimized && 'w-12'">Financial Transactions</p>
                        <nav class="mt-2 mb-3">
                            <ul class="space-y-1">
                                <li>
                                    @can('merchant-ft-dashboard', [request('merchant'), 'view'])
                                        <a href={{ route('merchant.financial-transactions.dashboard', request('merchant')) }}
                                            class="{{ request()->routeIs('merchant.financial-transactions.dashboard') ? 'bg-primary-50 font-bold text-primary-600' : 'hover:bg-rp-neutral-50' }} h-10 flex gap-3 items-center px-3 py-2 rounded-lg transition-all"
                                            :class="$store.left_sidebar.is_minimized && 'w-max'">
                                            <x-icon.grid-view :fill="request()->routeIs('merchant.financial-transactions.dashboard') ? '#7f56d9' : '#90A1AD'" />
                                            <p x-cloak x-show="$store.left_sidebar.is_minimized === false">Dashboard</p>
                                        </a>
                                    @endcan
                                </li>
                                <li>
                                    @can('merchant-cash-inflow', [request('merchant'), 'view'])
                                        <a href={{ route('merchant.financial-transactions.cash-inflow', request('merchant')) }}
                                            class="{{ request()->routeIs('merchant.financial-transactions.cash-inflow') ? 'bg-primary-50 font-bold text-primary-600' : 'hover:bg-rp-neutral-50' }} h-10 flex gap-3 items-center px-3 py-2 rounded-lg transition-all " :class="$store.left_sidebar.is_minimized && 'w-max'">
                                            <x-icon.filled-cash :fill="request()->routeIs('merchant.financial-transactions.cash-inflow') ? '#7f56d9' : '#90A1AD'"  />
                                            <p x-cloak x-show="$store.left_sidebar.is_minimized === false">Cash Inflow</p>
                                        </a>
                                    @endcan
                                </li>
                                <li>
                                    @can('merchant-cash-outflow', [request('merchant'), 'view'])
                                        <a href={{ route('merchant.financial-transactions.cash-outflow.index', request('merchant')) }}
                                            class="group {{ request()->routeIs('merchant.financial-transactions.cash-outflow.*') ? 'bg-primary-50 font-bold text-primary-600' : 'hover:bg-rp-neutral-50' }} h-10 flex justify-between items-center px-3 py-2  rounded-lg transition-all"
                                            :class="$store.left_sidebar.is_minimized && 'w-max'">
                                            <div class="flex items-center gap-3">
                                                <x-icon.wallet :fill="request()->routeIs('merchant.financial-transactions.cash-outflow.*') ? '#7f56d9' : '#90A1AD'" />
                                                <p x-show="$store.left_sidebar.is_minimized === false">Cash Outflow</p>
                                            </div>
                                            <button x-cloak x-show="$store.left_sidebar.is_minimized === false" @click.prevent="() => window.location.href='{{ route('merchant.financial-transactions.cash-outflow.create', ['merchant' => request('merchant'), 'type' => 'money-transfer']) }}'" class="group-hover:block hidden">
                                                <x-icon.add-filled :height="22" :fill="request()->routeIs('merchant.financial-transactions.cash-outflow.*') ? '#7f56d9' : '#90A1AD'" />
                                            </button>
                                        </a>
                                    @endcan
                                </li>
                                <li>
                                    @can('merchant-invoices', [request('merchant'), 'view'])
                                        <a  href="{{ route('merchant.financial-transactions.invoices.index', request('merchant')) }}"
                                            class="{{ request()->routeIs('merchant.financial-transactions.invoices.*') ? 'bg-primary-50 font-bold text-primary-600' : 'hover:bg-rp-neutral-50' }} h-10 flex gap-3 items-center px-3 py-2  rounded-lg transition-all"
                                            :class="$store.left_sidebar.is_minimized && 'w-max'">
                                            <x-icon.filled-document :fill="request()->routeIs('merchant.financial-transactions.invoices.*') ? '#7f56d9' : '#90A1AD'" />
                                            <p x-cloak x-show="$store.left_sidebar.is_minimized === false">Invoices</p>
                                        </a>
                                    @endcan
                                </li>
                                <li>
                                    @can('merchant-bills', [request('merchant'), 'view'])
                                        <a  href="{{ route('merchant.financial-transactions.bills.index', request('merchant')) }}"
                                            class="{{ request()->routeIs('merchant.financial-transactions.bills.*') ? 'bg-primary-50 font-bold text-primary-600' : 'hover:bg-rp-neutral-50' }} h-10 flex gap-3 items-center px-3 py-2  rounded-lg transition-all"
                                            :class="$store.left_sidebar.is_minimized && 'w-max'"
                                            >
                                            <x-icon.bills :fill="request()->routeIs('merchant.financial-transactions.bills.*') ? '#7f56d9' : '#90A1AD'" />
                                            <p x-cloak x-show="$store.left_sidebar.is_minimized === false">Bills</p>
                                        </a>
                                    @endcan
                                </li>
                                <li>
                                    @can('merchant-employees', [request('merchant'), 'view'])
                                        <a  href="{{ route('merchant.financial-transactions.employees.index', request('merchant')) }}"
                                            class="{{ request()->routeIs('merchant.financial-transactions.employees.*') ? 'bg-primary-50 font-bold text-primary-600' : 'hover:bg-rp-neutral-50' }} h-10 flex gap-3 items-center px-3 py-2  rounded-lg transition-all"
                                            :class="$store.left_sidebar.is_minimized && 'w-max'">
                                            <x-icon.user width="17" height="17" :fill="request()->routeIs('merchant.financial-transactions.employees.*') ? '#7f56d9' : '#90A1AD'" />
                                            <p x-cloak x-show="$store.left_sidebar.is_minimized === false">Employees</p>
                                        </a>
                                    @endcan
                                </li>
                                <li>
                                    @can('merchant-payroll', [request('merchant'), 'view'])
                                        <a  href="{{ route('merchant.financial-transactions.payroll.index', request('merchant')) }}"
                                            class="group {{ request()->routeIs('merchant.financial-transactions.payroll.*') ? 'bg-primary-50 font-bold text-primary-600' : 'hover:bg-rp-neutral-50' }} h-10 flex items-center justify-between px-3 py-2  rounded-lg"
                                            :class="$store.left_sidebar.is_minimized && 'w-max'">
                                            <div class="flex gap-3 items-center">
                                                <x-icon.book :fill="request()->routeIs('merchant.financial-transactions.payroll.*') ? '#7f56d9' : '#90A1AD'" />
                                                <p x-cloak x-show="$store.left_sidebar.is_minimized === false">Payroll</p>
                                            </div>
                                            <button x-cloak x-show="$store.left_sidebar.is_minimized === false" @click.prevent="() => window.location.href='{{ route('merchant.financial-transactions.payroll.create', ['merchant' => request('merchant')]) }}'" class="group-hover:block hidden">
                                                <x-icon.add-filled :height="22" :fill="request()->routeIs('merchant.financial-transactions.payroll.*') ? '#7f56d9' : '#90A1AD'" />
                                            </button>
                                        </a>
                                    @endcan
                                </li>
                            </ul>
                        </nav>
                        {{-- Horizontal Line --}}
                        <div class="w-full h-[1px] bg-rp-neutral-100"></div>
                    </div>
            
                    <div>
                        <p class="text-rp-neutral-500 text-sm text-ellipsis whitespace-nowrap overflow-hidden"
                        :class="$store.left_sidebar.is_minimized && 'w-12'">Seller Center</p>
                        <nav class="mt-2">
                            <ul class="space-y-1">
                                <li>
                                    @can('merchant-sc-dashboard', [request('merchant'), 'view'])
                                        <a href="{{ route('merchant.seller-center.dashboard', request('merchant')) }}" class="{{request()->routeIs('merchant.seller-center.dashboard') ? 'bg-primary-50 font-bold text-primary-600' : 'hover:bg-rp-neutral-50'}} h-10 flex gap-3 items-center px-3 py-2 rounded-lg transition-all"
                                            :class="$store.left_sidebar.is_minimized && 'w-max'">
                                            <x-icon.grid-view :fill="request()->routeIs('merchant.seller-center.dashboard') ? '#7f56d9' : '#90A1AD'" />
                                            <p x-cloak x-show="$store.left_sidebar.is_minimized === false">Dashboard</p>
                                        </a>
                                    @endcan
                                </li>
                                <li>
                                    @can('merchant-store-management', [request('merchant'), 'view'])
                                        <a  href="{{ route('merchant.seller-center.store-management', request('merchant')) }}" class="{{request()->routeIs('merchant.seller-center.store-management') ? 'bg-primary-50 font-bold text-primary-600' : 'hover:bg-rp-neutral-50'}} h-10 flex gap-3 items-center px-3 py-2 rounded-lg transition-all"
                                            :class="$store.left_sidebar.is_minimized && 'w-max'">
                                            <x-icon.shop :fill="request()->routeIs('merchant.seller-center.store-management') ? '#7f56d9' : '#90A1AD'" />
                                            <p x-cloak x-show="$store.left_sidebar.is_minimized === false">Store Management</p>
                                        </a>
                                    @endcan
                                </li>
                                <li>
                                    @can('merchant-products', [request('merchant'), 'view'])
                                        <a  href="{{ route('merchant.seller-center.assets.index', request('merchant')) }}" class="{{request()->routeIs('merchant.seller-center.assets.*') ? 'bg-primary-50 font-bold text-primary-600' : 'hover:bg-rp-neutral-50'}} h-10 flex gap-3 items-center px-3 py-2 rounded-lg transition-all"
                                            :class="$store.left_sidebar.is_minimized && 'w-max'">
                                            <x-icon.bag :fill="request()->routeIs('merchant.seller-center.assets.*') ? '#7f56d9' : '#90A1AD'" />
                                            <p x-cloak x-show="$store.left_sidebar.is_minimized === false">Assets</p>
                                        </a>
                                    @endcan
                                </li>
                                <li>
                                    @can('merchant-services', [request('merchant'), 'view'])
                                        <a  href="{{ route('merchant.seller-center.services.index', request('merchant')) }}" class="{{request()->routeIs('merchant.seller-center.services.*') ? 'bg-primary-50 font-bold text-primary-600' : 'hover:bg-rp-neutral-50'}} h-10 flex gap-3 items-center px-3 py-2  rounded-lg transition-all"
                                            :class="$store.left_sidebar.is_minimized && 'w-max'">
                                            <x-icon.services :fill="request()->routeIs('merchant.seller-center.services.*') ? '#7f56d9' : '#90A1AD'" />
                                            <p x-cloak x-show="$store.left_sidebar.is_minimized === false">Services</p>
                                        </a>
                                    @endcan
                                </li>
                                <li>
                                    @canany(['merchant-orders', 'merchant-return-orders', 'merchant-warehouse'], [request('merchant'), 'view'])    
                                        <a  href="{{ route('merchant.seller-center.logistics.orders.index', request('merchant')) }}" class="{{request()->routeIs('merchant.seller-center.logistics.*') ? 'bg-primary-50 font-bold text-primary-600' : 'hover:bg-rp-neutral-50' }} h-10 flex gap-3 items-center px-3 py-2 rounded-lg transition-all"
                                            :class="$store.left_sidebar.is_minimized && 'w-max'">
                                            <x-icon.logistics :fill="request()->routeIs('merchant.seller-center.logistics.*') ? '#7f56d9' : '#90A1AD'" />
                                            <p x-cloak x-show="$store.left_sidebar.is_minimized === false">Logistics</p>
                                        </a>
                                    @endcanany
                                </li>
                                {{-- <li>
                                    <a  href="{{route('', request('merchantIdentifier'))}}" class="{{request()->routeIs('merchant.employees') || request()->routeIs('merchant.employee-detail') || request()->routeIs('merchant.add-employee') || request()->routeIs('merchant.add-employee') ? 'bg-primary-50 font-bold text-primary-600' : 'hover:bg-rp-neutral-50'}}  flex gap-3 items-center px-3 py-2  rounded-lg transition-all">
                                        <div class="w-[15%]">
                                            <svg  width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M13 0C13.5304 0 14.0391 0.210714 14.4142 0.585786C14.7893 0.960859 15 1.46957 15 2V3H16.52C16.8198 3.00004 17.1157 3.06746 17.3859 3.19728C17.6561 3.3271 17.8936 3.51599 18.081 3.75L19.561 5.601C19.8451 5.95569 19.9999 6.39656 20 6.851V11C20 11.5304 19.7893 12.0391 19.4142 12.4142C19.0391 12.7893 18.5304 13 18 13H17C17 13.7956 16.6839 14.5587 16.1213 15.1213C15.5587 15.6839 14.7956 16 14 16C13.2044 16 12.4413 15.6839 11.8787 15.1213C11.3161 14.5587 11 13.7956 11 13H8C8 13.394 7.9224 13.7841 7.77164 14.1481C7.62087 14.512 7.3999 14.8427 7.12132 15.1213C6.84274 15.3999 6.51203 15.6209 6.14805 15.7716C5.78407 15.9224 5.39397 16 5 16C4.60603 16 4.21593 15.9224 3.85195 15.7716C3.48797 15.6209 3.15726 15.3999 2.87868 15.1213C2.6001 14.8427 2.37913 14.512 2.22836 14.1481C2.0776 13.7841 2 13.394 2 13C1.46957 13 0.960859 12.7893 0.585786 12.4142C0.210714 12.0391 0 11.5304 0 11V2C0 1.46957 0.210714 0.960859 0.585786 0.585786C0.960859 0.210714 1.46957 0 2 0H13ZM5 12C4.73478 12 4.48043 12.1054 4.29289 12.2929C4.10536 12.4804 4 12.7348 4 13C4 13.2652 4.10536 13.5196 4.29289 13.7071C4.48043 13.8946 4.73478 14 5 14C5.26522 14 5.51957 13.8946 5.70711 13.7071C5.89464 13.5196 6 13.2652 6 13C6 12.7348 5.89464 12.4804 5.70711 12.2929C5.51957 12.1054 5.26522 12 5 12ZM14 12C13.7348 12 13.4804 12.1054 13.2929 12.2929C13.1054 12.4804 13 12.7348 13 13C13 13.2652 13.1054 13.5196 13.2929 13.7071C13.4804 13.8946 13.7348 14 14 14C14.2652 14 14.5196 13.8946 14.7071 13.7071C14.8946 13.5196 15 13.2652 15 13C15 12.7348 14.8946 12.4804 14.7071 12.2929C14.5196 12.1054 14.2652 12 14 12ZM16.52 5H15V9H18V6.85L16.52 5Z" fill="#90A1AD"/>
                                            </svg>
                                        </div>
                                        <div class="w-[85%]">
                                            <p>Fleet Management</p>
                                        </div>
                                    </a>
                                </li> --}}
                                <li>
                                    @can('merchant-disputes', [request('merchant'), 'view'])
                                        <a  href="{{ route('merchant.seller-center.disputes.index', request('merchant')) }}" class="{{request()->routeIs('merchant.seller-center.disputes.*') ? 'bg-primary-50 font-bold text-primary-600' : 'hover:bg-rp-neutral-50'}} h-10 flex gap-3 items-center px-3 py-2  rounded-lg"
                                            :class="$store.left_sidebar.is_minimized && 'w-max'">
                                            <x-icon.disputes :fill="request()->routeIs('merchant.seller-center.disputes.*') ? '#7f56d9' : '#90A1AD'"/>
                                            <p x-cloak x-show="$store.left_sidebar.is_minimized === false">Disputes</p>
                                        </a>
                                    @endcan
                                </li>
                            </ul>
                        </nav>
                    </div>
            
                </nav>
            </div>
            <button class="w-full h-10" @click.prevent="$refs.logout_form.submit()" :class="$store.left_sidebar.is_minimized && 'w-max'">
                <form id="logout-form" x-ref="logout_form" method="POST" action="{{ route('logout') }}" class="hidden">
                    @csrf
                </form>
                <div class="flex gap-3 items-center px-3 py-2 rounded-lg hover:bg-rp-neutral-50">
                    <x-icon.logout />
                    <span x-cloak x-show="$store.left_sidebar.is_minimized === false">Log out</span>
                </div>
            </button>
            {{-- <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path d="M14.2 0H5.82001C2.18001 0 0.0100098 2.17 0.0100098 5.81V14.18C0.0100098 17.83 2.18001 20 5.82001 20H14.19C17.83 20 20 17.83 20 14.19V5.81C20.01 2.17 17.84 0 14.2 0ZM14.01 10.75H10.76V14C10.76 14.41 10.42 14.75 10.01 14.75C9.60001 14.75 9.26001 14.41 9.26001 14V10.75H6.01001C5.60001 10.75 5.26001 10.41 5.26001 10C5.26001 9.59 5.60001 9.25 6.01001 9.25H9.26001V6C9.26001 5.59 9.60001 5.25 10.01 5.25C10.42 5.25 10.76 5.59 10.76 6V9.25H14.01C14.42 9.25 14.76 9.59 14.76 10C14.76 10.41 14.42 10.75 14.01 10.75Z" fill="#7F56D9"/>
            </svg> --}}
        </div>
    </div>
</aside>