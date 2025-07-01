<div>
    <x-welcome-banner :settings="$settings" />


    <div class="container mx-auto px-2">
        <section class="flex flex-col self-stretch py-10" aria-label="Всі продукти">
            <div class="main-container">
                <h2 class="text-2xl font-bold leading-tight text-black max-md:max-w-full">{{ __('messages.products.title') }}</h2>
                <div class="flex flex-wrap gap-2 items-center mt-5 w-full min-h-[360px] max-md:max-w-full" role="list">
                    @if (!empty($allProducts) && is_array($allProducts))
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

    <div class="container mx-auto px-2">
        <section class="flex relative flex-col gap-0.5 items-start self-stretch pt-10 pb-0 max-md:pt-8 max-md:pb-0 max-sm:pt-5 max-sm:pb-0" aria-label="Company Advantages">
            <div class="main-container">
                <div class="grid grid-cols-[repeat(auto-fit,minmax(160px,1fr))] max-md:grid-cols-2 max-sm:grid-cols-1 gap-1">
                    @if (!empty($settings->advantages_cards[app()->getLocale()]) && is_array($settings->advantages_cards[app()->getLocale()]))
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
            </div>
        </section>
    </div>

    <div class="container mx-auto px-2">
        <section class="flex overflow-hidden flex-col py-10 font-bold" aria-labelledby="advantages-title">
            <div class="main-container">
                <h1 id="advantages-title" class="text-4xl leading-none text-center text-zinc-800 max-md:max-w-full">
                    {{ isset($settings->comparison_title[app()->getLocale()]) ? $settings->comparison_title[app()->getLocale()] : __('messages.advantages.title') }}
                </h1>
                <div class="flex relative flex-col self-center mt-6 w-full text-white max-md:max-w-full">
                    @if (!empty($settings->main_comparison_image))
                        <img src="{{ Storage::url($settings->main_comparison_image) }}"
                             alt="{{ isset($settings->main_comparison_alt[app()->getLocale()]) ? $settings->main_comparison_alt[app()->getLocale()] : 'Comparison of peat briquettes' }}"
                             class="object-contain z-0 w-full aspect-[4.13] rounded-[32px]" />
                    @endif
                    <div class="flex z-0 gap-2 justify-between items-center mt-2 w-full min-h-60">
                        @if (!empty($settings->comparison_items[app()->getLocale()]) && is_array($settings->comparison_items[app()->getLocale()]))
                            @foreach ($settings->comparison_items[app()->getLocale()] as $item)
                                <div class="flex relative flex-col grow shrink-0 items-start self-stretch my-auto aspect-[1.617] min-h-60 rounded-[32px]">
                                    @if (!empty($item['image']))
                                        <img src="{{ Storage::url($item['image']) }}" alt="{{ isset($item['alt']) ? $item['alt'] : '' }}"
                                             class="object-cover absolute inset-0 size-full" />
                                    @endif
                                    <div class="flex relative gap-2 items-end p-4">
                                        <p class="text-4xl leading-none">{{ isset($item['value']) ? $item['value'] : '' }}</p>
                                        <p class="text-2xl leading-tight w-[189px]">{!! isset($item['unit']) ? $item['unit'] : '' !!}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>{{ __('messages.comparison.no_items') }}</p>
                        @endif
                    </div>
                    <span class="flex absolute top-0 z-0 flex-col justify-center items-center self-start px-4 py-12 leading-none text-center whitespace-nowrap left-[489px]"
                          aria-label="Quantity of peat briquettes for comparison">
                    <span class="text-8xl tracking-tighter text-white max-md:text-4xl">{{ isset($settings->central_text_value[app()->getLocale()]) ? $settings->central_text_value[app()->getLocale()] : '1t' }}</span>
                    <span class="text-4xl text-white">{{ isset($settings->central_text_unit[app()->getLocale()]) ? $settings->central_text_unit[app()->getLocale()] : 'briquettes' }}</span>
                </span>
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
                        @if (!empty($settings->faq_items[app()->getLocale()]) && is_array($settings->faq_items[app()->getLocale()]))
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
        <section class="flex flex-col justify-center self-stretch py-10" role="main" aria-labelledby="feedback-form-title">
            <div class="main-container">
                <div class="flex flex-wrap gap-2 justify-center w-full max-md:max-w-full">
                    <div class="flex relative flex-col flex-1 shrink justify-center self-start px-5 rounded-3xl basis-0 bg-neutral-200 min-h-[570px] max-md:max-w-full">
                        <form class="z-0 w-full" aria-labelledby="feedback-form-title" novalidate>
                            <header class="w-full text-zinc-800 max-md:max-w-full">
                                <h1 id="feedback-form-title" class="text-xl font-bold leading-tight text-zinc-800 max-md:max-w-full">
                                    {{ isset($settings->feedback_form_title[app()->getLocale()]) ? $settings->feedback_form_title[app()->getLocale()] : __('messages.feedback_form.title') }}
                                </h1>
                                <p class="mt-3 text-base font-semibold leading-none text-zinc-800 max-md:max-w-full">
                                    {{ isset($settings->feedback_form_description[app()->getLocale()]) ? $settings->feedback_form_description[app()->getLocale()] : __('messages.feedback_form.description') }}
                                </p>
                            </header>
                            <fieldset class="z-0 mt-10 w-full text-base font-semibold leading-none whitespace-nowrap text-neutral-400 max-md:max-w-full">
                                <legend class="sr-only">{{ __('messages.feedback_form.contact_info') }}</legend>
                                <div class="mb-4">
                                    <label for="name-input" class="sr-only">{{ __('messages.feedback_form.name_placeholder') }}</label>
                                    <input type="text" id="name-input" name="name" placeholder="{{ __('messages.feedback_form.name_placeholder') }}"
                                           class="overflow-hidden flex-1 shrink gap-2 self-stretch px-4 py-3.5 w-full rounded-2xl border border-solid basis-0 border-[color:var(--Gray-400,#A9A9A9)] min-h-12 text-neutral-400 max-md:max-w-full focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent"
                                           aria-required="true" />
                                </div>
                                <div class="mb-4">
                                    <label for="phone-input" class="sr-only">{{ __('messages.feedback_form.phone_placeholder') }}</label>
                                    <input type="tel" id="phone-input" name="phone" placeholder="{{ __('messages.feedback_form.phone_placeholder') }}"
                                           class="overflow-hidden flex-1 shrink gap-2 self-stretch px-4 py-3.5 w-full rounded-2xl border border-solid basis-0 border-[color:var(--Gray-400,#A9A9A9)] min-h-12 text-neutral-400 max-md:max-w-full focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent"
                                           aria-required="true" />
                                </div>
                                <div class="mb-4">
                                    <div class="flex flex-col px-4 py-3 w-full leading-6 rounded-2xl border border-solid border-[color:var(--Gray-400,#A9A9A9)] max-md:max-w-full focus-within:ring-2 focus-within:ring-green-600 focus-within:border-transparent">
                                        <label for="comment-textarea" class="text-neutral-400 mb-2">{{ __('messages.feedback_form.comment_label') }}</label>
                                        <textarea id="comment-textarea" name="comment" rows="3"
                                                  class="flex-1 resize-none border-none outline-none bg-transparent text-neutral-400 placeholder-neutral-400"
                                                  placeholder="{{ __('messages.feedback_form.comment_placeholder') }}" aria-describedby="comment-help"></textarea>
                                        <div id="comment-help" class="sr-only">{{ __('messages.feedback_form.comment_help') }}</div>
                                    </div>
                                </div>
                            </fieldset>
                            <footer class="flex z-0 flex-col mt-10 w-full max-md:max-w-full">
                                <div class="flex gap-2 items-center self-start text-xs mb-4">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="privacy-checkbox" name="privacy-agreement" class="sr-only" required
                                               aria-describedby="privacy-description" />
                                        <label for="privacy-checkbox"
                                               class="flex shrink-0 w-6 h-6 rounded border-solid border-[1.5px] border-[color:var(--Gray-400,#A9A9A9)] cursor-pointer focus-within:ring-2 focus-within:ring-green-600 relative"
                                               tabindex="0" role="checkbox" aria-checked="false"
                                               onkeydown="if(event.key === ' ' || event.key === 'Enter') { event.preventDefault(); document.getElementById('privacy-checkbox').click(); }">
                                            <span class="sr-only">{{ __('messages.feedback_form.privacy_agreement') }} {{ __('messages.feedback_form.privacy_policy_link') }}</span>
                                        </label>
                                    </div>
                                    <div id="privacy-description" class="flex gap-0.5 items-start min-w-60">
                                        <span class="font-semibold text-zinc-800">{{ __('messages.feedback_form.privacy_agreement') }}</span>
                                        <a href="#privacy-policy" class="gap-2 text-indigo-500 underline rounded-lg decoration-auto decoration-solid underline-offset-auto focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                           aria-label="{{ __('messages.feedback_form.privacy_policy_link') }}">
                                            {{ __('messages.feedback_form.privacy_policy_link') }}
                                        </a>
                                    </div>
                                </div>
                                <div class="flex gap-4 items-center w-full text-base font-bold leading-snug whitespace-nowrap max-md:max-w-full"
                                     role="group">
                                    <button type="button"
                                            class="gap-2 px-6 py-2.5 text-green-600 rounded-2xl border-2 border-solid border-[color:var(--Primaries-700,#228F5D)] min-h-11 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 hover:bg-green-50 transition-colors"
                                            aria-label="{{ __('messages.feedback_form.back_button') }}">
                                        {{ __('messages.feedback_form.back_button') }}
                                    </button>
                                    <button type="submit"
                                            class="gap-2 px-6 py-2.5 text-white bg-green-600 rounded-2xl min-h-11 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 hover:bg-green-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                            aria-label="{{ __('messages.feedback_form.submit_button') }}">
                                        {{ __('messages.feedback_form.submit_button') }}
                                    </button>
                                </div>
                            </footer>
                        </form>
                    </div>
                    <aside class="flex-1 max-sm:-order-1 shrink min-w-60 max-md:max-w-full" aria-label="Додаткове зображення">
                        @if (!empty($settings->feedback_form_image))
                            <img src="{{ Storage::url($settings->feedback_form_image) }}" alt="{{ isset($settings->feedback_form_image_alt[app()->getLocale()]) ? $settings->feedback_form_image_alt[app()->getLocale()] : '' }}"
                                 class="w-full rounded-3xl aspect-[1.03]" />
                        @else
                            <p>{{ __('messages.feedback_form.no_image') }}</p>
                        @endif
                    </aside>
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
                    @if (!empty($settings->tender_items[app()->getLocale()]) && is_array($settings->tender_items[app()->getLocale()]))
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
                    <aside class="flex flex-wrap gap-2 items-end self-start min-w-[15rem] max-md:w-full max-md:flex-col max-md:gap-6"
                           aria-label="Company statistics and information">
                        <article class="min-w-[15rem] max-md:w-full">
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
    </section>
