<form wire:submit.prevent="saveShippingOption" class="bg-white rounded-3xl px-10 py-8 max-md:px-5 max-md:py-6 border border-gray-100">
    <div class="flex items-center justify-between h-16 border-b border-gray-100 px-6">
        <h3 class="text-lg font-semibold text-zinc-800">Варіанти доставки</h3>
    </div>
    <div class="p-6 max-md:p-4">
        <div class="space-y-4">
            @foreach($shippingOptions as $option)
                <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-zinc-50">
                    <input
                        type="radio"
                        wire:model.live="chosenShipping"
                        value="{{ $option['identifier'] }}"
                        class="w-5 h-5 text-green-600 border-gray-300"
                    />
                    <span class="ml-4">
                        <p class="text-sm font-medium">{{ $option['description'] }}</p>
                        <p class="text-xs text-gray-500">Безкоштовна доставка</p>
                    </span>
                </label>
            @endforeach

            <!-- Самовивіз -->
            @if($chosenShipping === 'pickup')
                <div class="mt-4">
                    <p class="text-sm text-gray-600">Самовивіз з магазину. Додаткові поля не потрібні.</p>
                </div>
            @endif

            <!-- Нова Пошта -->
            @if($chosenShipping === 'nova-poshta')
                <div class="mt-4">
                    <label for="np-city-search" class="block text-sm font-medium text-gray-700 mb-1">Місто</label>
                    <input
                        type="text"
                        id="np-city-search"
                        wire:model.live.debounce.500ms="citySearchTerm"
                        placeholder="Введіть назву міста"
                        class="block w-full rounded-2xl border border-gray-400 px-4 py-3.5 text-base font-semibold text-neutral-700 focus:outline-none focus:ring-2 focus:ring-primary-700 focus:border-primary-700"
                        aria-label="Введіть назву міста"
                    >
                    @if(!empty($npCities) && $showCityDropdown)
                        <div class="mt-2 max-h-40 overflow-y-auto border border-gray-200 rounded-lg z-10 bg-white">
                            @foreach($npCities as $city)
                                <div
                                    wire:click="selectCity('{{ $city['MainDescription'] }}')"
                                    class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                                >
                                    {{ $city['MainDescription'] }}
                                </div>
                            @endforeach
                        </div>
                    @endif
                    @error('shipping.city') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="mt-4">
                    <label for="np-warehouse" class="block text-sm font-medium text-gray-700 mb-1">Відділення</label>
                    <select
                        id="np-warehouse"
                        wire:model.live="shipping.line_one"
                        class="block w-full rounded-2xl border border-gray-400 px-4 py-3.5 text-base font-semibold text-neutral-700 focus:outline-none focus:ring-2 focus:ring-primary-700 focus:border-primary-700"
                        aria-label="Виберіть відділення"
                        @if(empty($npWarehouses)) disabled @endif
                    >
                        <option value="">Оберіть відділення</option>
                        @foreach($npWarehouses as $warehouse)
                            <option value="{{ $warehouse['Description'] }}">{{ $warehouse['Description'] }}</option>
                        @endforeach
                    </select>
                    @if(empty($npWarehouses) && !empty($shipping->city))
                        <p class="mt-1 text-sm text-gray-500">Виберіть місто, щоб побачити доступні відділення.</p>
                    @endif
                    @error('shipping.line_one') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            @endif

            <!-- Кур'єр -->
            @if($chosenShipping === 'courier')
                <div class="mt-4">
                    <label for="courier-city" class="block text-sm font-medium text-gray-700 mb-1">Місто</label>
                    <input
                        type="text"
                        id="courier-city"
                        wire:model.live.debounce.500ms="citySearchTerm"
                        placeholder="Введіть назву міста"
                        class="block w-full rounded-2xl border border-gray-400 px-4 py-3.5 text-base font-semibold text-neutral-700 focus:outline-none focus:ring-2 focus:ring-primary-700 focus:border-primary-700"
                        aria-label="Введіть назву міста"
                    >
                    @if(!empty($npCities) && $showCityDropdown)
                        <div class="mt-2 max-h-40 overflow-y-auto border border-gray-200 rounded-lg z-10 bg-white">
                            @foreach($npCities as $city)
                                <div
                                    wire:click="selectCity('{{ $city['MainDescription'] }}')"
                                    class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                                >
                                    {{ $city['MainDescription'] }}
                                </div>
                            @endforeach
                        </div>
                    @endif
                    @error('shipping.city') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="mt-4">
                    <label for="courier-address" class="block text-sm font-medium text-gray-700 mb-1">Адреса доставки</label>
                    <input
                        type="text"
                        id="courier-address"
                        wire:model.lazy="shipping.line_one"
                        placeholder="Введіть адресу доставки"
                        class="block w-full rounded-2xl border border-gray-400 px-4 py-3.5 text-base font-semibold text-neutral-700 focus:outline-none focus:ring-2 focus:ring-primary-700 focus:border-primary-700"
                        aria-label="Введіть адресу доставки"
                    >
                    @error('shipping.line_one') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            @endif
        </div>

        <div class="mt-8 flex justify-between max-md:flex-col max-md:gap-4">
            <button
                type="button"
                wire:click="goBackStep"
                class="px-6 py-3 rounded-2xl border-2 border-green-700 text-green-700 hover:bg-green-50"
            >
                Назад
            </button>
            <button
                type="submit"
                wire:loading.attr="disabled"
                class="px-6 py-3 rounded-2xl bg-green-600 text-white hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed"
                @if(
                    !$chosenShipping ||
                    ($chosenShipping === 'nova-poshta' && (empty($shipping->city) || empty($shipping->line_one))) ||
                    ($chosenShipping === 'courier' && (empty($shipping->city) || empty($shipping->line_one)))
                ) disabled @endif
            >
                <span wire:loading.remove>Продовжити</span>
                <span wire:loading>Збереження...</span>
            </button>
        </div>
    </div>
</form>
