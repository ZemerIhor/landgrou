@php
    $footer = app(\App\Settings\FooterSettings::class);


@endphp
<footer class="self-stretch bg-zinc-800 mt-auto" role="contentinfo" aria-label="Site footer">
    <div class="main-container container mx-auto">
        <!-- Logo and social links -->
        <section class="flex flex-wrap gap-10 justify-between items-end pt-11 pb-6 w-full max-md:max-w-full">
            <x-brand.logo class="w-auto h-8 text-indigo-600" />

            @if (!empty($footer->social_links))
                <nav aria-label="Social media links" class="flex gap-5 items-start">
                    @foreach ($footer->social_links as $link)
                        @if (!empty($link['url']) && !empty($link['icon_url']))
                            <a href="{{ $link['url'] }}" aria-label="Follow us on social media">
                                <img
                                    src="{{ $link['icon_url'] }}"
                                    alt=""
                                    class="object-contain shrink-0 w-6 aspect-square"
                                    role="img"
                                />
                            </a>
                        @endif
                    @endforeach
                </nav>
            @endif
        </section>

        <!-- Navigation sections and contacts -->
        <section class="flex flex-wrap gap-10 justify-between items-start w-full text-base font-semibold leading-none text-white max-md:max-w-full">

            @if (!empty($footer->sections))
                @foreach ($footer->sections as $section)
                    @if (!empty($section['title']) && !empty($section['links']))
                        <nav aria-label="{{ $section['title'] }}" class="w-auto">
                            <ul class="space-y-5">
                                @foreach ($section['links'] as $link)
                                    @if (!empty($link['label']) && !empty($link['url']))
                                        <li>
                                            <a href="{{ $link['url'] }}"
                                               class="gap-2 self-stretch mt-5 w-full text-white rounded-lg hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-zinc-800">
                                                {{ $link['label'] }}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </nav>
                    @endif
                @endforeach
            @endif

            <!-- Contact information -->
            @if (!empty($footer->phone) || !empty($footer->email) || !empty($footer->address))
                <section aria-label="Contact information" class="min-w-60 w-[357px]">
                    <address class="not-italic">
                        <div class="space-y-5">
                            @if (!empty($footer->phone))
                                <div>
                                    <a href="tel:{{ $footer->phone }}"
                                       class="gap-2 self-stretch w-full text-white rounded-lg hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-zinc-800">
                                        {{ $footer->phone }}
                                    </a>
                                </div>
                            @endif
                            @if (!empty($footer->email))
                                <div>
                                    <a href="mailto:{{ $footer->email }}"
                                       class="gap-2 self-stretch mt-5 w-full text-white rounded-lg hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-zinc-800">
                                        {{ $footer->email }}
                                    </a>
                                </div>
                            @endif
                            @if (!empty($footer->address))
                                <div>
                                    <p class="flex-1 shrink gap-2 self-stretch mt-5 w-full leading-6 text-white rounded-lg basis-0">
                                        {{ $footer->address }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </address>
                </section>
            @endif
        </section>

        <!-- Copyright and scroll to top -->
        <section class="flex relative gap-2.5 justify-center items-start py-6 w-full max-md:max-w-full">
            <p class="z-0 my-auto text-xs font-semibold text-neutral-400">
                {{ $footer->copyright_text ?? '© Всі права захищені' }}
            </p>
            <button
                type="button"
                aria-label="Scroll to top of page"
                class="flex absolute top-0 right-4 z-0 gap-2.5 justify-center items-center self-start px-3 w-12 h-12 bg-green-600 rounded-[32px] hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-zinc-800 transition-colors duration-200"
                onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
            >
                <div class="flex self-stretch my-auto w-6 min-h-6 rotate-[-1.5707963267948966rad]" aria-hidden="true">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg" class="text-white">
                        <path d="M7 14L12 9L17 14" stroke="currentColor" stroke-width="2"
                              stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </button>
        </section>
    </div>
</footer>
