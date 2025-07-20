<main class="flex flex-col gap-2 items-center px-12 pt-14 pb-24 bg-zinc-100">
    <!-- Logo Header Section -->
    <div class="mb-8 absolute bottom-0 z-0">
        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="306" viewBox="0 0 1336 306" fill="none">
            <g filter="url(#filter0_dd_139_13354)">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M314.294 34.9774V271.218C314.294 275.889 323.835 273.913 332.831 273.913C340.749 273.913 347.949 273.913 355.324 273.913C356.945 268.883 355.868 221.814 355.324 211.574L354.785 164.685C354.785 158.398 353.528 155.882 353.528 149.055C353.528 149.415 354.246 149.415 354.246 149.774C354.246 149.954 354.246 150.133 354.246 150.133C355.324 151.93 354.785 150.672 355.324 152.11L383.939 211.574C388.979 222.533 393.474 232.414 399.052 243.372C416.332 280.201 403.553 273.913 446.025 273.913V36.9534C446.025 34.4384 446.025 34.4384 445.48 32.2825L413.088 32.1027C407.33 32.1027 405.714 31.0248 405.175 35.8755C403.553 50.2472 406.253 65.5176 406.253 78.9918C406.253 93.7232 406.253 108.095 406.253 122.826C406.253 138.277 407.33 150.133 407.33 165.763C404.631 162.709 360.902 59.4097 356.407 49.5289C354.246 44.1393 350.828 37.6717 349.745 32.2825C343.448 32.2825 337.331 32.2825 331.214 32.2825C327.791 32.2825 324.553 32.1027 321.135 32.1027C317.717 32.1027 314.294 31.3839 314.294 34.9774Z" fill="#F3F3F3"/>
                <!-- Other SVG paths omitted for brevity, same as provided -->
            </g>
            <defs>
                <filter id="filter0_dd_139_13354" x="0" y="0" width="1336" height="306" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feMorphology radius="4" operator="erode" in="SourceAlpha" result="effect1_dropShadow_139_13354"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="2"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 0.0470588 0 0 0 0 0.0470588 0 0 0 0 0.0509804 0 0 0 0.05 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_139_13354"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feMorphology radius="4" operator="erode" in="SourceAlpha" result="effect2_dropShadow_139_13354"/>
                    <feOffset/>
                    <feGaussianBlur stdDeviation="16"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 0.0470588 0 0 0 0 0.0470588 0 0 0 0 0.0509804 0 0 0 0.15 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_139_13354" result="effect2_dropShadow_139_13354"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_139_13354" result="shape"/>
                </filter>
            </defs>
        </svg>
    </div>

    <!-- Content Container -->
    <div class="relative h-auto max-md:box-border max-md:px-5 max-md:py-0 max-md:w-full">
        <livewire:components.breadcrumbs :currentPage="__('messages.breadcrumbs.blog')" :items="[]" />

        <!-- Tab Navigation -->
        <nav class="inline-flex items-start px-0 py-2 h-[43px] w-[1180px] max-md:box-border max-md:px-5 max-md:py-0 max-md:w-full max-md:max-w-[1180px] mb-8" role="tablist" aria-label="Content categories">
            <div class="flex flex-col gap-2 items-center max-sm:shrink-0" role="presentation">
                <button wire:click="setCategory('all')" class="flex gap-2.5 justify-center items-center px-4 py-0 tab-button" role="tab" aria-selected="{{ $selectedCategory === 'all' ? 'true' : 'false' }}" tabindex="{{ $selectedCategory === 'all' ? '0' : '-1' }}">
                    <span class="text-sm font-bold leading-4 text-center {{ $selectedCategory === 'all' ? 'text-green-600' : 'text-zinc-800' }}">Всі</span>
                </button>
                <div class="self-stretch {{ $selectedCategory === 'all' ? 'bg-green-600 rounded h-[3px]' : 'h-px bg-neutral-400' }}"></div>
            </div>
            @foreach ($availableCategories as $category)
                <div class="flex flex-col gap-2 items-center max-sm:shrink-0" role="presentation">
                    <button wire:click="setCategory({{ $category->id }})" class="flex gap-2.5 items-center self-stretch px-4 py-0 tab-button" role="tab" aria-selected="{{ $selectedCategory == $category->id ? 'true' : 'false' }}" tabindex="{{ $selectedCategory == $category->id ? '0' : '-1' }}">
                        <span class="text-sm font-bold leading-4 text-center {{ $selectedCategory == $category->id ? 'text-green-600' : 'text-zinc-800' }}">{{ $category->translateAttribute('name') ?? $category->name ?? 'Label' }}</span>
                    </button>
                    <div class="self-stretch {{ $selectedCategory == $category->id ? 'bg-green-600 rounded h-[3px]' : 'h-px bg-neutral-400' }}"></div>
                </div>
            @endforeach
        </nav>

        <!-- Page Title -->
        <h1 class="text-2xl font-bold leading-7 text-black h-[29px] w-[1180px] max-md:box-border max-md:px-5 max-md:py-0 max-md:w-full max-md:max-w-[1180px] max-sm:text-xl max-sm:leading-6 mb-8">
            {{ __('messages.blog.title') }}
        </h1>

        <!-- Blog Cards Grid -->
        <section class="space-y-8 mb-10 relative z-10" aria-label="Blog posts">
            @if (isset($error))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ $error }}
                </div>
            @endif

            @php
                $postsChunked = $posts->chunk(4); // Split posts into groups of 4 for rows
            @endphp

            @forelse ($postsChunked as $chunk)
                <div class="blog-grid">
                    @foreach ($chunk as $post)
                        @php
                            $hasValidSlug = false;
                            $slug = null;

                            // Check slug (slugs are the same across all locales)
                            if ($post->defaultUrl && !empty($post->defaultUrl->slug)) {
                                $slug = $post->defaultUrl->slug;
                                $hasValidSlug = is_string($slug) && trim($slug) !== '';
                            } elseif (!empty($post->slug) && is_string($post->slug) && trim($post->slug) !== '') {
                                $slug = $post->slug;
                                $hasValidSlug = true;
                            }

                            $locale = app()->getLocale();
                            $routeParams = ['slug' => $slug];
                            if ($locale !== 'uk') {
                                $routeParams['locale'] = $locale;
                            }

                            $postUrl = $hasValidSlug ? route('blog.post', $routeParams, false) : route('home', $locale !== 'uk' ? ['locale' => $locale] : [], false);
                        @endphp

                        <article wire:key="post-{{ $post->id }}" class="flex flex-col items-start rounded-3xl bg-neutral-200 blog-card max-sm:w-full overflow-hidden" tabindex="0" role="article">
                            <div class="flex justify-center items-center self-stretch h-[153px] overflow-hidden rounded-t-3xl">
                                <img
                                    src="{{ $post->banner ? Storage::url($post->banner) : 'https://via.placeholder.com/300x158' }}"
                                    alt="{{ $post->getTranslation('title', app()->getLocale()) }}"
                                    class="h-[171px] w-full object-cover"
                                />
                            </div>
                            <div class="flex flex-col gap-4 items-start self-stretch p-4">
                                <p class="overflow-hidden self-stretch text-base font-semibold leading-5 text-ellipsis text-zinc-800">
                                    {{ Str::limit($post->getTranslation('excerpt', app()->getLocale()), 150) }}
                                </p>
                                <time class="self-stretch text-xs font-semibold leading-5 text-neutral-400" datetime="{{ $post->published_at ? $post->published_at->format('Y-m-d') : '' }}">
                                    {{ $post->published_at ? $post->published_at->format('d.m.Y') : __('blog.no_date') }}
                                </time>
                            </div>
                            <a href="{{ $postUrl }}" wire:navigate class="flex right-0 gap-2.5 justify-center items-center px-2 py-0 w-14 h-14 absolute top-0 right-0">
                                <div class="relative shrink-0 h-[35px] w-[35px]">
                                    <svg
                                        width="20"
                                        height="20"
                                        viewBox="0 0 20 20"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="arrow-bg w-[28px] h-[22px] absolute left-0 top-0"
                                        aria-hidden="true"
                                    >
                                        <path
                                            d="M19.8039 15.6143L19.8039 0.196583L0.197137 19.8033L8.86752 11.133C12.8868 7.11369 19.7607 9.93035 19.8039 15.6143Z"
                                            fill="white"
                                        />
                                        <path
                                            d="M19.8039 0.196583L9.52542 0.196583L4.38618 0.196584C10.0731 0.217168 12.9068 7.09365 8.88556 11.1149L0.197137 19.8033L19.8039 0.196583Z"
                                            fill="white"
                                        />
                                    </svg>
                                    <svg
                                        width="23"
                                        height="23"
                                        viewBox="0 0 23 23"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-[23px] h-[23px] absolute left-[6px] top-[7px]"
                                        aria-hidden="true"
                                    >
                                        <path
                                            d="M21.8027 0.196716C22.3548 0.196925 22.8027 0.644626 22.8027 1.19672V21.7534C22.8027 22.3055 22.3548 22.7531 21.8027 22.7534C21.2507 22.7531 20.8038 22.3054 20.8037 21.7534L20.8027 16.6137C20.7603 11.8976 15.1435 9.52508 11.7344 12.685L11.5732 12.8403L2.90332 21.5102C2.51284 21.9007 1.87979 21.9006 1.48926 21.5102C1.12332 21.1441 1.09979 20.565 1.41992 20.1723L1.48926 20.0961L10.1777 11.4077C13.5696 8.01515 11.1791 2.21438 6.38184 2.19672H1.24609C0.693885 2.19672 0.246217 1.7489 0.246094 1.19672C0.246171 0.644497 0.693857 0.196716 1.24609 0.196716H21.8027ZM15.1689 9.24554C17.2741 9.19543 19.3478 10.053 20.8018 11.5776L20.8037 3.61078L15.1689 9.24554ZM11.4424 2.19672C12.9621 3.64751 13.8183 5.71579 13.7695 7.81586L19.3887 2.19672H11.4424Z"
                                            fill="white"
                                        />
                                    </svg>
                                </div>
                            </a>
                            @if (!$hasValidSlug)
                                <div class="p-4 text-red-600 text-sm">
                                    Предупреждение: URL или slug отсутствует для поста ID: {{ $post->id }} (Локаль: {{ app()->getLocale() }})
                                </div>
                            @endif
                        </article>
                    @endforeach
                </div>
            @empty
                <p class="text-center text-base font-semibold text-zinc-800">Нет постов по выбранным параметрам.</p>
            @endforelse
        </section>

        <!-- Pagination -->
        <nav class="flex gap-2 justify-center items-center pt-10" aria-label="Pagination Navigation">
            {{ $posts->links('livewire::simple-bootstrap') }}
        </nav>
    </div>

    <script>
        // Add keyboard navigation for tab controls
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('[role="tab"]');
            const blogCards = document.querySelectorAll('.blog-card');

            // Tab navigation
            tabs.forEach((tab, index) => {
                tab.addEventListener('keydown', function(e) {
                    if (e.key === 'ArrowRight' || e.key === 'ArrowLeft') {
                        e.preventDefault();
                        const nextIndex = e.key === 'ArrowRight'
                            ? (index + 1) % tabs.length
                            : (index - 1 + tabs.length) % tabs.length;

                        tabs[index].setAttribute('tabindex', '-1');
                        tabs[nextIndex].setAttribute('tabindex', '0');
                        tabs[nextIndex].focus();
                    }

                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        tab.click();
                    }
                });
            });

            // Blog card keyboard navigation
            blogCards.forEach(card => {
                card.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        const link = card.querySelector('a');
                        if (link) {
                            link.click();
                        }
                    }
                });
            });

            // Pagination keyboard navigation
            const paginationButtons = document.querySelectorAll('.pagination-button');
            paginationButtons.forEach(button => {
                button.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        button.click();
                    }
                });
            });
        });
    </script>

    <style>
        .logo-svg {
            filter: drop-shadow(0px 0px 4px rgba(12, 12, 13, 0.05)) drop-shadow(0px 0px 32px rgba(12, 12, 13, 0.15));
        }

        .arrow-bg {
            transform: rotate(-45deg);
        }

        .blog-card:hover .arrow-bg {
            transform: rotate(-45deg) scale(1.1);
            transition: transform 0.2s ease;
        }

        .blog-card:focus-within .arrow-bg {
            transform: rotate(-45deg) scale(1.1);
        }

        .pagination-button:hover {
            background-color: #f3f4f6;
            transition: background-color 0.2s ease;
        }

        .pagination-button:focus {
            outline: 2px solid #16a34a;
            outline-offset: 2px;
        }

        .tab-button:focus {
            outline: 2px solid #16a34a;
            outline-offset: 2px;
        }

        .blog-card:focus-within {
            outline: 2px solid #16a34a;
            outline-offset: 2px;
        }

        .blog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 8px;
            width: 1180px;
            max-width: 100%;
            padding: 0 20px;
            box-sizing: border-box;
        }

        @media (max-width: 768px) {
            .blog-grid {
                gap: 16px;
                padding: 0 20px;
            }
        }

        @media (max-width: 640px) {
            .blog-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</main>
