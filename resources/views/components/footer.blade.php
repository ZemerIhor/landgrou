@php
    $footer = app(\App\Settings\FooterSettings::class);
    $currentLocale = app()->getLocale(); // Get current locale (e.g., 'en' or 'uk')
@endphp

<footer class="self-stretch bg-zinc-800 mt-auto px-[50px]" role="contentinfo" aria-label="Site footer">

    <div class="main-container container mx-auto px-2">
        <section class="flex flex-wrap gap-10 justify-between items-end pt-11 pb-6 w-full max-md:max-w-full">
            <x-brand.logo class="w-auto h-8 text-indigo-600" />

            @if (!empty($footer->social_links))
                <nav aria-label="{{ __('messages.footer.social_aria_label') }}" class="flex gap-5 items-start">
                    @foreach ($footer->social_links as $link)
                        @if (!empty($link['url']) && !empty($link['icon']))
                            <a href="{{ $link['url'] }}" aria-label="{{ __('messages.footer.follow_on') }} {{ $link['icon'] }}" target="_blank" rel="noopener noreferrer">
                                <img
                                    src="{{ asset('images/icons/' . $link['icon'] . '.svg') }}"
                                    alt="{{ $link['icon'] }} icon"
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
        <section class="grid grid-cols-[repeat(auto-fit,minmax(220px,1fr))] gap-10 items-start w-full text-base font-semibold leading-none text-white max-md:grid-cols-1">
            <!-- Меню футера -->
            @if (app()->getLocale() === 'en')
                <nav class="flex flex-col gap-5 items-start min-w-[220px]" aria-label="{{ __('messages.footer.main_navigation') }}">
                    <x-filament-menu-builder::menu slug="futer-en" />
                </nav>
            @elseif (app()->getLocale() === 'uk')
                <nav class="flex flex-col gap-5 items-start min-w-[220px]" aria-label="{{ __('messages.footer.main_navigation') }}">
                    <x-filament-menu-builder::menu slug="futer-ua" />
                </nav>
            @else
                <nav class="flex flex-col gap-5 items-start min-w-[220px]" aria-label="{{ __('messages.footer.main_navigation') }}">
                    <x-filament-menu-builder::menu slug="futer-en" />
                </nav>
            @endif

            <!-- Контактная информация -->
            @if (isset($footer) && (!empty($footer->phone) || !empty($footer->email) || !empty($footer->address)))
                <section aria-label="{{ __('messages.footer.contact_aria_label') }}" class="min-w-[220px] max-w-[357px]">
                    <address class="not-italic">
                        <div class="space-y-5">
                            @if (!empty($footer->phone))
                                <div class="flex gap-2 items-center self-stretch rounded-lg">
                                    <a href="tel:{{ $footer->phone }}"
                                       class="text-base font-bold text-white max-sm:text-sm hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-zinc-900"
                                       aria-label="{{ __('messages.footer.phone_aria_label') }}">
                                        {{ $footer->phone }}
                                    </a>
                                </div>
                            @endif
                            @if (!empty($footer->email))
                                <div class="flex gap-2 items-center self-stretch rounded-lg">
                                    <a href="mailto:{{ is_array($footer->email) ? ($footer->email[app()->getLocale()] ?? $footer->email['en'] ?? '') : $footer->email }}"
                                       class="text-base font-bold text-white max-sm:text-sm hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-zinc-900"
                                       aria-label="{{ __('messages.footer.email_aria_label') }}">
                                        {{ is_array($footer->email) ? ($footer->email[app()->getLocale()] ?? $footer->email['en'] ?? '') : $footer->email }}
                                    </a>
                                </div>
                            @endif
                            @if (!empty($footer->address))
                                <div class="flex gap-2 items-center self-stretch rounded-lg">
                                    <p class="text-base font-bold text-white max-sm:text-sm not-italic flex-[1_0_0]">
                                        {{ is_array($footer->address) ? ($footer->address[app()->getLocale()] ?? $footer->address['en'] ?? '') : $footer->address }}
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
                {{ is_array($footer->copyright_text) ? ($footer->copyright_text[app()->getLocale()] ?? $footer->copyright_text['en'] ?? '© All rights reserved') : ($footer->copyright_text ?? '© All rights reserved') }}
            </p>
            <button
                type="button"
                aria-label="{{ __('messages.footer.scroll_to_top') }}"
                class="flex absolute top-0 right-4 z-0 gap-2.5 justify-center items-center self-start px-3 w-12 h-12 bg-green-600 rounded-[32px] hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-zinc-800 transition-colors duration-200"
                onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
            >
                <div class="flex self-stretch my-auto w-6 min-h-6" aria-hidden="true">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg" class="text-white">
                        <path d="M7 14L12 9L17 14" stroke="currentColor" stroke-width="2"
                              stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </button>
        </section>

        <style>
            /* Стили для меню футера */
            .filament-menu-builder-menu {
                @apply flex flex-col gap-5 items-start;
            }

            .filament-menu-builder-menu ul {
                @apply flex flex-col gap-5 items-start;
            }

            .filament-menu-builder-menu li {
                @apply flex gap-2 items-center self-stretch rounded-lg;
            }

            .filament-menu-builder-menu a {
                @apply text-base font-bold text-white max-sm:text-sm hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-zinc-900;
            }
        </style>
    </div>

</footer>
