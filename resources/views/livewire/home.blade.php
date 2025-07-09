<div>
    <x-welcome-banner :settings="$settings" />
    <div class="container mx-auto px-2">
        <section class="flex flex-col self-stretch py-10" aria-label="Всі продукти">
            <div class="main-container">
                <h2 class="text-2xl font-bold leading-tight text-black max-md:max-w-full">{{ __('messages.products.title') }}</h2>
                <div class="flex flex-wrap gap-2 items-center mt-5 w-full min-h-[360px] max-md:max-w-full" role="list">
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
    <livewire:components.blog-section />
    <div class="container mx-auto px-2">
        <section class="flex relative flex-col w-full gap-0.5 items-start self-stretch pt-10 pb-0 max-md:pt-8 max-md:pb-0 max-sm:pt-5 max-sm:pb-0" aria-label="Company Advantages">
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
    <div class="container mx-auto px-2">
        <section class="flex overflow-hidden flex-col py-10 font-bold" aria-labelledby="advantages-title">
            <div class="main-container">
                <div class="flex flex-col items-center">
                    <h1 id="advantages-title" class="text-4xl leading-none text-center text-zinc-800 max-md:max-w-full">
                        {{ isset($settings->comparison_title[app()->getLocale()]) ? $settings->comparison_title[app()->getLocale()] : __('messages.advantages.title') }}
                    </h1>
                    @if (!empty($settings->main_comparison_image) && is_string($settings->main_comparison_image))
                       <div class="relative w-full min-h-60">
                        <img src="{{ Storage::url($settings->main_comparison_image) }}"
                             alt="{{ isset($settings->main_comparison_alt[app()->getLocale()]) ? $settings->main_comparison_alt[app()->getLocale()] : 'Comparison of peat briquettes' }}"
                             class="object-contain w-full mt-6 aspect-[4.13] rounded-[32px] max-md:max-w-full" />
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
                                    <div class="flex relative gap-2 items-end p-4 max-md:flex-col">
                                        <p class="text-4xl leading-none">{{ isset($item['value']) ? $item['value'] : '' }}</p>
                                        <p class="text-2xl leading-tight w-[189px]">{!! isset($item['unit']) ? $item['unit'] : '' !!}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-center w-full">{{ __('messages.comparison.no_items') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="container mx-auto px-2">
        <section class="flex flex-col py-10" aria-label="Frequently Asked Questions">
            <div class="main-container">
                <h1 class="text-2xl font-bold leading-tight text-zinc-800 max-md:max-w-full">
                    {{ __('messages.faq.title') }}
                </h1>
                <div class="flex flex-wrap gap-5 justify-center mt-5 w-full max-sm:max-w-full">
                    @if (!empty($settings->feedback_form_image))
                        <img src="{{ Storage::url($settings->feedback_form_image) }}" alt="{{ isset($settings->feedback_form_image_alt[app()->getLocale()]) ? $settings->feedback_form_image_alt[app()->getLocale()] : '' }}"
                             class="rounded-3xl max-w-xs" />
                    @else
                        <p>{{ __('messages.feedback_form.no_image') }}</p>
                    @endif
                    <div class="flex-1 shrink self-start basis-0 min-w-60 max-md:max-w-full">
                        @if (!empty($settings->faq_items[app()->getLocale()]))
                            @php $counter = 1; @endphp
                            @foreach ($settings->faq_items[app()->getLocale()] as $faq)
                                <article class="flex flex-wrap items-start px-4 py-2 w-full rounded-3xl bg-neutral-200 max-md:max-w-full mb-1">
                                    <div class="flex-1 shrink pt-4 pb-2 pl-4 basis-0 min-w-60 text-zinc-800 max-md:max-w-full">
                                        <h2 class="flex-1 shrink gap-2.5 self-stretch pb-2 w-full text-xl font-bold leading-6 basis-0 text-zinc-800 max-md:max-w-full cursor-pointer"
                                            data-toggle="faq-{{ $counter }}">
                                            {{ isset($faq['question']) ? $faq['question'] : '' }}
                                        </h2>
                                        <div class="flex w-full bg-zinc-300 min-h-px max-md:max-w-full"></div>
                                        <p class="faq-answer max-h-0 overflow-hidden transition-all duration-300 ease-in-out text-base font-semibold leading-none text-zinc-800 max-md:max-w-full"
                                           id="faq-{{ $counter }}">
                                            {{ isset($faq['answer']) ? $faq['answer'] : '' }}
                                        </p>
                                    </div>
                                    <button class="flex shrink-0 gap-2.5 w-14 h-14 items-center justify-center"
                                            aria-label="Toggle answer" aria-expanded="false" data-toggle="faq-{{ $counter }}">
                                        <svg class="w-6 h-6 text-zinc-800 toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                </article>
                                @php $counter++; @endphp
                            @endforeach
                        @else
                            <p>{{ __('messages.faq.no_items') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="container mx-auto px-2">
        <section class="flex flex-col justify-center self-stretch py-10 text-base" aria-label="Tenders section">
            <div class="main-container">
                <h1 class="text-2xl font-bold leading-tight text-zinc-800 max-md:max-w-full">
                    {{ isset($settings->tenders_title[app()->getLocale()]) ? $settings->tenders_title[app()->getLocale()] : __('messages.tenders.title') }}
                </h1>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2 mt-5 w-full font-semibold leading-6 text-white max-md:max-w-full">
                    @if (!empty($settings->tender_items[app()->getLocale()]))
                        @foreach ($settings->tender_items[app()->getLocale()] as $tender)
                            <article class="flex overflow-hidden relative p-4 rounded-3xl min-h-[210px]"
                                     style="background-color: {{ isset($tender['background_color']) ? $tender['background_color'] : '#228F5D' }}"
                                     aria-label="Tender for {{ isset($tender['title']) ? $tender['title'] : '' }}">
                                @if (!empty($tender['background_pattern']))
                                    <img src="{{ Storage::url($tender['background_pattern']) }}" alt="Background pattern"
                                         class="object-contain absolute bottom-0 right-1 z-0 aspect-[1.68]" />
                                @endif
                                <div class="z-0 flex-1 p-4">
                                    @if (!empty($tender['icon']))
                                        <img src="{{ Storage::url($tender['icon']) }}" alt="{{ isset($tender['title']) ? $tender['title'] . ' icon' : 'Tender icon' }}"
                                             class="object-contain w-10 aspect-square" />
                                    @endif
                                    <h2 class="mt-5 min-h-[88px] {{ isset($tender['background_color']) && str_contains($tender['background_color'], 'green') ? 'text-white' : 'text-green-600' }}">
                                        {{ isset($tender['title']) ? $tender['title'] : '' }}
                                    </h2>
                                </div>
                                <div class="flex z-0 shrink-0 gap-2.5 self-end w-14 h-14"></div>
                            </article>
                        @endforeach
                    @else
                        <p>{{ __('messages.tenders.no_items') }}</p>
                    @endif
                </div>
                <div class="flex flex-wrap gap-5 items-center mt-5 w-full max-md:max-w-full max-md:flex-col">
                    <div class="flex flex-1 shrink gap-4 items-center self-stretch my-auto font-semibold leading-none basis-12 min-h-6 justify-end text-zinc-800 max-md:max-w-full max-md:justify-center">
                        <i class="fas fa-phone w-6 h-6 text-zinc-800"></i>
                        <p class="text-zinc-800">{{ isset($settings->tenders_phone[app()->getLocale()]) ? $settings->tenders_phone[app()->getLocale()] : '' }}</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <section class="flex overflow-hidden flex-col bg-zinc-800" role="main" aria-labelledby="about-heading">
        <div class="container mx-auto px-2">
            <div class="main-container relative">
                <div class="flex justify-between relative py-10 w-full max-md:flex-col max-md:items-start max-md:gap-10">
                    <!-- Part 1: Main Content -->
                    <article class="flex flex-col flex-1 shrink items-start font-bold basis-0 min-w-[15rem] max-md:w-full">
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
    <livewire:components.reviews-section />
</div>