</div>

<div class="container mx-auto px-2">
    <section class="flex flex-col py-10" aria-label="Reviews">
        <div class="main-container">
            <h2 id="reviews-heading" class="w-full text-2xl font-bold leading-7 text-left text-zinc-800 max-md:text-2xl max-md:text-center max-sm:text-xl">
                {{ isset($settings->reviews_title[app()->getLocale()]) ? $settings->reviews_title[app()->getLocale()] : __('messages.reviews.title') }}
            </h2>
            <div class="flex flex-wrap gap-5 justify-center mt-5 w-full max-sm:max-w-full">
                @if (!empty($settings->review_items[app()->getLocale()]) && is_array($settings->review_items[app()->getLocale()]))
                    @foreach ($settings->review_items[app()->getLocale()] as $review)
                        <article class="flex flex-col gap-3 p-6 rounded-3xl bg-neutral-200 max-md:max-w-full">
                            <div class="flex flex-col gap-2 w-full">
                                <h3 class="gap-2.5 w-full text-xl font-bold leading-6 flex-[1_0_0] text-zinc-800 max-md:text-lg max-sm:text-base">
                                    {{ isset($review['name']) ? $review['name'] : '' }}
                                </h3>
                                <p class="text-sm font-semibold leading-5 text-zinc-800">{{ isset($review['date']) ? $review['date'] : '' }}</p>
                                <div class="flex gap-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-5 h-5 {{ $i <= ($review['rating'] ?? 0) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97a1 1 0 00.95.69h4.178c.969 0 1.371 1.24.588 1.81l-3.384 2.46a1 1 0 00-.364 1.118l1.286 3.97c.3.921-.755 1.688-1.54 1.118l-3.384-2.46a1 1 0 00-1.176 0l-3.384 2.46c-.784.57-1.838-.197-1.54-1.118l1.286-3.97a1 1 0 00-.364-1.118L2.46 8.397c-.783-.57-.38-1.81.588-1.81h4.178a1 1 0 00.95-.69l1.286-3.97z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <p class="text-base font-semibold leading-6 text-zinc-800">{{ isset($review['text']) ? $review['text'] : '' }}</p>
                            </div>
                        </article>
                    @endforeach
                @else
                    <p>{{ __('messages.reviews.no_items') }}</p>
                @endif
            </div>
        </div>
    </section>
</div>


</div>
