<form wire:submit.prevent="saveShippingOption" class="bg-white p-8 rounded-3xl border border-gray-100 max-md:p-5">
    <header class="flex gap-4 items-start w-full text-base font-semibold leading-none max-md:max-w-full">
        <div class="flex flex-col justify-center items-center text-center text-white whitespace-nowrap rounded-2xl bg-zinc-800 h-[22px] w-[22px]" aria-label="{{ __('messages.checkout.step_2') }}">
            <span class="text-white">2</span>
        </div>
        <h1 id="form-heading" class="flex-1 shrink basis-0 text-zinc-800">
            {{ __('messages.checkout.delivery') }}
        </h1>
    </header>

    <div class="mt-10 w-full text-base font-semibold leading-none whitespace-nowrap text-neutral-400 max-md:max-w-full space-y-4">
        @foreach($shippingOptions as $option)
            <label class="flex items-center p-4 border rounded-2xl border-neutral-400 hover:bg-zinc-50 cursor-pointer">
                <input
                    type="radio"
                    wire:model.live="chosenShipping"
                    value="{{ $option['identifier'] }}"
                    class="w-5 h-5 text-green-600 border-neutral-400 focus:ring-green-600"
                    aria-label="{{ $option['description'] }}"
                />
                <span class="ml-4">
                    <p class="text-sm font-medium text-zinc-800">{{ $option['description'] }}</p>
                    <p class="text-xs text-neutral-400">{{ __('messages.checkout.free_shipping') }}</p>
                </span>
            </label>
            @error('chosenShipping')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        @endforeach

        <!-- Самовивіз -->
        @if($chosenShipping === 'pickup')
            <div class="mt-4">
                <p class="text-sm text-neutral-400">{{ __('messages.checkout.pickup_info') }}</p>
            </div>
        @endif

        <!-- Нова Пошта -->
        @if($chosenShipping === 'nova-poshta')
            <div class="mt-4">
                <label for="np-city-search" class="block text-sm font-medium text-zinc-800 mb-1">{{ __('messages.checkout.city') }}</label>
                <div class="flex overflow-hidden gap-2 items-center px-4 py-3.5 w-full rounded-2xl border border-solid border-neutral-400 min-h-12 max-md:max-w-full">
                    <input
                        type="text"
                        id="np-city-search"
                        wire:model.live.debounce.500ms="citySearchTerm"
                        placeholder="{{ __('messages.checkout.enter_city') }}"
                        class="flex-1 shrink self-stretch my-auto basis-0 text-neutral-400 bg-transparent border-none outline-none"
                        aria-label="{{ __('messages.checkout.enter_city') }}"
                    />
                </div>
                @if(!empty($npCities) && $showCityDropdown)
                    <div class="mt-2 max-h-40 overflow-y-auto border border-neutral-400 rounded-2xl bg-white z-10">
                        @foreach($npCities as $city)
                            <div
                                wire:click="selectCity('{{ $city['MainDescription'] }}')"
                                class="px-4 py-2 hover:bg-zinc-50 cursor-pointer text-sm text-zinc-800"
                            >
                                {{ $city['MainDescription'] }}
                            </div>
                        @endforeach
                    </div>
                @endif
                @error('shipping.city') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mt-4">
                <label for="np-warehouse" class="block text-sm font-medium text-zinc-800 mb-1">{{ __('messages.checkout.warehouse') }}</label>
                <div class="flex overflow-hidden gap-2 items-center px-4 py-3.5 w-full rounded-2xl border border-solid border-neutral-400 min-h-12 max-md:max-w-full">
                    <select
                        id="np-warehouse"
                        wire:model.live="shipping.line_one"
                        class="flex-1 shrink self-stretch my-auto basis-0 text-neutral-400 bg-transparent border-none outline-none"
                        aria-label="{{ __('messages.checkout.select_warehouse') }}"
                        @if(empty($npWarehouses)) disabled @endif
                    >
                        <option value="">{{ __('messages.checkout.select_warehouse') }}</option>
                        @foreach($npWarehouses as $warehouse)
                            <option value="{{ $warehouse['Description'] }}">{{ $warehouse['Description'] }}</option>
                        @endforeach
                    </select>
                </div>
                @if(empty($npWarehouses) && !empty($shipping->city))
                    <p class="mt-1 text-sm text-neutral-400">{{ __('messages.checkout.select_city_for_warehouses') }}</p>
                @endif
                @error('shipping.line_one') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        @endif

        <!-- Кур'єр -->
        @if($chosenShipping === 'courier')
            <div class="mt-4">
                <label for="courier-city" class="block text-sm font-medium text-zinc-800 mb-1">{{ __('messages.checkout.city') }}</label>
                <div class="flex overflow-hidden gap-2 items-center px-4 py-3.5 w-full rounded-2xl border border-solid border-neutral-400 min-h-12 max-md:max-w-full">
                    <input
                        type="text"
                        id="courier-city"
                        wire:model.live.debounce.500ms="citySearchTerm"
                        placeholder="{{ __('messages.checkout.enter_city') }}"
                        class="flex-1 shrink self-stretch my-auto basis-0 text-neutral-400 bg-transparent border-none outline-none"
                        aria-label="{{ __('messages.checkout.enter_city') }}"
                    />
                </div>
                @if(!empty($npCities) && $showCityDropdown)
                    <div class="mt-2 max-h-40 overflow-y-auto border border-neutral-400 rounded-2xl bg-white z-10">
                        @foreach($npCities as $city)
                            <div
                                wire:click="selectCity('{{ $city['MainDescription'] }}')"
                                class="px-4 py-2 hover:bg-zinc-50 cursor-pointer text-sm text-zinc-800"
                            >
                                {{ $city['MainDescription'] }}
                            </div>
                        @endforeach
                    </div>
                @endif
                @error('shipping.city') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mt-4">
                <label for="courier-address" class="block text-sm font-medium text-zinc-800 mb-1">{{ __('messages.checkout.address') }}</label>
                <div class="flex overflow-hidden gap-2 items-center px-4 py-3.5 w-full rounded-2xl border border-solid border-neutral-400 min-h-12 max-md:max-w-full">
                    <input
                        type="text"
                        id="courier-address"
                        wire:model.lazy="shipping.line_one"
                        placeholder="{{ __('messages.checkout.enter_address') }}"
                        class="flex-1 shrink self-stretch my-auto basis-0 text-neutral-400 bg-transparent border-none outline-none"
                        aria-label="{{ __('messages.checkout.enter_address') }}"
                    />
                </div>
                @error('shipping.line_one') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        @endif
    </div>

    <!-- Navigation Buttons -->
    <div class="mt-8 flex gap-4 items-center w-full text-base font-bold leading-snug whitespace-nowrap max-md:max-w-full max-md:flex-col max-md:gap-4">
        <button
            type="button"
            wire:click="goBackStep"
            class="flex gap-2 justify-center items-center self-stretch px-6 py-2.5 my-auto text-green-600 rounded-2xl border-2 border-green-600 border-solid min-h-11 max-md:px-5 hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2"
            aria-label="{{ __('messages.checkout.back') }}"
        >
            <span class="self-stretch my-auto text-green-600">{{ __('messages.checkout.back') }}</span>
        </button>
        <button
            type="submit"
            wire:loading.attr="disabled"
            class="flex gap-2 justify-center items-center self-stretch px-6 py-2.5 my-auto text-white bg-green-600 rounded-2xl min-h-11 max-md:px-5 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
            aria-label="{{ __('messages.checkout.continue') }}"
            @if(
                !$chosenShipping ||
                ($chosenShipping === 'nova-poshta' && (empty($shipping->city) || empty($shipping->line_one))) ||
                ($chosenShipping === 'courier' && (empty($shipping->city) || empty($shipping->line_one)))
            ) disabled @endif
        >
            <span wire:loading.remove>{{ __('messages.checkout.continue') }}</span>
            <span wire:loading>{{ __('messages.checkout.saving') }}</span>
        </button>
    </div>

    <!-- Step Indicators -->
    <nav class="mt-10 w-full text-base font-semibold leading-none whitespace-nowrap max-md:max-w-full" aria-label="{{ __('messages.checkout.steps') }}">
        <div class="flex gap-4 items-start max-w-full min-h-[22px] w-[440px]">
            <div class="flex flex-col justify-center items-center text-center text-white rounded-2xl bg-neutral-400 h-[22px] w-[22px]" aria-label="{{ __('messages.checkout.step_1') }}">
                <span class="text-white">1</span>
            </div>
            <span class="flex-1 shrink basis-0 text-neutral-400">{{ __('messages.checkout.personal_info') }}</span>
        </div>

        <div class="flex gap-4 items-start mt-4 max-w-full min-h-[22px] w-[440px]">
            <div class="flex flex-col justify-center items-center text-center text-white rounded-2xl bg-neutral-400 h-[22px] w-[22px]" aria-label="{{ __('messages.checkout.step_3') }}">
                <span class="text-white">3</span>
            </div>
            <span class="flex-1 shrink basis-0 text-neutral-400">{{ __('messages.checkout.payment') }}</span>
        </div>
    </nav>
</form>

<style>
    /* Custom radio styling */
    input[type="radio"]:checked {
        background-color: #10b981;
        border-color: #10b981;
    }

    input[type="radio"]:focus {
        outline: 2px solid #3b82f6;
        outline-offset: 2px;
    }

    /* Select and input focus styles */
    select:focus, input:focus {
        outline: 2px solid #3b82f6;
        outline-offset: 2px;
    }

    /* Placeholder styling */
    input::placeholder, select:invalid {
        color: #a3a3a3;
    }
</style>
