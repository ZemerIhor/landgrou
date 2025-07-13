<div class="">
    <x-welcome-banner :settings="$settings" />
    <div class=" px-[50px] mx-auto pt-40">
        <section class="flex relative flex-col w-full gap-0.5 items-start self-stretch  pb-0 max-md:pt-8 max-md:pb-0 max-sm:pt-5 max-sm:pb-0" aria-label="Company Advantages">
                <div class="grid grid-cols-[repeat(auto-fit,minmax(160px,1fr))] max-md:grid-cols-2 max-sm:grid-cols-1 gap-1 w-full">
                    @if (!empty($settings->advantages_cards[app()->getLocale()]))
                        @foreach ($settings->advantages_cards[app()->getLocale()] as $index => $card)
                            <article class="flex flex-col gap-3 items-center p-6 rounded-3xl bg-zinc-800">
                                <div class="flex flex-col gap-2 w-full text-center text-white">
                                    <h2 class="text-base font-bold leading-5 max-sm:text-sm">{{ isset($card['title']) ? $card['title'] : '' }}</h2>
                                    <p class="text-xs font-semibold leading-5 max-sm:text-xs">{{ isset($card['description']) ? $card['description'] : '' }}</p>
                                </div>
                            </article>
                            @if ($index < 3 && !empty($settings->{'advantages_image_' . ($index + 1)}))
                                <figure class="rounded-3xl max-md:h-[200px] max-sm:h-[180px]">
                                    <img src="{{ Storage::url($settings->{'advantages_image_' . ($index + 1)}) }}" alt="Advantage image" class="object-cover w-full h-full rounded-3xl" />
                                </figure>
                            @endif
                        @endforeach
                    @else
                        <p>{{ __('messages.advantages.no_cards') }}</p>
                    @endif
                </div>
        </section>
    </div>
    <div class=" px-[16px] sm:px-[28px] md:px-[50px]  py-[80px] products  mx-auto ">
        <section class="flex flex-col self-stretch" aria-label="Каталог">
            <div class="main-container">
                <h2 class="text-2xl pb-5 font-bold leading-tight text-black max-md:max-w-full">{{ __('messages.products.title') }}</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4  overflow-hidden gap-2 lg:h-[378px] sm:h-auto" role="list">
                    @if (!empty($allProducts))
                        @foreach ($allProducts as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    @else
                        <p>{{ __('messages.products.no_items') }}</p>
                    @endif
                </div>
            </div>
        </section>
    </div>




    <div class=" px-[16px] sm:px-[28px] md:px-[50px] py-[80px] mx-auto">
        <section class="flex overflow-hidden flex-col font-bold" aria-labelledby="advantages-title">
                <div class="flex flex-col items-center">
                    <h1 id="advantages-title" class="text-4xl leading-none text-center text-zinc-800 max-md:max-w-full">
                        {{ isset($settings->comparison_title[app()->getLocale()]) ? $settings->comparison_title[app()->getLocale()] : __('messages.advantages.title') }}
                    </h1>
                    @if (!empty($settings->main_comparison_image) && is_string($settings->main_comparison_image))
                       <div class="relative w-full">
                        <img src="{{ Storage::url($settings->main_comparison_image) }}"
                             alt="{{ isset($settings->main_comparison_alt[app()->getLocale()]) ? $settings->main_comparison_alt[app()->getLocale()] : 'Comparison of peat briquettes' }}"
                             class="object-fill w-full min-h-60 mt-6 aspect-[4.13] rounded-[32px] max-md:max-w-full" />
                        <span class="w-full flex absolute top-0 z-10 flex-col justify-center items-center self-center px-4 py-12 leading-none text-center whitespace-nowrap max-md:top-10"
                              aria-label="Quantity of peat briquettes for comparison">
                    <span class="text-8xl tracking-tighter text-white max-md:text-4xl">{{ isset($settings->central_text_value[app()->getLocale()]) ? $settings->central_text_value[app()->getLocale()] : '1t' }}</span>
                    <span class="text-4xl text-white">{{ isset($settings->central_text_unit[app()->getLocale()]) ? $settings->central_text_unit[app()->getLocale()] : 'briquettes' }}</span>
                </span>
                       </div>
                    @endif
                </div>
                <!-- Part 2: Comparison Items and Central Text -->
                <div class="flex relative flex-col self-center mt-2 w-full text-white max-md:max-w-full">
                    <div class="flex z-0 gap-2 justify-between items-center w-full min-h-60 max-md:gap-6">
                        @if (!empty($settings->comparison_items[app()->getLocale()]))
                            @foreach ($settings->comparison_items[app()->getLocale()] as $item)
                                <div class="flex relative flex-col grow items-start self-stretch overflow-hidden
 my-auto min-h-60 rounded-[32px] max-md:w-full">
                                    @if (!empty($item['image']) && is_string($item['image']))
                                        <img src="{{ Storage::url($item['image']) }}"
                                             alt="{{ isset($item['alt']) ? $item['alt'] : '' }}"
                                             class="object-cover absolute inset-0 size-full" />
                                    @endif
                                    <div class="flex relative gap-2 items-end p-4 max-md:flex-col items-center w-full mt-auto">
                                        <p class="text-4xl leading-none">{{ isset($item['value']) ? $item['value'] : '' }}</p>
                                        <p class="text-2xl leading-tight">{!! isset($item['unit']) ? $item['unit'] : '' !!}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-center w-full">{{ __('messages.comparison.no_items') }}</p>
                        @endif
                    </div>
                </div>
        </section>
    </div>



 <livewire:components.reviews-section />

     <section class="flex overflow-hidden flex-col bg-zinc-800 px-[50px] py-[80px]" role="main" aria-labelledby="about-heading">
        <div class=" mx-auto">
            <div class="main-container relative">
                <div class="flex justify-between h-full relative w-full max-md:flex-col max-md:items-start max-md:gap-10">
                    <!-- Part 1: Main Content -->
                    <article class="flex flex-col justify-between flex-1 shrink items-start font-bold basis-0 min-w-[15rem] max-md:w-full">
                        <header class="w-full max-md:w-full max-md:max-w-none">
                            <h1 id="about-heading" class="text-4xl leading-none text-white max-md:text-3xl max-md:w-full">
                                {{ isset($settings->about_title[app()->getLocale()]) ? $settings->about_title[app()->getLocale()] : __('messages.about.title') }}
                            </h1>
                            <p class="mt-5 text-xl leading-6 text-white max-md:text-base max-md:w-full">{!! isset($settings->about_description[app()->getLocale()]) ? $settings->about_description[app()->getLocale()] : '' !!}</p>
                        </header>
                        <nav class="flex gap-4 items-center mt-40 text-base leading-snug whitespace-nowrap max-md:mt-10 max-md:flex-wrap max-md:justify-start">
                            @if (!empty($settings->about_more_link[app()->getLocale()]))
                                <a href="{{ $settings->about_more_link[app()->getLocale()] }}"
                                   class="flex gap-2 justify-center items-center self-stretch px-6 py-2.5 my-auto text-green-600 rounded-2xl border-2 border-solid border-[color:var(--Primaries-700,#228F5D)] min-h-11 hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-zinc-800"
                                   type="button" aria-label="{{ __('messages.about.more_button_aria_label') }}">
                                    <span class="self-stretch my-auto text-green-600">{{ __('messages.about.more_button') }}</span>
                                </a>
                            @endif
                            @if (!empty($settings->about_certificates_link[app()->getLocale()]))
                                <a href="{{ $settings->about_certificates_link[app()->getLocale()] }}"
                                   class="gap-2 self-stretch px-6 py-2.5 my-auto text-white bg-green-600 rounded-2xl min-h-11 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-zinc-800"
                                   type="button" aria-label="{{ __('messages.about.certificates_button_aria_label') }}">
                                    {{ __('messages.about.certificates_button') }}
                                </a>
                            @endif
                        </nav>
                    </article>
                    <!-- Part 2: Statistics and Image -->
                    <aside class="flex gap-2 items-end self-start min-w-[15rem] max-md:w-full max-md:flex-col max-md:gap-6"
                           aria-label="Company statistics and information">
                        <article class="min-w-[15rem] max-w-sm max-md:max-w-sm">
                            <header>
                                <h2 class="text-4xl font-bold leading-none text-green-600 max-md:text-3xl">
                                    {{ isset($settings->about_statistic_title[app()->getLocale()]) ? $settings->about_statistic_title[app()->getLocale()] : '' }}
                                </h2>
                            </header>
                            <div class="mt-3 text-xs font-semibold leading-5 text-white max-md:text-sm">
                                {!! isset($settings->about_statistic_description[app()->getLocale()]) ? $settings->about_statistic_description[app()->getLocale()] : '' !!}
                            </div>
                        </article>
                        @if (!empty($settings->about_location_image))
                            <figure
                                class="overflow-hidden text-xs font-semibold text-right text-white rounded-3xl shadow-[var(--sds-size-depth-0)_var(--sds-size-depth-400)_var(--sds-size-depth-800)_var(--sds-size-depth-negative-200)_var(--sds-color-black-400)] max-md:w-full max-md:rounded-lg"
                                style="min-width: 15rem;">
                                <div
                                    class="flex relative flex-col px-7 pb-4 w-full aspect-[0.57] pt-[473px] max-md:pt-24 max-md:pl-5">
                                    <img src="{{ Storage::url($settings->about_location_image) }}"
                                         alt="{{ isset($settings->about_location_caption[app()->getLocale()]) ? $settings->about_location_caption[app()->getLocale()] : '' }}"
                                         class="object-cover absolute inset-0 w-full h-full" />
                                    <figcaption class="relative z-10">{{ isset($settings->about_location_caption[app()->getLocale()]) ? $settings->about_location_caption[app()->getLocale()] : '' }}</figcaption>
                                </div>
                            </figure>
                        @else
                            <p>{{ __('messages.about.no_image') }}</p>
                        @endif
                    </aside>
                </div>
            </div>
        </div>
    </section>


    <section class="flex flex-col px-12 py-20 bg-zinc-100 max-md:px-5" role="main" aria-labelledby="faq-title">
        <header>
            <h1 id="faq-title" class="text-2xl font-bold leading-tight text-zinc-800 max-md:max-w-full">
                {{ is_string($settings->faq_title[app()->getLocale()] ?? null) ? $settings->faq_title[app()->getLocale()] : __('messages.faq.title') }}
            </h1>
        </header>

        <div class="flex flex-wrap gap-5 justify-center mt-5 w-full max-md:max-w-full">
            @if (!empty($settings->faq_main_image))
                <img
                    src="{{ Storage::url($settings->faq_main_image) }}"
                    alt="{{ is_string($settings->faq_main_image_alt) ? $settings->faq_main_image_alt : '' }}"
                    class="rounded-3xl aspect-[0.71] min-w-60"
                />
            @else
                <p>{{ __('messages.faq.no_image') }}</p>
            @endif

            <div class="flex-1 shrink self-start basis-0 min-w-60 max-md:max-w-full">
                @foreach ($settings->faq_items[app()->getLocale()] ?? [] as $index => $item)
                    <article class="flex flex-wrap items-start px-4 py-2 mt-1 w-full rounded-3xl bg-neutral-200 max-md:max-w-full">
                        <div class="flex gap-2.5 items-start self-stretch py-2 h-full w-[70px]">
                            @if (!empty($item['icon']))
                                <img
                                    src="{{ Storage::url($item['icon']) }}"
                                    alt="{{ __('messages.faq.icon_alt', ['question' => $item['question']]) }}"
                                    class="object-contain rounded-xl faq-thumbnail"
                                />
                            @else
                                <p>{{ __('messages.faq.no_icon') }}</p>
                            @endif
                        </div>
                        <div class="flex-1 shrink pt-4 pb-2 pl-4 basis-0 min-w-60 text-zinc-800 max-md:max-w-full">
                            <button
                                class="faq-toggle flex gap-2.5 justify-center items-center pb-2 w-full text-xl font-bold leading-6 max-md:max-w-full text-left"
                                aria-expanded="false"
                                data-toggle="answer-{{ $index }}"
                            >
                                <h2 class="flex-1 shrink self-stretch my-auto basis-0 text-zinc-800 max-md:max-w-full">
                                    {{ $item['question'] }}
                                </h2>
                                <div class="flex shrink-0 gap-2.5 w-14 h-14 items-center justify-center">
                                    <svg class="arrow-open w-6 h-6 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                    <svg class="arrow-close w-6 h-6 text-zinc-600 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                    </svg>
                                </div>
                            </button>
                            <div class="flex w-full bg-zinc-300 min-h-px max-md:max-w-full" role="separator"></div>
                            <div
                                id="answer-{{ $index }}"
                                class="faq-answer"
                                style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease;"
                            >
                                <div class="flex gap-2.5 items-center py-2 w-full text-base font-semibold leading-none rounded-2xl max-md:max-w-full">
                                    <p class="flex-1 shrink self-stretch my-auto basis-0 text-zinc-800 max-md:max-w-full">
                                        {{ $item['answer'] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>

        <footer class="flex justify-end mt-5">
            <button
                class="flex gap-2 justify-center items-center self-end px-6 py-2.5 text-base font-bold leading-snug text-green-600 whitespace-nowrap rounded-2xl border-2 border-green-600 border-solid min-h-11 max-md:px-5 hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 transition-colors"
                aria-label="{{ __('messages.faq.show_more') }}"
            >
                <span class="self-stretch my-auto text-green-600">{{ __('messages.faq.show_more') }}</span>
                <img
                    src="{{ asset('images/more-icon.png') }}"
                    alt=""
                    class="object-contain shrink-0 self-stretch my-auto w-6 aspect-square"
                    role="presentation"
                />
            </button>
        </footer>
    </section>
    <section
        class="flex flex-col justify-center self-stretch px-12 py-20 text-base bg-zinc-100 max-md:px-5"
        aria-labelledby="tenders-heading"
    >
        <h2
            id="tenders-heading"
            class="text-2xl font-bold leading-tight text-zinc-800 max-md:max-w-full"
        >
            {{ $settings->tenders_title[app()->getLocale()] ?? 'Тендери' }}
        </h2>

        <div
            class="flex flex-wrap gap-2 mt-5 w-full font-semibold leading-6 text-white max-md:max-w-full"
            role="list"
            aria-label="Список тендерів"
        >
            @foreach ($settings->tender_items[app()->getLocale()] ?? [] as $item)
                <article
                    class="flex overflow-hidden relative grow shrink self-start p-4 rounded-3xl min-h-[210px] min-w-60 w-[310px]"
                    role="listitem"
                    style="background-color: {{ $item['background_color'] ?? '#34C759' }};"
                >
                    <svg
                        width="384" height="211" viewBox="0 0 384 211" fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        class="object-contain absolute bottom-0 right-1 z-0 self-start aspect-[1.68] h-[485px] min-w-60 w-[352px]"
                    >
                        <g filter="url(#filter0_dd_2231_3718)">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M229.774 160.816C229.774 181.037 221.906 199.476 209.155 213.886C192.075 233.409 171.537 244.505 144.28 244.505C95.499 244.505 67.0722 205.226 59.0003 164.668C53.5022 139.103 57.2456 133.989 56.0758 119.114C55.7248 116.326 55.7248 115.163 53.5022 114.466C53.1512 114.466 53.1512 114.234 53.1512 114.35C53.1512 114.466 52.8003 114.35 52.8003 114.35C51.7474 114.35 52.8003 114.001 51.7474 114.466C48.4719 115.861 43.6756 127.482 42.6228 130.154C34.2001 153.28 29.1698 175.128 28 196.161V213.244C30.2227 247.061 42.2719 279.25 65.9022 311.443L77.9515 325.968C82.7478 331.197 88.1289 335.38 91.7555 338.866C95.499 342.584 99.4762 345.491 103.453 348.513C127.903 366.641 167.209 382.678 198.209 382.678H210.96C241.844 382.678 270.271 370.359 292.848 356.182C295.071 354.903 297.294 353.627 299.399 352C301.622 350.488 303.845 349.093 305.599 347.466C310.747 343.4 318.701 337.123 323.147 332.593L334.026 321.318C335.898 319.111 336.951 317.484 338.822 315.393C365.377 282.504 380 242.413 380 198.369C380 178.265 373.449 150.142 365.026 132.362C357.773 117.139 352.275 108.075 341.747 94.8267L339.797 92.0343C313.888 66.1796 293.199 49.8535 288.169 46.0188C285.244 44.043 283.373 42.5325 280.448 40.3243L272.844 33.9329C270.271 31.7251 268.516 30.0978 265.591 27.89L244.768 7.78574C232.836 -3.95126 228.742 -8.94852 220.787 -22.545C210.609 -39.2793 209.089 -56.3618 209.089 -76.5824C209.089 -87.8547 215.289 -109.702 205.462 -99.8243C199.964 -94.3625 188.032 -72.6313 184.288 -65.1938C178.907 -54.735 180.311 -59.2673 177.737 -49.0408C176.685 -45.9031 175.983 -43.4626 175.632 -40.4412L173.058 -20.3369C172.707 -16.5022 172.707 -13.0158 172.356 -9.6458L173.76 11.0395C178.556 49.7375 204 90.7932 220.436 121.671C220.305 121.343 229.774 142.245 229.774 160.816Z"
                                  fill="{{ $item['background_color'] ?? '#34C759' }}"/>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M106.724 28.7047C106.724 48.5767 110.351 63.2191 116.551 77.8616C123.804 96.3387 133.28 107.379 147.902 119.116C151.178 121.556 152.582 123.299 155.506 126.089C157.027 127.599 157.729 127.832 159.25 129.226C180.657 148.633 197.386 178.266 179.604 205.924C173.404 215.57 165.801 219.87 164.631 223.705C165.801 225.331 166.152 225.564 168.257 225.099C169.778 224.634 172.352 223.588 173.404 223.007C185.103 217.894 189.08 215.802 198.556 206.273C204.405 199.882 211.307 187.796 213.412 179.545C220.431 152.933 208.733 121.789 193.058 100.871C186.857 92.9686 177.382 79.3721 174.457 69.9592C170.129 56.595 178.903 59.0355 158.431 53.9223C141 49.5063 129.653 41.2553 119.827 26.6129C112.223 15.5732 111.521 6.74124 109.298 4.06847C107.777 10.6922 106.724 20.5701 106.724 28.7047Z"
                                  fill="{{ $item['background_color'] ?? '#34C759' }}"/>
                        </g>
                        <defs>
                            <filter id="filter0_dd_2231_3718" x="0" y="-130.322" width="408" height="541" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                <feMorphology radius="4" operator="erode" in="SourceAlpha" result="effect1_dropShadow_2231_3718"/>
                                <feOffset/>
                                <feGaussianBlur stdDeviation="2"/>
                                <feComposite in2="hardAlpha" operator="out"/>
                                <feColorMatrix type="matrix" values="0 0 0 0 0.0470588 0 0 0 0 0.0470588 0 0 0 0 0.0509804 0 0 0 0.05 0"/>
                                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2231_3718"/>
                                <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                <feMorphology radius="4" operator="erode" in="SourceAlpha" result="effect2_dropShadow_2231_3718"/>
                                <feOffset/>
                                <feGaussianBlur stdDeviation="16"/>
                                <feComposite in2="hardAlpha" operator="out"/>
                                <feColorMatrix type="matrix" values="0 0 0 0 0.0470588 0 0 0 0 0.0470588 0 0 0 0 0.0509804 0 0 0 0.15 0"/>
                                <feBlend mode="normal" in2="effect1_dropShadow_2231_3718" result="effect2_dropShadow_2231_3718"/>
                                <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_2231_3718" result="shape"/>
                            </filter>
                        </defs>
                    </svg>
                    <div class="z-0 flex-1 shrink p-4 basis-0 min-w-60">
                        @if (!empty($item['icon']))
                            <img
                                src="{{ Storage::url($item['icon']) }}"
                                alt="Іконка категорії {{ $item['title'] }}"
                                class="object-contain w-10 aspect-square"
                                onerror="this.style.display='none'"
                            />
                        @endif
                        <div class="flex items-end mt-5 w-full min-h-[88px]">
                            <h3 class="flex-1 shrink basis-0 {{ str_starts_with($item['background_color'] ?? '#34C759', '#') && in_array(strtolower(substr($item['background_color'], 1)), ['34c759', '4ade80']) ? 'text-white' : 'text-green-600' }}">
                                {{ $item['title'] }}
                            </h3>
                        </div>
                    </div>
                    <div
                        class="flex z-0 shrink-0 gap-2.5 self-end w-14 h-14"
                        aria-label="Кнопки навігації"
                    ></div>
                </article>
            @endforeach
        </div>

        <footer class="flex flex-wrap gap-5 items-center mt-5 w-full max-md:max-w-full">
            <address
                class="flex flex-wrap flex-1 shrink gap-4 items-start self-stretch my-auto font-semibold leading-none basis-12 min-h-6 min-w-60 text-zinc-800 max-md:max-w-full not-italic"
            >
                <img
                    src="https://cdn.builder.io/api/v1/image/assets/bdb2240bae064d82b869b3fcebf2733a/e5a7947040ad43f0eb4757a8de8cd3a74f5f891f?placeholderIfAbsent=true"
                    alt="Іконка телефону"
                    class="object-contain shrink-0 w-6 aspect-square"
                />
                <div class="text-zinc-800">
                    {{ $settings->tenders_phone[app()->getLocale()] ?? 'Відділ тендерів +38 099 900-14-30' }}
                </div>
            </address>

            <button
                class="flex gap-2 justify-center items-center self-stretch px-6 py-2.5 my-auto font-bold leading-snug text-green-600 whitespace-nowrap rounded-2xl border-2 border-green-600 border-solid min-h-11 max-md:px-5 hover:bg-green-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 transition-colors duration-200"
                type="button"
                aria-label="Переглянути більше тендерів"
            >
            <span class="self-stretch my-auto text-current">
                Більше
            </span>
                <img
                    src="https://cdn.builder.io/api/v1/image/assets/bdb2240bae064d82b869b3fcebf2733a/5fcdfc213ad7c52f7cde2c5630712bbd498037c1?placeholderIfAbsent=true"
                    alt=""
                    class="object-contain shrink-0 self-stretch my-auto w-6 aspect-square"
                    aria-hidden="true"
                />
            </button>
        </footer>
    </section>

      <livewire:components.blog-section />
      <div class="px-[16px] sm:px-[28px] md:px-[50px] py-[80px]  "> <livewire:components.feedback-form-block /></div>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.faq-toggle');

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.dataset.toggle;
            const answer = document.getElementById(targetId);
            const openIcon = button.querySelector('.arrow-open');
            const closeIcon = button.querySelector('.arrow-close');

            const isVisible = answer.style.maxHeight && answer.style.maxHeight !== '0px';

            if (isVisible) {
                // Закриваємо
                answer.style.maxHeight = null;
                button.setAttribute('aria-expanded', 'false');
                openIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
            } else {
                // Відкриваємо
                answer.style.maxHeight = answer.scrollHeight + 'px';
                button.setAttribute('aria-expanded', 'true');
                openIcon.classList.add('hidden');
                closeIcon.classList.remove('hidden');
            }
        });
    });
});
</script>

