<main class="self-stretch pt-14 bg-zinc-100">
    <!-- Breadcrumbs Navigation -->
    <nav class="flex flex-wrap gap-2 items-center px-12 w-full text-xs font-semibold min-h-[34px] text-neutral-400 max-md:px-5 max-md:max-w-full" aria-label="Breadcrumb">
        <ol class="flex flex-wrap gap-2 items-center">
            <li class="gap-2 self-stretch py-2 my-auto whitespace-nowrap text-neutral-400">
                <a href="/" class="text-neutral-400 hover:text-neutral-600">Головна</a>
            </li>
            <li class="flex gap-2 items-center self-stretch py-2 my-auto whitespace-nowrap">
                <span class="self-stretch my-auto w-1.5 text-neutral-400" aria-hidden="true">/</span>
                <a href="/catalog" class="self-stretch my-auto text-neutral-400 hover:text-neutral-600">Каталог</a>
            </li>
            <li class="flex gap-2 items-center self-stretch py-2 my-auto min-w-60 text-zinc-800" aria-current="page">
                <span class="self-stretch my-auto w-1.5 whitespace-nowrap text-zinc-800" aria-hidden="true">/</span>
                <span class="self-stretch my-auto text-zinc-800">{{ $this->product->translateAttribute('name') }}</span>
            </li>
        </ol>
    </nav>

    <!-- Product Details Section -->
    <section class="px-12 w-full max-md:px-5 max-md:max-w-full">
        <div class="w-full max-md:max-w-full">
            <div class="max-w-full w-[1179px]">
                <header>
                    <h1 class="text-2xl font-bold leading-tight text-zinc-800 max-md:max-w-full">
                        {{ $this->product->translateAttribute('name') }}
                    </h1>
                    <p class="mt-1 text-xs font-semibold text-neutral-400 max-md:max-w-full">
                        ID/Код/Артикул: {{ $this->variant->sku }}
                    </p>
                </header>

                <div class="flex flex-wrap gap-10 mt-4 w-full max-md:max-w-full">
                    <!-- Product Image -->
                    <div class="flex-shrink-0">
                        @if ($this->image)
                            <img
                                src="{{ $this->image->getUrl('large') }}"
                                alt="{{ $this->product->translateAttribute('name') }}"
                                class="object-contain aspect-[1.15] min-w-60 w-[487px] max-md:max-w-full"
                            />
                        @endif
                    </div>

                    <!-- Product Information -->
                    <div class="flex-1 shrink self-start basis-0 min-w-60 max-md:max-w-full">
                        <p class="text-base font-semibold leading-6 text-zinc-800 max-md:max-w-full">
                            {{ $this->product->translateAttribute('description') }}
                        </p>

                        <div class="mt-6 w-full text-base font-semibold max-md:max-w-full">
                            <table class="w-full" role="table" aria-label="Характеристики продукту">
                                <tbody>
                                @foreach ($displayAttributes as $key)
                                    <tr class="flex flex-wrap items-center w-full leading-none {{ $loop->even ? 'bg-white' : '' }} rounded-lg max-md:max-w-full">
                                        <td class="flex-1 shrink gap-2.5 self-stretch px-4 py-2 my-auto whitespace-nowrap basis-0 min-w-60 text-zinc-600">
                                            {{ $productAttributes[$key][app()->getLocale()] }}
                                        </td>
                                        <td class="flex-1 shrink gap-2.5 self-stretch px-4 py-2 my-auto text-right basis-0 min-w-60 text-zinc-800">
                                            {{ $this->product->translateAttribute($key) ?? 'N/A' }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Price and Purchase Controls -->
                        <div class="flex flex-wrap justify-between items-center mt-6 w-full min-h-11 max-md:max-w-full">
                            <div class="flex flex-1 shrink gap-1 items-center self-stretch my-auto text-2xl font-bold leading-tight basis-0 text-zinc-800">
                                <x-product-price :variant="$this->variant" />
                            </div>

                            <div class="flex gap-4 items-center self-stretch my-auto min-w-60 max-md:max-w-full">
                                <!-- Quantity Selector -->
                                <div class="flex gap-2 items-center self-stretch px-2 my-auto rounded-2xl bg-neutral-200 min-h-11" role="group" aria-label="Вибір кількості">
                                    <button wire:click="decrementQuantity" class="flex gap-2.5 items-center self-stretch my-auto w-6" aria-label="Зменшити кількість">
                                        <img src="https://cdn.builder.io/api/v1/image/assets/bdb2240bae064d82b869b3fcebf2733a/17ca60463c688ad8dd77a79bb0d30a11b61853c3?placeholderIfAbsent=true" alt="" class="object-contain self-stretch my-auto w-6 aspect-square" aria-hidden="true" />
                                    </button>
                                    <input type="number" wire:model="quantity" min="1" class="gap-2.5 self-stretch my-auto text-base font-semibold leading-none whitespace-nowrap text-zinc-800 bg-transparent border-none text-center w-12" aria-label="Кількість товару" />
                                    <button wire:click="incrementQuantity" class="flex gap-2.5 items-center self-stretch my-auto w-6" aria-label="Збільшити кількість">
                                        <img src="https://cdn.builder.io/api/v1/image/assets/bdb2240bae064d82b869b3fcebf2733a/47179ee2decd9a3a1f753e0bc94df952912300dd?placeholderIfAbsent=true" alt="" class="object-contain self-stretch my-auto w-6 aspect-square" aria-hidden="true" />
                                    </button>
                                </div>

                                <!-- Purchase Buttons -->
                                <button wire:click="buyNow" class="gap-2 self-stretch px-5 my-auto text-base font-bold leading-snug text-green-600 rounded-2xl border-2 border-solid border-[color:var(--Primaries-700,#228F5D)] min-h-11 hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2">
                                    Купити в 1 клік
                                </button>
                                <livewire:components.add-to-cart :purchasable="$this->variant" :quantity="$this->quantity" :wire:key="$this->variant->id" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Description -->
                <section class="mt-14 w-full text-black max-md:mt-10 max-md:max-w-full">
                    <h2 class="text-xl font-bold leading-tight max-md:max-w-full">
                        Опис:
                    </h2>
                    <p class="mt-4 text-base font-semibold leading-6 max-md:max-w-full">
                        {{ $this->product->translateAttribute('description') }}
                    </p>
                </section>

                <!-- Detailed Characteristics (Hardcoded for demonstration) -->
                <section class="mt-14 w-full max-md:mt-10 max-md:max-w-full">
                    <h2 class="text-xl font-bold leading-tight text-black max-md:max-w-full">
                        Характеристики:
                    </h2>
                    <div class="mt-4 w-full text-base font-semibold leading-none text-zinc-800 max-md:max-w-full">
                        <table class="w-full" role="table" aria-label="Детальні характеристики продукту">
                            <thead>
                            <tr class="flex flex-wrap items-center w-full text-white rounded-lg bg-zinc-600 max-md:max-w-full">
                                <th class="flex-1 shrink gap-2.5 self-stretch px-4 py-2 my-auto text-white basis-0 min-w-60 text-left">
                                    Найменування показників
                                </th>
                                <th class="flex-1 shrink gap-2.5 self-stretch px-4 py-2 my-auto text-right text-white basis-0 min-w-60">
                                    Норма згідно з ДСТУ 2042-92
                                </th>
                                <th class="flex-1 shrink gap-2.5 self-stretch px-4 py-2 my-auto text-right text-white basis-0 min-w-60">
                                    Отримані показники
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="flex flex-wrap items-center w-full rounded-lg max-md:max-w-full">
                                <td class="flex-1 shrink gap-2.5 self-stretch px-4 py-2 my-auto basis-0 min-w-60 text-zinc-600">Масова доля загальної вологи (Wp)</td>
                                <td class="flex-1 shrink gap-2.5 self-stretch px-4 py-2 my-auto text-right whitespace-nowrap basis-0 min-w-60 text-zinc-800">20%</td>
                                <td class="flex-1 shrink gap-2.5 self-stretch px-4 py-2 my-auto text-right whitespace-nowrap basis-0 min-w-60 text-zinc-800">19.1%</td>
                            </tr>
                            <tr class="flex flex-wrap items-center w-full bg-white rounded-lg max-md:max-w-full">
                                <td class="flex-1 shrink gap-2.5 self-stretch px-4 py-2 my-auto basis-0 min-w-60 text-zinc-600">Зольність (Ad)</td>
                                <td class="flex-1 shrink gap-2.5 self-stretch px-4 py-2 my-auto text-right whitespace-nowrap basis-0 min-w-60 text-zinc-800">23%</td>
                                <td class="flex-1 shrink gap-2.5 self-stretch px-4 py-2 my-auto text-right whitespace-nowrap basis-0 min-w-60 text-zinc-800">18.3%</td>
                            </tr>
                            <tr class="flex flex-wrap items-center w-full rounded-lg max-md:max-w-full">
                                <td class="flex-1 shrink gap-2.5 self-stretch px-4 py-2 my-auto basis-0 min-w-60 text-zinc-600">Механічна міцність, %</td>
                                <td class="flex-1 shrink gap-2.5 self-stretch px-4 py-2 my-auto text-right whitespace-nowrap basis-0 min-w-60 text-zinc-800">96.6%</td>
                                <td class="flex-1 shrink gap-2.5 self-stretch px-4 py-2 my-auto text-right whitespace-nowrap basis-0 min-w-60 text-zinc-800">96.6%</td>
                            </tr>
                            <tr class="flex flex-wrap items-center w-full bg-white rounded-lg max-md:max-w-full">
                                <td class="flex-1 shrink gap-2.5 self-stretch px-4 py-2 my-auto basis-0 min-w-60 text-zinc-600">Теплота згорання Ккал/кг</td>
                                <td class="flex-1 shrink gap-2.5 self-stretch px-4 py-2 my-auto text-right whitespace-nowrap basis-0 min-w-60 text-zinc-800">>3500</td>
                                <td class="flex-1 shrink gap-2.5 self-stretch px-4 py-2 my-auto text-right whitespace-nowrap basis-0 min-w-60 text-zinc-800">4155</td>
                            </tr>
                            <tr class="flex flex-wrap items-center w-full rounded-lg max-md:max-w-full">
                                <td class="flex-1 shrink gap-2.5 self-stretch px-4 py-2 my-auto basis-0 min-w-60 text-zinc-600">Теплота згорання МДж/кг</td>
                                <td class="flex-1 shrink gap-2.5 self-stretch px-4 py-2 my-auto text-right whitespace-nowrap basis-0 min-w-60 text-zinc-800">>14.65</td>
                                <td class="flex-1 shrink gap-2.5 self-stretch px-4 py-2 my-auto text-right whitespace-nowrap basis-0 min-w-60 text-zinc-800">17.387</td>
                            </tr>
                            <tr class="flex flex-wrap items-center w-full bg-white rounded-lg max-md:max-w-full">
                                <td class="flex-1 shrink gap-2.5 self-stretch px-4 py-2 my-auto basis-0 min-w-60 text-zinc-600">Вміст сірки, %</td>
                                <td class="flex-1 shrink gap-2.5 self-stretch px-4 py-2 my-auto text-right whitespace-nowrap basis-0 min-w-60 text-zinc-800">-</td>
                                <td class="flex-1 shrink gap-2.5 self-stretch px-4 py-2 my-auto text-right whitespace-nowrap basis-0 min-w-60 text-zinc-800">0.24%</td>
                            </tr>
                            <tr class="flex flex-wrap items-center w-full rounded-lg max-md:max-w-full">
                                <td class="flex-1 shrink gap-2.5 self-stretch px-4 py-2 my-auto basis-0 min-w-60 text-zinc-600">Забруднення радіонуклідами</td>
                                <td class="flex-1 shrink gap-2.5 self-stretch px-4 py-2 my-auto text-right basis-0 min-w-60 text-zinc-800">не нормується</td>
                                <td class="flex-1 shrink gap-2.5 self-stretch px-4 py-2 my-auto text-right basis-0 min-w-60 text-zinc-800">не виявлено</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
    </section>

    <!-- Similar Products Section -->
    <section class="flex flex-col px-12 py-20 w-full bg-zinc-100 max-md:px-5 max-md:max-w-full">
        <h2 class="text-2xl font-bold leading-tight text-black max-md:max-w-full">
            Схожі товари
        </h2>

        <div class="flex flex-wrap gap-2 items-center mt-5 w-full min-h-[360px] max-md:max-w-full" role="region" aria-label="Схожі товари">
            @foreach ($this->similarProducts as $similarProduct)
                <article class="overflow-hidden flex-1 shrink self-stretch my-auto rounded-3xl basis-0 bg-neutral-200 min-w-60">
                    <div class="flex relative flex-col w-full min-h-[153px]">
                        @if ($similarProduct->images->first())
                            <img
                                src="{{ $similarProduct->images->first()->getUrl('small') }}"
                                alt="{{ $similarProduct->translateAttribute('name') }}"
                                class="object-contain w-full aspect-[1.77]"
                            />
                        @endif
                    </div>
                    <div class="p-4 w-full">
                        <div class="w-full text-zinc-800">
                            <h3 class="text-base font-bold leading-5 text-zinc-800">
                                {{ $similarProduct->translateAttribute('name') }}
                            </h3>
                            <p class="mt-3 text-xs font-semibold leading-5 text-zinc-800">
                                {{ $similarProduct->translateAttribute('description') }}
                            </p>
                        </div>
                        <div class="flex gap-10 justify-between items-end mt-2 w-full text-base font-bold">
                            <x-product-price :variant="$similarProduct->variants->first()" />
                            <livewire:components.add-to-cart :purchasable="$similarProduct->variants->first()" :wire:key="$similarProduct->id" />
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <button class="flex gap-2 justify-center items-center self-center px-6 py-2.5 mt-5 text-base font-bold leading-snug text-green-600 whitespace-nowrap rounded-2xl border-2 border-solid border-[color:var(--Primaries-700,#228F5D)] min-h-11 max-md:px-5 hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2">
            <span class="self-stretch my-auto text-green-600">Більше</span>
            <img src="https://cdn.builder.io/api/v1/image/assets/bdb2240bae064d82b869b3fcebf2733a/adfd6f8e64442318efc1c8531674886bcc6b3a15?placeholderIfAbsent=true" alt="" class="object-contain shrink-0 self-stretch my-auto w-6 aspect-square" aria-hidden="true" />
        </button>
    </section>
</main>
