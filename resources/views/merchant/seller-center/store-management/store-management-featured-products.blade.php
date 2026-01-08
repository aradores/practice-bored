<div class="mt-8 w-full" x-data>
    <div class="flex flex-row justify-between">
        <div class="flex items-center gap-5 mb-5">
            <h1 class="text-rp-neutral-700 text-[28px] font-bold">Featured Products</h1>
            @if ($can_update)
                {{-- EDIT BUTTON --}}
                <div class="h-[25px]">
                    <button @click="$wire.showFeaturedProductsModal=true">
                        <x-icon.edit />
                    </button>
                </div>
            @endif
        </div>
    </div>

    {{-- List --}}
    <div class="swiper">
        <div class="swiper-wrapper flex flex-row gap-4">
            @forelse ($this->featured_products as $key => $product)
                <div class="swiper-slide w-[215px] mb-4" wire:key="product-{{ $key }}">
                    <div class="h-[166px] rounded-t-[13px] overflow-hidden">
                        <div class="relative h-full">
                            <img class="object-cover w-full h-full"
                                src="{{ $this->get_media_url($product->first_image, 'thumbnail') }}" alt="">
                            <div class="absolute top-0 flex flex-wrap gap-2 p-2">
                                {{-- PRODUCT TAGS --}}
                                @if ($product->sale_amount > 0)
                                    <div
                                        class="text-[7px] bg-[#CE0058] text-white px-2 py-1 text-center object-contain rounded-3xl font-medium">
                                        Sale</div>
                                @endif
    
                                {{-- <div
                                    class="text-[7px] bg-[#EFF8FF] text-[#175CD3] px-2 py-1 text-center object-contain rounded-3xl font-medium">
                                    3 variants</div> --}}
                                <div
                                    class="text-[7px] bg-[#EEF4FF] text-[#3538CD] px-2 py-1 text-center object-contain rounded-3xl font-medium">
                                    {{ $product->condition->name }}</div>
                                {{-- <div
                                    class="text-[7px] bg-[#ECFDF3] text-[#027A48] px-2 py-1 text-center object-contain rounded-3xl font-medium">
                                    Free Shipping</div> --}}
                            </div>
                        </div>
                    </div>
    
                    <div class=" p-[13px] bg-white rounded-b-[14px] shadow-md">
                        <p class="text-rp-neutral-500 text-[9px]">Product</p>
                        {{-- PRODUCT NAME --}}
                        <h3
                            class="text-rp-neutral-800 text-[13px] font-bold mb-1 max-h-[3em] overflow-hidden text-ellipsis">
                            {{ $product->name }}
                        </h3>
                        {{-- PRODUCT PRICE AFTER DISCOUNT --}}
                        <h2 class="text-rp-purple-600 text-[19px] font-bold">
                            {{ \Number::currency($product->price - $product->price * $product->sale_amount, 'PHP') }}</h2>
    
                        @if ($product->sale_amount > 0)
                            <div class="flex gap-2">
                                {{-- PRODUCT ORIGINAL PRICE --}}
                                <h3 class="line-through text-rp-neutral-500">{{ \Number::currency($product->price, 'PHP') }}
                                </h3>
                                {{-- DISCOUNT --}}
                                <p>-{{ round($product->sale_amount * 100, 2) }}%</p>
                            </div>
                        @endif
                        <div class="flex gap-1">
                            {{-- QUANTITY OF SOLD ITEMS --}}
                            <p class="text-rp-neutral-500 font-bold text-[9px]">{{ $product->sold_count }}</p>
                            <p class="text-rp-neutral-500 text-[9px]">Sold</p>
                        </div>
                        <div class="flex gap-1 items-center pt-[6px]">
                            {{-- OVER-ALL STAR RATINGS --}}
                            <div class="flex items-center gap-1">
                                @php
                                    $productRating = $product->rating;
                                @endphp
                                @for ($i = 1; $i <= 5; $i++)
                                    @php
                                        $fillType = 'none';
                                        if ($productRating >= $i) {
                                            $fillType = 'full';
                                        } elseif ($productRating > $i - 1 && $productRating < $i) {
                                            $fillType = 'half';
                                        }
                                    @endphp
                                    <x-icon.product.star key="star{{ $product->id . $i }}" fillType="{{ $fillType }}"
                                        width="12" height="12" />
                                @endfor
                            </div>
                            <p class="text-rp-neutral-500 text-[11px]">
                                ({{ $product->reviews_count }})
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <p class="italic">
                    No featured products ...
                </p>
            @endforelse
        </div>
    </div>

    @if ($can_update)
        <x-modal x-model="$wire.showFeaturedProductsModal" x-cloak aria-modal="true">
            <livewire:merchant.seller-center.store-management.products-list :merchant="$merchant" />
        </x-modal>
    @endif
</div>
