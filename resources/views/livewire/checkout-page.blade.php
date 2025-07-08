<div>
    <div class="container mx-auto px-4 py-12 mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:items-start">
            {{-- Резюме заказа --}}
            <div class="px-6 py-8 space-y-4 bg-white border border-gray-100 lg:sticky lg:top-8 rounded-xl lg:order-last">
                <h3 class="font-medium">{{ __('cart.order_summary') }}</h3>
                <div class="flow-root">
                    <div class="-my-4 divide-y divide-gray-100">
                        @forelse ($cart->lines as $line)
                            <div class="flex items-center py-4" wire:key="cart_line_{{ $line->id }}">
                                <img class="object-cover w-16 h-16 rounded"
                                     src="{{ $line->purchasable->getThumbnail() ? $line->purchasable->getThumbnail()->getUrl() : asset('images/fallback-product.jpg') }}"
                                     alt="{{ $line->purchasable->getDescription() ?? 'Product Image' }}">
                                <div class="flex-1 ml-4">
                                    <p class="text-sm font-medium max-w-[35ch]">
                                        {{ $line->purchasable->getDescription() }}
                                    </p>
                                    <span class="block mt-1 text-xs text-gray-500">
                                        {{ $line->quantity }} @ {{ $line->subTotal?->formatted() ?? '0.00' }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">{{ __('messages.cart.empty') }}</p>
                        @endforelse
                    </div>
                </div>
                <div class="flow-root">
                    <dl class="-my-4 text-sm divide-y divide-gray-100">
                        {{-- Способ доставки без цены --}}
                        @if ($shippingOption)
                            <div class="flex flex-wrap py-4">
                                <dt class="w-full font-medium">
                                    {{ $shippingOption['description'] }}
                                </dt>
                            </div>
                        @endif

                        {{-- Итог --}}
                        <div class="flex flex-wrap py-4">
                            <dt class="w-1/2 font-medium">{{ __('messages.cart.total') }}</dt>
                            <dd class="w-1/2 text-right">
                                {{ $cart->total?->formatted() ?? '0.00' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- Шаги чекаута --}}
            <div>
                @if($currentStep === $steps['personal_info'])
                    @include('partials.checkout.address')
                @endif

                @if($currentStep === $steps['delivery'])
                    @include('partials.checkout.shipping_option')
                @endif

                @if($currentStep === $steps['payment'])
                    @include('partials.checkout.payment')
                @endif
            </div>
        </div>
    </div>
</div>
