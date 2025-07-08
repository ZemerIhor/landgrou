<div class="max-w-full mx-auto">
    <div class="top-section">


    <header class="font-semibold ">
        <div class="flex relative flex-col items-center px-12 pt-14 pb-20 w-full min-h-[780px] max-md:px-5 max-md:max-w-full">
            <!-- Фоновое изображение -->
            <img
                src="{{ isset($settings->hero_background_image[app()->getLocale()]) ? Storage::url($settings->hero_background_image[app()->getLocale()]) : asset('images/fallback-hero.jpg') }}"
                alt="{{ $settings->hero_background_image_alt[app()->getLocale()] ?? __('messages.about_us.hero_background_image_alt') }}"
                class="object-cover absolute inset-0 size-full"
            />
            <div class="container mx-auto px-2">
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
                    <img
                        src="{{ isset($settings->hero_logo[app()->getLocale()]) ? Storage::url($settings->hero_logo[app()->getLocale()]) : asset('images/fallback-logo.png') }}"
                        alt="{{ $settings->hero_logo_alt[app()->getLocale()] ?? __('messages.about_us.hero_logo_alt') }}"
                        class="object-contain self-center aspect-[0.73] w-[29px]"
                    />
                    <div class="flex flex-col items-center mt-8 w-full max-md:max-w-full">
                        <h1 class="text-8xl tracking-tighter leading-none text-center max-md:max-w-full max-md:text-4xl">
                            {{ $settings->hero_title[app()->getLocale()] ?? __('messages.about_us.hero_title') }}
                        </h1>
                        <p class="self-stretch mt-2 text-2xl leading-7 text-center text-white max-md:max-w-full">
                            {!! str_replace(
                                $settings->hero_subtitle_highlight[app()->getLocale()] ?? '',
                                '<span class="text-green-600">' . ($settings->hero_subtitle_highlight[app()->getLocale()] ?? '') . '</span>',
                                $settings->hero_subtitle[app()->getLocale()] ?? __('messages.about_us.hero_subtitle')
                            ) !!}
                        </p>
                        <p class="mt-2 text-base font-semibold leading-none">
                            {{ $settings->hero_slogan[app()->getLocale()] ?? __('messages.about_us.hero_slogan') }}
                        </p>
                    </div>
                </div>
            </div>
            <p class="relative mx-auto mt-20 text-base leading-6 text-center text-white w-[780px] max-md:mt-10 max-md:max-w-full">
                {{ $settings->hero_description[app()->getLocale()] ?? __('messages.about_us.hero_description') }}
            </p>
            </div>
        </div>
    </header>

        <div class="container mx-auto px-2">

        <section class="" aria-labelledby="advantages-title">
       <div class="flex container mx-auto px-2 overflow-hidden flex-col justify-center py-10 w-full max-w-screen-xl text-center">
        <h2 id="advantages-title" class="sr-only">{{ __('messages.about_us.advantages_title') }}</h2>
        <div class="flex flex-wrap gap-2 w-full max-md:max-w-full">
            @php
                $advantages = $settings->advantages[app()->getLocale()] ?? [];
                $advantage_images = $settings->advantage_images[app()->getLocale()] ?? [];
            @endphp
            @foreach($advantages as $index => $advantage)
                <article class="flex flex-col flex-1 shrink self-end pt-6 pb-14 rounded-3xl basis-0 bg-neutral-800 min-h-[180px] shadow-[0_4px_8px_-1px_rgba(0,0,0,0.2),0_1px_1px_-1px_rgba(0,0,0,0.1)]">
                    <div class="self-center text-4xl leading-none text-green-600">
                        {{ $advantage['value'] ?? '0' }}
                    </div>
                    <div class="flex overflow-hidden flex-col items-start mt-3 w-full text-white">
                        <h3 class="text-base font-bold leading-tight text-white">
                            {{ $advantage['title'] ?? '' }}
                        </h3>
                        <p class="mt-2 text-xs font-semibold text-white">
                            {{ $advantage['description'] ?? '' }}
                        </p>
                    </div>
                </article>
                <img
                    src="{{ isset($advantage_images[$index]['image']) && Storage::disk('public')->exists($advantage_images[$index]['image']) ? Storage::url($advantage_images[$index]['image']) : asset('images/fallback-advantage.jpg') }}"
                    alt="{{ $advantage_images[$index]['alt'][app()->getLocale()] ?? '' }}"
                    class="object-contain flex-1 shrink aspect-[1.06] basis-0 shadow-[0_4px_8px_-1px_rgba(0,0,0,0.2),0_1px_1px_-1px_rgba(0,0,0,0.1)] w-[190px]"
                />
            @endforeach
        </div>
       </div>
    </section>
        </div>
    </div>
    <!-- Gallery Section -->
    <section class="bg-zinc-100 mt-4" aria-labelledby="gallery-title">
        <div class="container mx-auto px-2">
        <h2 id="gallery-title" class="text-4xl font-bold text-zinc-800">
            {{ $settings->gallery_title[app()->getLocale()] ?? __('messages.about_us.gallery_title') }}

        </h2>

        <div class="mt-5 w-full h-[400px]">
            <x-flexible-slider :aria-label="__('messages.about_us.gallery_aria_label')" :config="[
    'loop' => true,
    'autoplay' => ['delay' => 3000],
    'spaceBetween' => 10,
]">
                @foreach ($settings->gallery_images[app()->getLocale()] ?? [] as $image)
                    <div class="swiper-slide gallery-slide flex overflow-hidden flex-col items-center rounded-3xl aspect-square">
                        <img
                            src="{{ isset($image['image']) && Storage::disk('public')->exists($image['image']) ? Storage::url($image['image']) : asset('images/fallback-gallery.jpg') }}"
                            alt="{{ $image['alt'][app()->getLocale()] ?? 'Gallery Image' }}"
                            class="object-contain w-full aspect-square"
                        />
                    </div>
                @endforeach
            </x-flexible-slider>
        </div>
        </div>
    </section>



    <section class="bg-zinc-800 py-10" aria-labelledby="certificates-title">
        <div class="container mx-auto px-2">
            <h2 id="certificates-title" class="text-3xl font-bold text-white">
                {{ $settings->certificates_title[app()->getLocale()] ?? __('messages.about_us.certificates_title') }}
            </h2>

            <div class="mt-5 w-full h-[400px]">
                <?php
                    dd($settings)
                ?>
                @php
                    $certificates_images = $settings->certificates_images[app()->getLocale()] ?? [];
                @endphp

                @if (empty($certificates_images))
                    <p class="text-neutral-400 text-center">{{ __('messages.about_us.no_certificates') }}</p>
                @else
                    <x-flexible-slider
                        :aria-label="__('messages.about_us.certificates_aria_label')"
                        :config="[
                        'loop' => true,
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
                            <div class="swiper-slide flex flex-col items-center rounded-3xl aspect-[0.71] bg-white shadow-md">
                                <img
                                    src="{{ isset($image['image']) && Storage::disk('public')->exists($image['image']) ? Storage::url($image['image']) : asset('images/fallback-certificate.jpg') }}"
                                    alt="{{ $image['alt'][app()->getLocale()] ?? 'Certificate Image' }}"
                                    class="object-contain w-full h-full rounded-3xl"
                                />
                            </div>
                        @endforeach
                    </x-flexible-slider>
                @endif
            </div>
        </div>
    </section>
    <livewire:components.blog-section />

    <style>
        .top-section {
            background: #333333;
        }
    </style>
</div>
