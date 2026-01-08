<div class="mt-8">
    <div class="flex flex-row justify-between">
        <div class="flex items-center gap-5 mb-5">
            <h1 class="text-rp-neutral-700 text-[28px] font-bold">Featured Services</h1>
            @if ($can_update)
                {{-- EDIT BUTTON --}}
                <div class="h-[25px]">
                    <button @click="$wire.showFeaturedServicesModal=true">
                        <x-icon.edit />
                    </button>
                </div>
            @endif
        </div>
    </div>

    {{-- List --}}
    <div class="swiper">
        <div class="swiper-wrapper flex flex-row gap-4">
            @forelse ($this->featured_services as $key => $service)
                <div class="swiper-slide w-[215px] mb-4" wire:key="service-{{ $key }}">
                    <div class=" h-[166px] rounded-t-[13px] overflow-hidden">
                        <div class="relative h-full">
                            <img class="object-cover w-full h-full"
                                src="{{ $this->get_media_url($service->first_image, 'thumbnail') }}" alt="">
                        </div>
                    </div>

                    <div class=" p-[13px] bg-white rounded-b-[14px] shadow-md">
                        <p class="text-rp-neutral-500 text-[9px]">Service</p>
                        {{-- PRODUCT NAME --}}
                        <h3
                            class="text-rp-neutral-800 text-[13px] font-bold mb-1 max-h-[3em] overflow-hidden text-ellipsis">
                            {{ $service->name }}
                        </h3>
                        {{-- Address --}}
                        <h2 class="text-rp-purple-600 text-[16px] font-bold max-h-[3em] overflow-hidden text-ellipsis">
                            {{ $service->location->address }}
                        </h2>

                        <div class="flex gap-1 items-center pt-[6px]">
                            {{-- OVER-ALL STAR RATINGS --}}
                            <div class="flex gap-1">
                                @php
                                    $serviceRating = $service->rating;
                                @endphp
                                @for ($i = 1; $i <= 5; $i++)
                                    @php
                                        $fillType = 'none';
                                        if ($serviceRating >= $i) {
                                            $fillType = 'full';
                                        } elseif ($serviceRating > $i - 1 && $serviceRating < $i) {
                                            $fillType = 'half';
                                        }
                                    @endphp
                                    <x-icon.product.star key="star{{ $service->id . $i }}"
                                        fillType="{{ $fillType }}" width="12" height="12" />
                                @endfor
                            </div>

                            <p class="text-rp-neutral-500 text-[11px]">
                                ({{ $service->reviews_count }})
                            </p>


                        </div>
                    </div>
                </div>
            @empty
                <p class="italic">
                    No featured services ...
                </p>
            @endforelse
        </div>
    </div>

    @if ($can_update)
        <x-modal x-model="$wire.showFeaturedServicesModal" x-cloak aria-modal="true">
            <livewire:merchant.seller-center.store-management.services-list :merchant="$merchant" />
        </x-modal>
    @endif
</div>
