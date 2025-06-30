<div>
    <x-welcome-banner :settings="$settings" />

    <div class="container mx-auto px-2">
        <section class="flex flex-col self-stretch py-10" aria-label="Всі продукти">
            <div class="main-container">
                <h2 class="text-2xl font-bold leading-tight text-black max-md:max-w-full">Всі продукти</h2>
                <div class="flex flex-wrap gap-2 items-center mt-5 w-full min-h-[360px] max-md:max-w-full" role="list">
                    @foreach ($allProducts as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
            </div>
        </section>
    </div>

    <div class="container mx-auto px-2">
        <section class="flex relative flex-col justify-center items-center py-16 w-full min-h-[306px] max-md:max-w-full" role="banner" aria-labelledby="hero-heading">
            @if ($settings->hero_background_image)
                <img src="{{ Storage::url($settings->hero_background_image) }}" class="object-cover absolute inset-0 size-full" alt="Background image" role="presentation" />
            @endif
            <div class="flex relative flex-col w-full max-w-[982px] max-md:max-w-full">
                <header class="flex flex-col w-full text-center text-zinc-800 max-md:max-w-full">
                    <h1 id="hero-heading" class="self-center text-2xl font-bold leading-7 w-[654px] max-md:max-w-full">
                        {{ $settings->hero_heading ?: __('messages.banner.hero_heading') }}
                    </h1>
                    <p class="mt-4 text-base font-semibold leading-none max-md:max-w-full">
                        {{ $settings->hero_subheading ?: __('messages.banner.hero_subheading') }}
                    </p>
                </header>
            </div>
        </section>
    </div>

    <div class="container mx-auto px-2">
        <section class="flex relative flex-col gap-0.5 items-start self-stretch pt-10 pb-0 max-md:pt-8 max-md:pb-0 max-sm:pt-5 max-sm:pb-0" aria-label="Company Advantages">
            <div class="main-container">
                <div class="grid grid-cols-[repeat(auto-fit,minmax(160px,1fr))] max-md:grid-cols-2 max-sm:grid-cols-1 gap-1">
                    @foreach ($settings->advantages_cards as $index => $card)
                        <article class="flex flex-col gap-3 items-center p-6 rounded-3xl bg-zinc-800">
                            <div class="flex flex-col gap-2 w-full text-center text-white">
                                <h2 class="text-base font-bold leading-5 max-sm:text-sm">{{ $card['title'] ?? '' }}</h2>
                                <p class="text-xs font-semibold leading-5 max-sm:text-xs">{{ $card['description'] ?? '' }}</p>
                            </div>
                        </article>
                        @if ($index < 3 && !empty($settings->{'advantages_image_' . ($index + 1)}))
                            <figure class="rounded-3xl max-md:h-[200px] max-sm:h-[180px]">
                                <img src="{{ Storage::url($settings->{'advantages_image_' . ($index + 1)}) }}" alt="Advantage image" class="object-cover w-full h-full rounded-3xl" />
                            </figure>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    </div>

    <div class="container mx-auto px-2">
        <section class="flex overflow-hidden flex-col py-10 font-bold" aria-labelledby="advantages-title">
            <div class="main-container">
                <h1 id="advantages-title" class="text-4xl leading-none text-center text-zinc-800 max-md:max-w-full">
                    {{ $settings->comparison_title ?: __('messages.advantages.title') }}
                </h1>
                <div class="flex relative flex-col self-center mt-6 w-full text-white max-md:max-w-full">
                    @if ($settings->main_comparison_image)
                        <img src="{{ Storage::url($settings->main_comparison_image) }}"
                             alt="{{ $settings->main_comparison_alt ?: 'Comparison of peat briquettes' }}"
                             class="object-contain z-0 w-full aspect-[4.13] rounded-[32px]" />
                    @endif
                    <div class="flex z-0 gap-2 justify-between items-center mt-2 w-full min-h-60">
                        @foreach ($settings->comparison_items as $item)
                            <div class="flex relative flex-col grow shrink-0 items-start self-stretch my-auto aspect-[1.617] min-h-60 rounded-[32px]">
                                @if ($item['image'])
                                    <img src="{{ Storage::url($item['image']) }}" alt="{{ $item['alt'] ?? '' }}"
                                         class="object-cover absolute inset-0 size-full" />
                                @endif
                                <div class="flex relative gap-2 items-end p-4">
                                    <p class="text-4xl leading-none">{{ $item['value'] ?? '' }}</p>
                                    <p class="text-2xl leading-tight w-[189px]">{!! $item['unit'] ?? '' !!}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <span class="flex absolute top-0 z-0 flex-col justify-center items-center self-start px-4 py-12 leading-none text-center whitespace-nowrap left-[489px]"
                          aria-label="Quantity of peat briquettes for comparison">
                        <span class="text-8xl tracking-tighter text-white max-md:text-4xl">{{ $settings->central_text_value ?: '1t' }}</span>
                        <span class="text-4xl text-white">{{ $settings->central_text_unit ?: 'briquettes' }}</span>
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
                    @if ($settings->feedback_form_image)
                        <img src="{{ Storage::url($settings->feedback_form_image) }}" alt="{{ $settings->feedback_form_image_alt }}"
                             class="rounded-3xl max-w-xs" />
                    @else
                        <p>Изображение не загружено</p>
                    @endif
                    <div class="flex-1 shrink self-start basis-0 min-w-60 max-md:max-w-full">
                        @foreach ($settings->faq_items as $index => $faq)
                            <article class="flex flex-wrap items-start px-4 py-2 w-full rounded-3xl bg-neutral-200 max-md:max-w-full mb-1">
                                <div class="flex-1 shrink pt-4 pb-2 pl-4 basis-0 min-w-60 text-zinc-800 max-md:max-w-full">
                                    <h2 class="flex-1 shrink gap-2.5 self-stretch pb-2 w-full text-xl font-bold leading-6 basis-0 text-zinc-800 max-md:max-w-full cursor-pointer"
                                        data-toggle="faq-{{ $index + 1 }}">
                                        {{ $faq['question'] }}
                                    </h2>
                                    <div class="flex w-full bg-zinc-300 min-h-px max-md:max-w-full"></div>
                                    <p class="faq-answer max-h-0 overflow-hidden transition-all duration-300 ease-in-out text-base font-semibold leading-none text-zinc-800 max-md:max-w-full"
                                       id="faq-{{ $index + 1 }}">
                                        {{ $faq['answer'] }}
                                    </p>
                                </div>
                                <button class="flex shrink-0 gap-2.5 w-14 h-14 items-center justify-center"
                                        aria-label="Toggle answer" aria-expanded="false" data-toggle="faq-{{ $index + 1 }}">
                                    <svg class="w-6 h-6 text-zinc-800 toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </button>
                            </article>
                        @endforeach
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
                                    {{ $settings->feedback_form_title ?: __('messages.feedback_form.title') }}
                                </h1>
                                <p class="mt-3 text-base font-semibold leading-none text-zinc-800 max-md:max-w-full">
                                    {{ $settings->feedback_form_description ?: __('messages.feedback_form.description') }}
                                </p>
                            </header>
                            <fieldset class="z-0 mt-10 w-full text-base font-semibold leading-none whitespace-nowrap text-neutral-400 max-md:max-w-full">
                                <legend class="sr-only">Контактна інформація</legend>
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
                                        <div id="comment-help" class="sr-only">Додаткова інформація або коментарі</div>
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
                        @if ($settings->feedback_form_image)
                            <img src="{{ Storage::url($settings->feedback_form_image) }}" alt="{{ $settings->feedback_form_image_alt }}"
                                 class=" w-full rounded-3xl aspect-[1.03]" />
                        @else
                            <p>Изображение не загружено</p>
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
                    {{ $settings->tenders_title ?: __('messages.tenders.title') }}
                </h1>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2 mt-5 w-full font-semibold leading-6 text-white max-md:max-w-full">
                    @foreach ($settings->tender_items as $tender)
                        <article class="flex overflow-hidden relative p-4 rounded-3xl min-h-[210px]"
                                 style="background-color: {{ $tender['background_color'] }}"
                                 aria-label="Tender for {{ $tender['title'] }}">
                            <img src="{{ Storage::url($tender['background_pattern']) }}" alt="Background pattern"
                                 class="object-contain absolute bottom-0 right-1 z-0 aspect-[1.68]" />
                            <div class="z-0 flex-1 p-4">
                                <img src="{{ Storage::url($tender['icon']) }}" alt="{{ $tender['title'] }} icon"
                                     class="object-contain w-10 aspect-square" />
                                <h2 class="mt-5 min-h-[88px] {{ str_contains($tender['background_color'], 'green') ? 'text-white' : 'text-green-600' }}">
                                    {{ $tender['title'] }}
                                </h2>
                            </div>
                            <div class="flex z-0 shrink-0 gap-2.5 self-end w-14 h-14"></div>
                        </article>
                    @endforeach
                </div>
                <div class="flex flex-wrap gap-5 items-center mt-5 w-full max-md:max-w-full max-md:flex-col">
                    <div class="flex flex-1 shrink gap-4 items-center self-stretch my-auto font-semibold leading-none basis-12 min-h-6 justify-end text-zinc-800 max-md:max-w-full max-md:justify-center">
                        <i class="fas fa-phone w-6 h-6 text-zinc-800"></i>
                        <p class="text-zinc-800">{{ $settings->tenders_phone }}</p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <section class="flex overflow-hidden flex-col bg-zinc-800" role="main" aria-labelledby="about-heading">
        <div class="container mx-auto px-2">
            <div class="main-container relative">
                <div class="flex z-10 flex-wrap justify-between relative py-10 w-full max-md:max-w-full">
                    <article class="flex flex-col flex-1 shrink items-start font-bold basis-0 min-w-60 max-md:max-w-full">
                        <header class="max-w-full w-[487px]">
                            <h1 id="about-heading" class="text-4xl leading-none text-white max-md:max-w-full">
                                {{ $settings->about_title ?: __('messages.about.title') }}
                            </h1>
                            <p class="mt-5 text-xl leading-6 text-white max-md:max-w-full">{!! $settings->about_description !!}</p>
                        </header>
                        <nav class="flex gap-4 items-center mt-40 text-base leading-snug whitespace-nowrap max-md:mt-10"
                             role="navigation" aria-label="About us actions">
                            <a href="{{ $settings->about_more_link }}"
                               class="flex gap-2 justify-center items-center self-stretch px-6 py-2.5 my-auto text-green-600 rounded-2xl border-2 border-solid border-[color:var(--Primaries-700,#228F5D)] min-h-11 hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-zinc-800"
                               type="button" aria-label="{{ __('messages.about.more_button_aria_label') }}">
                                <span class="self-stretch my-auto text-green-600">{{ __('messages.about.more_button') }}</span>
                            </a>
                            <a href="{{ $settings->about_certificates_link }}"
                               class="gap-2 self-stretch px-6 py-2.5 my-auto text-white bg-green-600 rounded-2xl min-h-11 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-zinc-800"
                               type="button" aria-label="{{ __('messages.about.certificates_button_aria_label') }}">
                                {{ __('messages.about.certificates_button') }}
                            </a>
                        </nav>
                    </article>
                    <aside class="flex flex-wrap gap-2 items-end self-start min-w-60 max-md:max-w-full"
                           aria-label="Company statistics and information">
                        <article class="min-w-60">
                            <header>
                                <h2 class="text-4xl font-bold leading-none text-green-600">
                                    {{ $settings->about_statistic_title }}
                                </h2>
                            </header>
                            <div class="mt-3 text-xs font-semibold leading-5 text-white">
                                {!! $settings->about_statistic_description !!}
                            </div>
                        </article>
                        <figure class="overflow-hidden text-xs font-semibold text-right text-white rounded-3xl min-w-60 shadow-[var(--sds-size-depth-0)_var(--sds-size-depth-400)_var(--sds-size-depth-800)_var(--sds-size-depth-negative-200)_var(--sds-color-black-400)]">
                            <div class="flex relative flex-col px-7 pb-4 w-full aspect-[0.57] pt-[473px] max-md:pt-24 max-md:pl-5">
                                <img src="{{ Storage::url($settings->about_location_image) }}" alt="{{ $settings->about_location_caption }}"
                                     class="object-cover absolute inset-0 size-full" />
                                <figcaption class="relative z-10">{{ $settings->about_location_caption }}</figcaption>
                            </div>
                        </figure>
                    </aside>
                </div>
            </div>
        </div>
    </section>

        <section class="box-border flex flex-col gap-5 items-center py-20 w-full bg-neutral-200 max-md:py-16 max-sm:py-10" role="region" aria-labelledby="reviews-heading">
            <div class="main-container w-full px-4">
                <div class="container mx-auto px-2">

                <div class="w-full">
                    <h2 id="reviews-heading" class="w-full text-2xl font-bold leading-7 text-left text-zinc-800 max-md:text-2xl max-md:text-center max-sm:text-xl">
                        {{ $settings->reviews_title ?: __('messages.reviews.title') }}
                    </h2>
                </div>
                <div class="swiper mt-5 w-full" role="list">
                    <div class="swiper-wrapper">
                        @foreach ($settings->review_items as $review)
                            <div class="swiper-slide mt-2 flex flex-col items-start rounded-3xl bg-zinc-100 max-md:w-full" role="listitem">
                                <div class="box-border flex flex-col items-start p-10 w-full max-md:p-8 max-sm:p-6">
                                    <header class="flex flex-col gap-4 items-start pb-5 w-full">
                                        <div class="flex gap-5 items-center w-full">
                                            <div class="flex flex-col gap-1 items-start flex-[1_0_0]">
                                                <h3 class="gap-2.5 w-full text-xl font-bold leading-6 flex-[1_0_0] text-zinc-800 max-md:text-lg max-sm:text-base">
                                                    {{ $review['name'] }}
                                                </h3>
                                                <div class="flex gap-1.5 items-start w-full">
                                                    <time class="gap-4 text-xs font-bold leading-5 text-neutral-400 max-sm:text-xs" datetime="{{ $review['date'] }}">
                                                        {{ \Carbon\Carbon::parse($review['date'])->format('d F Y') }}
                                                    </time>
                                                </div>
                                            </div>
                                            <div class="flex gap-1 items-start pt-1.5 h-14" role="img" aria-label="Rating: {{ $review['rating'] }} out of 5 stars">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <div class="flex relative justify-center items-center w-3.5 h-3.5">
                                                        <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                                                             class="{{ $i <= $review['rating'] ? 'star-active' : 'star-inactive' }}"
                                                             style="width: 14px; height: 14px; flex-shrink: 0" aria-hidden="true">
                                                            <path d="M8.00936 2.72503L9.03602 4.77836C9.17602 5.0642 9.54936 5.33836 9.86436 5.39086L11.7252 5.70003C12.9152 5.89836 13.1952 6.7617 12.3377 7.61336L10.891 9.06003C10.646 9.30503 10.5119 9.77753 10.5877 10.1159L11.0019 11.9067C11.3285 13.3242 10.576 13.8725 9.32186 13.1317L7.57769 12.0992C7.26269 11.9125 6.74352 11.9125 6.42269 12.0992L4.67852 13.1317C3.43019 13.8725 2.67186 13.3184 2.99852 11.9067L3.41269 10.1159C3.48852 9.77753 3.35436 9.30503 3.10936 9.06003L1.66269 7.61336C0.811024 6.7617 1.08519 5.89836 2.27519 5.70003L4.13602 5.39086C4.44519 5.33836 4.81852 5.0642 4.95852 4.77836L5.98519 2.72503C6.54519 1.61086 7.45519 1.61086 8.00936 2.72503Z"
                                                                  fill="{{ $i <= $review['rating'] ? '#FACC15' : '#DBDBDB' }}"></path>
                                                        </svg>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </header>
                                    <div class="flex gap-2.5 items-start w-full">
                                        <p class="gap-2.5 w-full text-base font-bold leading-5 flex-[1_0_0] text-zinc-800 max-md:text-base max-sm:text-sm">
                                            {{ $review['text'] }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            </div>
        </section>

</div>
