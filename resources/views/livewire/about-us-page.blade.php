@php
    \Log::info('Current Locale', ['locale' => app()->getLocale()]);
@endphp

<div class="max-w-full mx-auto">
    <div class="top-section">
        <header class="font-semibold">
            <div class="flex relative flex-col items-center pb-20 w-full min-h-[780px] max-md:px-5 max-md:max-w-full">
                <!-- Фоновое изображение -->
                @if (isset($settings->hero_background_image) && Storage::disk('public')->exists($settings->hero_background_image))
                    <img
                        src="{{ Storage::url($settings->hero_background_image) }}"
                        alt="{{ is_array($settings->hero_background_image_alt) ? ($settings->hero_background_image_alt[app()->getLocale()] ?? $settings->hero_background_image_alt['en'] ?? __('messages.about_us.hero_background_image_alt')) : ($settings->hero_background_image_alt ?? __('messages.about_us.hero_background_image_alt')) }}"
                        class="object-cover absolute inset-0 size-full"
                    />
                @else
                    <img
                        src="{{ asset('images/fallback-hero.jpg') }}"
                        alt="{{ __('messages.about_us.hero_background_image_alt') }}"
                        class="object-cover absolute inset-0 size-full"
                    />
                @endif

                <div class="mx-auto w-full px-[16px] sm:px-[28px] md:px-[50px]">
                    <!-- Breadcrumbs -->
                    <nav aria-label="{{ __('messages.about_us.breadcrumbs_aria_label') }}" class="flex relative flex-wrap gap-2 items-center self-stretch w-full text-xs min-h-[34px] max-md:max-w-full">
                        <div class="flex gap-2 items-center self-stretch py-2 my-auto whitespace-nowrap text-neutral-400">
                            <a href="/" class="self-stretch my-auto hover:text-white focus:text-white transition-colors">{{ __('messages.about_us.home') }}</a>
                        </div>
                        <div class="flex gap-2 items-center self-stretch py-2 my-auto text-zinc-800">
                            <div class="flex flex-col justify-center self-stretch my-auto w-1.5 whitespace-nowrap" aria-hidden="true">
                                <span>/</span>
                            </div>
                            <span class="self-stretch my-auto">{{ __('messages.about_us.title') }}</span>
                        </div>
                    </nav>

                    <!-- Hero Content -->
                    <div class="relative mx-auto mt-40 max-w-full font-bold text-white w-[568px] max-md:mt-10">
                        <div class="flex flex-col w-full max-md:max-w-full">
                            <!-- Логотип -->
                            @if (isset($settings->hero_logo) && Storage::disk('public')->exists($settings->hero_logo))
                                <img
                                    src="{{ Storage::url($settings->hero_logo) }}"
                                    alt="{{ is_array($settings->hero_logo_alt) ? ($settings->hero_logo_alt[app()->getLocale()] ?? $settings->hero_logo_alt['en'] ?? __('messages.about_us.hero_logo_alt')) : ($settings->hero_logo_alt ?? __('messages.about_us.hero_logo_alt')) }}"
                                    class="object-contain self-center aspect-[0.73] w-[29px]"
                                />
                            @else
                                <img
                                    src="{{ asset('images/fallback-logo.png') }}"
                                    alt="{{ __('messages.about_us.hero_logo_alt') }}"
                                    class="object-contain self-center aspect-[0.73] w-[29px]"
                                />
                            @endif

                            <div class="flex flex-col items-center mt-8 w-full max-md:max-w-full">
                                <!-- Заголовок -->
                                @if (isset($settings->hero_title) && (is_array($settings->hero_title) ? isset($settings->hero_title[app()->getLocale()]) : is_string($settings->hero_title)))
                                    <h1 class="text-8xl tracking-tighter leading-none text-center max-md:max-w-full max-md:text-4xl">
                                        {{ is_array($settings->hero_title) ? $settings->hero_title[app()->getLocale()] : $settings->hero_title }}
                                    </h1>
                                @else
                                    <h1 class="text-8xl tracking-tighter leading-none text-center max-md:max-w-full max-md:text-4xl">
                                        {{ __('messages.about_us.hero_title') }}
                                    </h1>
                                @endif

                                <!-- Подзаголовок -->
                                @if (isset($settings->hero_subtitle) && (is_array($settings->hero_subtitle) ? isset($settings->hero_subtitle[app()->getLocale()]) : is_string($settings->hero_subtitle)))
                                    <p class="self-stretch mt-2 text-2xl leading-7 text-center text-white max-md:max-w-full">
                                        {!! str_replace(
                                            is_array($settings->hero_subtitle_highlight) && isset($settings->hero_subtitle_highlight[app()->getLocale()]) ? $settings->hero_subtitle_highlight[app()->getLocale()] : '',
                                            '<span class="text-green-600">' . (is_array($settings->hero_subtitle_highlight) && isset($settings->hero_subtitle_highlight[app()->getLocale()]) ? $settings->hero_subtitle_highlight[app()->getLocale()] : '') . '</span>',
                                            is_array($settings->hero_subtitle) ? $settings->hero_subtitle[app()->getLocale()] : $settings->hero_subtitle
                                        ) !!}
                                    </p>
                                @else
                                    <p class="self-stretch mt-2 text-2xl leading-7 text-center text-white max-md:max-w-full">
                                        {{ __('messages.about_us.hero_subtitle') }}
                                    </p>
                                @endif

                                <!-- Слоган -->
                                @if (isset($settings->hero_slogan) && (is_array($settings->hero_slogan) ? isset($settings->hero_slogan[app()->getLocale()]) : is_string($settings->hero_slogan)))
                                    <p class="mt-2 text-base font-semibold leading-none">
                                        {{ is_array($settings->hero_slogan) ? $settings->hero_slogan[app()->getLocale()] : $settings->hero_slogan }}
                                    </p>
                                @else
                                    <p class="mt-2 text-base font-semibold leading-none">
                                        {{ __('messages.about_us.hero_slogan') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Описание -->
                    @if (isset($settings->hero_description) && (is_array($settings->hero_description) ? isset($settings->hero_description[app()->getLocale()]) : is_string($settings->hero_description)))
                        <p class="relative mx-auto mt-20 text-base leading-6 text-center text-white w-[780px] max-md:mt-10 max-md:max-w-full">
                            {{ is_array($settings->hero_description) ? $settings->hero_description[app()->getLocale()] : $settings->hero_description }}
                        </p>
                    @else
                        <p class="relative mx-auto mt-20 text-base leading-6 text-center text-white w-[780px] max-md:mt-10 max-md:max-w-full">
                            {{ __('messages.about_us.hero_description') }}
                        </p>
                    @endif
                </div>
            </div>
        </header>

        <!-- Advantages Section -->
        <div class="mx-auto px-[16px] sm:px-[28px] md:px-[50px]">
            <section aria-labelledby="advantages-title">
                <div class="flex mx-auto items-center overflow-hidden  items-stretch flex-col justify-center py-10 w-full max-w-screen-xl text-center">
                    <h2 id="advantages-title" class="sr-only">{{ __('messages.about_us.advantages_title') }}</h2>
                    @php
                        $advantages = isset($settings->advantages) && is_array($settings->advantages) ? ($settings->advantages[app()->getLocale()] ?? []) : [];
                        $advantage_images = $settings->advantage_images ?? [];
                    @endphp
                    @if (!empty($advantages))
                        <div class="flex flex-wrap gap-2 w-full max-md:max-w-full">
                            @foreach($advantages as $index => $advantage)
                                <article class="flex flex-col flex-1 shrink self-end p-6 items-center justify-center aspect-[1] rounded-3xl basis-0 bg-neutral-800 min-h-[180px] shadow-[0_4px_8px_-1px_rgba(0,0,0,0.2),0_1px_1px_-1px_rgba(0,0,0,0.1)]">
                                    <div class="self-center text-4xl leading-none text-green-600">
                                        {{ $advantage['value'] ?? '0' }}
                                    </div>
                                    <div class="flex overflow-hidden flex-col items-center mt-3 w-full text-white">
                                        @if (isset($advantage['title']) && is_string($advantage['title']))
                                            <h3 class="text-base font-bold leading-tight text-white">
                                                {{ $advantage['title'] }}
                                            </h3>
                                        @endif
                                        @if (isset($advantage['description']) && is_string($advantage['description']))
                                            <p class="mt-2 text-xs font-semibold text-white">
                                                {{ $advantage['description'] }}
                                            </p>
                                        @endif
                                    </div>
                                </article>
                                @if (isset($advantage_images[$index]) && isset($advantage_images[$index]['image']) && Storage::disk('public')->exists($advantage_images[$index]['image']))
                                    <img
                                        src="{{ Storage::url($advantage_images[$index]['image']) }}"
                                        alt="{{ is_array($advantage_images[$index]['alt']) ? ($advantage_images[$index]['alt'][app()->getLocale()] ?? $advantage_images[$index]['alt']['en'] ?? '') : ($advantage_images[$index]['alt'] ?? '') }}"
                                        class="object-cover flex-1 rounded-3xl  h-full shrink aspect-[1] basis-0 shadow-[0_4px_8px_-1px_rgba(0,0,0,0.2),0_1px_1px_-1px_rgba(0,0,0,0.1)] w-[190px]"
                                    />
                                @elseif (isset($advantage_images[$index]))
                                    <img
                                        src="{{ asset('images/fallback-advantage.jpg') }}"
                                        alt="{{ is_array($advantage_images[$index]['alt']) ? ($advantage_images[$index]['alt'][app()->getLocale()] ?? $advantage_images[$index]['alt']['en'] ?? '') : ($advantage_images[$index]['alt'] ?? '') }}"
                                        class="object-cover flex-1 rounded-3xl h-full shrink aspect-[1] basis-0 shadow-[0_4px_8px_-1px_rgba(0,0,0,0.2),0_1px_1px_-1px_rgba(0,0,0,0.1)] w-[190px]"
                                    />
                                @endif
                            @endforeach
                        </div>
                    @else
                        <p class="text-neutral-400 text-center">{{ __('messages.about_us.no_advantages') }}</p>
                    @endif
                </div>
            </section>
        </div>

        <!-- Gallery Section -->
        <section class="bg-zinc-100 px-[16px] sm:px-[28px] md:px-[50px] py-[80px]" aria-labelledby="gallery-title">
            <div class="mx-auto">
                @if (isset($settings->gallery_title) && (is_array($settings->gallery_title) ? isset($settings->gallery_title[app()->getLocale()]) : is_string($settings->gallery_title)))
                    <h2 id="gallery-title" class="text-4xl font-bold text-zinc-800">
                        {{ is_array($settings->gallery_title) ? $settings->gallery_title[app()->getLocale()] : $settings->gallery_title }}
                    </h2>
                @else
                    <h2 id="gallery-title" class="text-4xl font-bold text-zinc-800">
                        {{ __('messages.about_us.gallery_title') }}
                    </h2>
                @endif

                @php
                    $gallery_images = $settings->gallery_images ?? [];
                @endphp
                @if (!empty($gallery_images))
                    <div class="mt-5 py-6 w-full h-[400px]" id="about-us_gallery-swiper">
                        <x-flexible-slider :aria-label="__('messages.about_us.gallery_aria_label')" :config="[
                            'loop' => true,
                            'autoplay' => ['delay' => 3000],
                            'spaceBetween' => 10,
                        ]">
                            @foreach ($gallery_images as $image)
                                <div class="swiper-slide gallery-slide flex overflow-hidden flex-col items-center rounded-3xl aspect-square">
                                    @if (isset($image['image']) && Storage::disk('public')->exists($image['image']))
                                        <img
                                            src="{{ Storage::url($image['image']) }}"
                                            alt="{{ is_array($image['alt']) ? ($image['alt'][app()->getLocale()] ?? $image['alt']['en'] ?? 'Gallery Image') : ($image['alt'] ?? 'Gallery Image') }}"
                                            class="object-cover w-full h-full aspect-square"
                                        />
                                    @else
                                        <img
                                            src="{{ asset('images/fallback-gallery.jpg') }}"
                                            alt="{{ is_array($image['alt']) ? ($image['alt'][app()->getLocale()] ?? $image['alt']['en'] ?? 'Gallery Image') : ($image['alt'] ?? 'Gallery Image') }}"
                                            class="object-cover w-full h-full  aspect-square"
                                        />
                                    @endif
                                </div>
                            @endforeach
                        </x-flexible-slider>
                    </div>
                @else
                    <p class="text-neutral-400 text-center">{{ __('messages.about_us.no_gallery_images') }}</p>
                @endif
            </div>
        </section>

        <!-- Certificates Section -->
        <section class="bg-zinc-800 px-[16px] sm:px-[28px] md:px-[50px] py-[80px]" aria-labelledby="certificates-title">
            <div class="container mx-auto px-2">
                @if (isset($settings->certificates_title) && (is_array($settings->certificates_title) ? isset($settings->certificates_title[app()->getLocale()]) : is_string($settings->certificates_title)))
                    <h2 id="certificates-title" class="text-3xl font-bold text-white">
                        {{ is_array($settings->certificates_title) ? $settings->certificates_title[app()->getLocale()] : $settings->certificates_title }}
                    </h2>
                @else
                    <h2 id="certificates-title" class="text-3xl font-bold text-white">
                        {{ __('messages.about_us.certificates_title') }}
                    </h2>
                @endif

                @php
                    $certificates_images = $settings->certificates_images ?? [];
                @endphp
                @if (!empty($certificates_images))
                    <div class="mt-5 w-full h-[400px]">
                        <x-flexible-slider
                            :aria-label="__('messages.about_us.certificates_aria_label')"
                            :config="[
                                'loop' => false,
                                'autoplay' => ['delay' => 3000],
                                'spaceBetween' => 10,
                                'slidesPerView' => 3,
                                'breakpoints' => [
                                    640 => ['slidesPerView' => 1],
                                    768 => ['slidesPerView' => 2],
                                    1024 => ['slidesPerView' => 3]
                                ]
                            ]"
                        >
                            @foreach ($certificates_images as $image)
                                <div class="swiper-slide certificate-slide flex flex-col items-center rounded-3xl aspect-[0.71] bg-white shadow-md">
                                    @if (isset($image['image']) && Storage::disk('public')->exists($image['image']))
                                        <img
                                            src="{{ Storage::url($image['image']) }}"
                                            alt="{{ is_array($image['alt']) ? ($image['alt'][app()->getLocale()] ?? $image['alt']['en'] ?? 'Certificate Image') : ($image['alt'] ?? 'Certificate Image') }}"
                                            class="object-contain w-full h-full rounded-3xl"
                                        />
                                    @else
                                        <img
                                            src="{{ asset('images/fallback-certificate.jpg') }}"
                                            alt="{{ is_array($image['alt']) ? ($image['alt'][app()->getLocale()] ?? $image['alt']['en'] ?? 'Certificate Image') : ($image['alt'] ?? 'Certificate Image') }}"
                                            class="object-contain w-full h-full rounded-3xl"
                                        />
                                    @endif
                                </div>
                            @endforeach
                        </x-flexible-slider>
                    </div>
                @else
                    <p class="text-neutral-400 text-center">{{ __('messages.about_us.no_certificates') }}</p>
                @endif
            </div>
        </section>
    </div>
    <livewire:components.blog-section />
    <style>
        .top-section {
            background: #333333;
        }
    </style>

</div>

