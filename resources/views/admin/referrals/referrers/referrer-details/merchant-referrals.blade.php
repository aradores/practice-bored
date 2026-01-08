<div>
    {{-- Pending/Verified List --}}
    <x-table.standard>
        <x-slot:table_header class="text-rp-neutral-600">
            <x-table.standard.th class="!px-0 !py-0 !pb-3">
                <div class="flex gap-2">
                    <div class="font-normal">{{ $referral_type == 'pending' ? 'Pending' : 'Verified' }}</div>
                    <div>{{ $referral_type == 'pending' ? count($this->pending_merchants) : count($this->verified_merchants) }}
                    </div>
                </div>
            </x-table.standard.th>
            <x-table.standard.th class="!px-0 !py-0 !pb-3">
                <div class="flex justify-end gap-2">
                    <button type="button" wire:click="$set('referral_type', 'pending')"
                        {{ $referral_type == 'pending' ? 'disabled' : '' }}>
                        <x-icon.chevron-left color="{{ $referral_type == 'pending' ? '#D3DADE' : '#647887' }}" />
                    </button>
                    <button type="button" wire:click="$set('referral_type', 'verified')"
                        {{ $referral_type == 'verified' ? 'disabled' : '' }}>
                        <x-icon.chevron-right color="{{ $referral_type == 'verified' ? '#D3DADE' : '#647887' }}" />
                    </button>
                </div>
            </x-table.standard.th>
        </x-slot:table_header>
        <x-slot:table_data>
            @if ($referral_type == 'pending')
                @foreach ($this->pending_merchants as $referred_merchant)
                    <x-table.standard.row class="text-sm">
                        <x-table.standard.td class="w-full !px-2">

                            <div class="flex flex-row items-center gap-3">
                                <div class="h-8 w-8 max-h-8 max-w-8 rounded-full overflow-hidden">
                                    @if ($referred_merchant->logo_url)
                                        <img src="{{ $referred_merchant->logo_url }}" alt="Merchant's Avatar"
                                            class="w-full h-full object-cover rounded-full">
                                    @else
                                        <img src="{{ url('images/user/default-avatar.png') }}" alt="Merchant's Avatar"
                                            class="w-full h-full object-cover rounded-full">
                                    @endif
                                </div>
                                <a href="{{ $referred_merchant->profile_url }}" class="text-primary-600 text-sm underline">
                                    <div class="flex items-center gap-1">{{ $referred_merchant->merchant->name }} <x-icon.eye />
                                    </div>
                                </a>
                            </div>
                        </x-table.standard.td>
                        <x-table.standard.td class="w-full !px-2">
                            <span class="text-rp-yellow-500 font-bold">Pending</span>
                        </x-table.standard.td>
                    </x-table.standard.row>
                @endforeach
            @else
                @foreach ($this->verified_merchants as $referred_merchant)
                    <x-table.standard.row class="text-sm">
                        <x-table.standard.td class="w-full !px-2">

                            <div class="flex flex-row items-center gap-3">
                                <div class="h-8 w-8 max-h-8 max-w-8 rounded-full overflow-hidden">
                                    @if ($referred_merchant->logo_url)
                                        <img src="{{ $referred_merchant->logo_url }}" alt="Merchant's Avatar"
                                            class="w-full h-full object-cover rounded-full">
                                    @else
                                        <img src="{{ url('images/user/default-avatar.png') }}" alt="Merchant's Avatar"
                                            class="w-full h-full object-cover rounded-full">
                                    @endif
                                </div>
                                <a href="{{ $referred_merchant->profile_url }}" class="text-primary-600 text-sm underline">
                                    <div class="flex items-center gap-1">{{ $referred_merchant->merchant->name }}
                                        <x-icon.eye />
                                    </div>
                                </a>
                            </div>
                        </x-table.standard.td>
                        <x-table.standard.td class="w-full !px-2">
                            <span class="text-rp-green-600 font-bold">Verified</span>
                        </x-table.standard.td>
                    </x-table.standard.row>
                @endforeach
            @endif
        </x-slot:table_data>
    </x-table.standard>
</div>
