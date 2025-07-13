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


       <div class="  mx-auto px-[16px] sm:px-[28px] md:px-[50px]">
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
                                    <button class="faq-toggle flex shrink-0 gap-2.5 w-14 h-14 items-center justify-center"
                                            aria-label="Toggle answer" aria-expanded="false" data-toggle="faq-{{ $counter }}">
                                        <svg class="arrow-close hidden"  width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M31.8034 27.2923L31.8034 11.8746L12.1966 31.4813L20.867 22.8109C24.8863 18.7917 31.7602 21.6083 31.8034 27.2923Z" fill="#228F5D"/>
<path d="M31.8034 11.8746L21.5249 11.8746L16.3857 11.8746C22.0726 11.8951 24.9063 18.7716 20.8851 22.7929L12.1966 31.4813L31.8034 11.8746Z" fill="#228F5D"/>
<path d="M10.2466 11.8741C10.2466 11.3219 10.6942 10.8742 11.2465 10.8742L31.8036 10.8742C32.3557 10.8744 32.8035 11.322 32.8035 11.8741V32.4313C32.8035 32.9834 32.3557 33.431 31.8036 33.4312C31.2514 33.4312 30.8038 32.9836 30.8038 32.4313L30.8031 27.2917C30.7609 22.5753 25.1441 20.2025 21.735 23.3625L21.5741 23.5179L12.9037 32.1883C12.5133 32.5787 11.8801 32.5787 11.4895 32.1883C11.1235 31.8222 11.1003 31.2428 11.4205 30.85L11.4895 30.774L20.1778 22.0857C23.5703 18.6932 21.1797 12.8921 16.382 12.8747L16.3813 12.874L11.2465 12.874C10.6942 12.874 10.2466 12.4264 10.2466 11.8741ZM25.169 19.923C27.2744 19.8727 29.3483 20.7308 30.8024 22.2556L30.8038 14.2882L25.169 19.923ZM21.4429 12.874C22.9628 14.3248 23.8188 16.3934 23.77 18.4936L29.3895 12.874H21.4429Z" fill="#228F5D"/>
</svg>

<svg class="arrow-open block" width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M12.1621 16.1244L12.2575 31.5418L31.7426 11.8141L23.126 20.538C19.1317 24.582 12.2405 21.8079 12.1621 16.1244L L12.1621 16.1244Z" fill="#228F5D"/>
<path d="M12.2575 31.5418L22.5358 31.4782L27.6749 31.4464L L27.6749 31.4464C21.988 31.461 19.1118 24.6022 23.1081 20.5561L31.7426 11.8141L12.2575 31.5418Z" fill="#228F5D"/>
<path d="M33.8138 31.4087C33.817 31.9264 33.4263 32.3543 32.9223 32.4086L32.8202 32.4148L12.2634 32.5419C11.7113 32.5451 11.2608 32.1003 11.2573 31.5482L11.1301 10.9914C11.1268 10.4393 11.5718 9.989 12.1238 9.98538C12.6761 9.98196 13.1264 10.4268 13.1299 10.9791L13.1624 16.1186C13.2337 20.8346 18.865 23.1726 22.2546 19.9916L22.4145 19.8352L31.0311 11.1114C31.4191 10.7185 32.0523 10.7147 32.4452 11.1026C32.8135 11.4664 32.8403 12.0457 32.5226 12.4404L32.454 12.5168L23.8196 21.2587C20.4481 24.6722 22.8747 30.4584 27.6724 30.4461L27.6731 30.4468L32.8078 30.415L32.9107 30.4192C33.415 30.4675 33.8106 30.8911 33.8138 31.4087ZM18.8419 23.4523C16.7368 23.5156 14.6576 22.6704 13.1942 21.1546L13.2421 29.1218L18.8419 23.4523ZM22.6116 30.4781C21.0827 29.0367 20.2139 26.9734 20.2497 24.873L14.665 30.5272L22.6116 30.4781Z" fill="#228F5D"/>
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
                    @if (!empty($item['decorative_image']))
                        <img
                            src="{{ $item['decorative_image'] }}"
                            alt="Декоративне зображення для тендеру {{ $item['title'] }}"
                            class="object-contain absolute bottom-0 right-1 z-0 self-start aspect-[1.68] h-[485px] min-w-60 w-[352px]"
                            style="fill: {{ $item['background_color'] ?? '#34C759' }};"
                        />
                    @endif
                    <div class="z-0 flex-1 shrink p-4 basis-0 min-w-60">
                        @if (!empty($item['icon']))
                            <img
                                src="{{ $item['icon'] }}"
                                alt="Іконка категорії {{ $item['title'] }}"
                                class="object-contain w-10 aspect-square"
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

