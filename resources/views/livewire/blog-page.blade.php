<main class="container mx-auto self-stretch pb-14 px-4 md:px-12 max-md:px-5 blog-page">
    <!-- Breadcrumbs Navigation -->
    <livewire:components.breadcrumbs :currentPage="__('messages.breadcrumbs.blog')" :items="[]" />

    <!-- Page Title -->
    <header>
        <h1 class="text-2xl font-bold leading-tight text-black max-md:max-w-full">
            {{ __('messages.blog.title') }}
        </h1>
    </header>

    <!-- Filter Controls and Results Count -->
    <section class="flex flex-wrap gap-2 items-center w-full min-h-10 max-md:max-w-full" aria-label="Фильтры и сортировка">
        <!-- Results Count -->
        <div class="flex gap-1 items-center self-stretch my-auto text-xs font-semibold text-black whitespace-nowrap">
            <span class="self-stretch my-auto">{{ __('Найдено') }}</span>
            <span class="self-stretch my-auto">{{ $posts->total() }}</span>
            <span class="self-stretch my-auto">{{ __('постов') }}</span>
        </div>

        <!-- Active Filter Tags -->
        <div class="flex flex-wrap flex-1 shrink gap-0.5 items-center self-stretch my-auto text-xs font-bold leading-tight text-white basis-8 min-w-60 max-md:max-w-full" role="group" aria-label="Активные фильтры">
            @if (!empty($categories))
                @foreach ($categories as $categoryId)
                    @if ($category = $availableCategories->find($categoryId))
                        <button wire:click="removeCategory({{ $categoryId }})" class="flex gap-1 items-center self-stretch pr-2 pl-3 my-auto whitespace-nowrap rounded-2xl bg-neutral-400 min-h-10 hover:bg-neutral-500 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2" aria-label="Удалить фильтр: {{ $category->translateAttribute('name') ?? $category->name ?? '' }}">
                            <span class="self-stretch my-auto text-white">{{ $category->translateAttribute('name') ?? $category->name ?? '' }}</span>
                            <img src="https://cdn.builder.io/api/v1/image/assets/bdb2240bae064d82b869b3fcebf2733a/ba94ac2e61738f897029abe123360249f0f65ef9?placeholderIfAbsent=true" class="object-contain shrink-0 self-stretch my-auto w-6 aspect-square" alt="Удалить фильтр" />
                        </button>
                    @endif
                @endforeach
            @endif

        </div>

        <!-- Sort Dropdown -->
        <div class="relative">
            <select wire:model.live="sort" class="flex gap-4 items-center self-stretch px-4 my-auto text-sm font-bold leading-tight rounded-2xl bg-neutral-200 min-h-10 text-zinc-800 w-[180px] hover:bg-neutral-300 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2" aria-label="Сортировка">
                <option value="title_asc">{{ __('Название А-Я') }}</option>
                <option value="title_desc">{{ __('Название Я-А') }}</option>
                <option value="date_asc">{{ __('Дата: старая к новой') }}</option>
                <option value="date_desc">{{ __('Дата: новая к старой') }}</option>
            </select>
        </div>

        <!-- View Toggle -->
        <div class="flex gap-1 items-center self-stretch p-1 my-auto rounded-2xl bg-neutral-200 min-h-10" role="group" aria-label="Вид отображения">
            <button wire:click="setView('grid')" class="flex gap-2.5 items-center self-stretch p-1 my-auto w-8 rounded-xl hover:bg-neutral-300 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2" aria-label="Вид сетки" aria-pressed="{{ $view === 'grid' ? 'true' : 'false' }}">
                <div class="flex self-stretch my-auto w-6 min-h-6" aria-hidden="true">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-view {{ $view === 'grid' ? 'icon-active' : '' }}">
                        <path d="M22 8.52V3.98C22 2.57 21.36 2 19.77 2H15.73C14.14 2 13.5 2.57 13.5 3.98V8.51C13.5 9.93 14.14 10.49 15.73 10.49H19.77C21.36 10.5 22 9.93 22 8.52Z" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M22 19.77V15.73C22 14.14 21.36 13.5 19.77 13.5H15.73C14.14 13.5 13.5 14.14 13.5 15.73V19.77C13.5 21.36 14.14 22 15.73 22H19.77C21.36 22 22 21.36 22 19.77Z" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10.5 8.52V3.98C10.5 2.57 9.86 2 8.27 2H4.23C2.64 2 2 2.57 2 3.98V8.51C2 9.93 2.64 10.49 4.23 10.49H8.27C9.86 10.5 10.5 9.93 10.5 8.52Z" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10.5 19.77V15.73C10.5 14.14 9.86 13.5 8.27 13.5H4.23C2.64 13.5 2 14.14 2 15.73V19.77C2 21.36 2.64 22 4.23 22H8.27C9.86 22 10.5 21.36 10.5 19.77Z" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </button>
            <button wire:click="setView('list')" class="flex gap-2.5 items-center self-stretch p-1 my-auto w-8 rounded-xl hover:bg-neutral-300 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2" aria-label="Вид списка" aria-pressed="{{ $view === 'list' ? 'true' : 'false' }}">
                <div class="flex self-stretch my-auto w-6 min-h-6" aria-hidden="true">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-view {{ $view === 'list' ? 'icon-active' : '' }}">
                        <path d="M19.9 13.5H4.1C2.6 13.5 2 14.14 2 15.73V19.77C2 21.36 2.6 22 4.1 22H19.9C21.4 22 22 21.36 22 19.77V15.73C22 14.14 21.4 13.5 19.9 13.5Z" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M19.9 2H4.1C2.6 2 2 2.64 2 4.23V8.27C2 9.86 2.6 10.5 4.1 10.5H19.9C21.4 10.5 22 9.86 22 8.27V4.23C22 2.64 21.4 2 19.9 2Z" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </button>
        </div>
    </section>

    <!-- Main Content Area -->
    <div class="flex flex-wrap gap-2 items-start justify-center pt-2 w-full max-md:max-w-full">
        <!-- Filters Sidebar -->
        <aside class="rounded-3xl bg-neutral-200 min-w-60 w-[289px]" aria-label="Фильтры постов">
            <!-- Category Filter -->
            <section class="w-full rounded-2xl text-zinc-800">
                <button class="flex gap-4 items-center px-4 w-full text-sm font-bold leading-tight rounded-2xl bg-neutral-200 min-h-10 hover:bg-neutral-300 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2" aria-expanded="true" aria-controls="category-options">
                    <span class="flex-1 shrink self-stretch my-auto basis-0 text-zinc-800">{{ __('Категория') }}</span>
                    <div class="flex shrink-0 self-stretch my-auto w-4 h-4 rotate-[-3.1415925661670165rad]" aria-hidden="true"></div>
                </button>
                <div id="category-options" class="flex items-start pr-0.5 pb-2 w-full text-xs font-semibold whitespace-nowrap rounded-2xl bg-neutral-200">
                    <fieldset class="flex-1 shrink w-full basis-0 min-w-60">
                        <legend class="sr-only">{{ __('Категория') }}</legend>
                        @foreach ($availableCategories as $category)
                            <div class="flex gap-2 items-center px-4 py-2 w-full min-h-10">
                                <input type="checkbox" id="category-{{ $category->id }}" wire:model.debounce.500ms="categories" value="{{ $category->id }}" class="w-6 h-6 text-green-600 bg-white border-neutral-400 rounded focus:ring-green-500 focus:ring-2" />
                                <label for="category-{{ $category->id }}" class="flex-1 shrink self-stretch my-auto basis-0 text-zinc-800 cursor-pointer">{{ $category->translateAttribute('name') ?? $category->name ?? '' }}</label>
                            </div>
                        @endforeach
                    </fieldset>
                </div>
            </section>

            <!-- Separator -->
            <div class="px-4 w-full">
                <hr class="w-full rounded-sm bg-zinc-300 min-h-px border-0" />
            </div>

            <!-- Date Filter -->


            <!-- Separator -->
            <div class="px-4 w-full">
                <hr class="w-full rounded-sm bg-zinc-300 min-h-px border-0" />
            </div>

            <!-- Apply Button -->
            <div class="flex gap-2 items-start p-4 w-full text-base font-bold leading-snug text-green-600 whitespace-nowrap">
                <button wire:click="applyFilters" class="flex flex-1 shrink gap-2 justify-center items-center px-6 py-2.5 w-full rounded-2xl border-2 border-green-600 border-solid basis-0 min-h-11 min-w-60 max-md:px-5 hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2">
                    <span class="self-stretch my-auto text-green-600">{{ __('Применить') }}</span>
                </button>
            </div>
        </aside>

        <!-- Blog Posts Grid -->
        <section class="flex-1 shrink basis-0 min-w-60 max-md:max-w-full" aria-label="Список постов">
            @if (isset($error))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ $error }}
                </div>
            @endif

            <!-- Grid or List view based on $view -->
            <div class="{{ $view == 'grid' ? 'blog-grid' : 'blog-list' }} blog-page-grid">
                @forelse ($posts as $post)
                    @php
                        $hasValidSlug = false;
                        $slug = null;

                        // Проверка slug
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

                    <article wire:key="post-{{ $post->id }}" class="overflow-hidden post-card flex-1 shrink self-stretch my-auto rounded-3xl basis-0 bg-neutral-200 {{ $view == 'grid' ? 'lg:h-[378px] sm:h-[389px]' : '' }}" role="listitem">
                        <div class="flex flex-col justify-between group h-full">
                            <a href="{{ $postUrl }}" wire:navigate class="flex flex-col h-full">
                                <div class="flex relative flex-col w-full">
                                    <div class="flex overflow-hidden flex-col max-w-full w-full">
                                        <img
                                            src="{{ $post->banner ? Storage::url($post->banner) : 'https://via.placeholder.com/300x158' }}"
                                            alt="{{ $post->getTranslation('title', app()->getLocale()) }}"
                                            class="object-cover w-full aspect-[1.77] transition-transform duration-300 group-hover:scale-105"
                                        />
                                    </div>
                                    <div class="absolute top-0 right-0 flex z-0 pt-2 pr-2" aria-hidden="true">
                                        <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M27.8029 23.6143L27.8029 8.19658L8.19616 27.8033L16.8665 19.133C20.8858 15.1137 27.7597 17.9304 27.8029 23.6143Z" fill="white"/>
                                            <path d="M27.8029 8.19658L17.5244 8.19658L12.3852 8.19658C18.0721 8.21717 20.9059 15.0936 16.8846 19.1149L8.19616 27.8033L27.8029 8.19658Z" fill="white"/>
                                            <path d="M27.8027 7.19672C28.3548 7.19693 28.8027 7.64463 28.8027 8.19672V28.7534C28.8027 29.3055 28.3548 29.7531 27.8027 29.7534C27.2507 29.7531 26.8038 29.3054 26.8037 28.7534L26.8027 23.6137C26.7603 18.8976 21.1435 16.5251 17.7344 19.685L17.5732 19.8403L8.90332 28.5102C8.51284 28.9007 7.87979 28.9006 7.48926 28.5102C7.12332 28.1441 7.09979 27.565 7.41992 27.1723L7.48926 27.0961L16.1777 18.4077C19.5696 15.0152 17.1791 9.21438 12.3818 9.19672H7.24609C6.69388 9.19672 6.24622 8.7489 6.24609 8.19672C6.24617 7.6445 6.69386 7.19672 7.24609 7.19672H27.8027ZM21.1689 16.2455C23.2741 16.1954 25.3478 17.053 26.8018 18.5776L26.8037 10.6108L21.1689 16.2455ZM17.4424 9.19672C18.9621 10.6475 19.8183 12.7158 19.7695 14.8159L25.3887 9.19672H17.4424Z" fill="white"/>
                                        </svg>
                                    </div>
                                </div>

                                <div class="p-4 w-full">
                                    <div class="w-full text-zinc-800">
                                        <h2 class="text-base font-bold leading-5 text-zinc-800">{{ Str::limit($post->getTranslation('title', app()->getLocale()), 50) }}</h2>
                                        <p class="mt-3 text-xs font-semibold leading-5 text-zinc-800">{{ Str::limit($post->getTranslation('excerpt', app()->getLocale()), 100) }}</p>
                                        <time class="mt-1 text-xs text-neutral-400" datetime="{{ $post->published_at ? $post->published_at->format('Y-m-d') : '' }}">
                                            {{ $post->published_at ? $post->published_at->format('d.m.Y') : __('blog.no_date') }}
                                        </time>
                                    </div>
                                </div>
                            </a>
                        </div>

                        @if (!$hasValidSlug)
                            <div class="p-4 text-red-600 text-sm">
                                Предупреждение: URL или slug отсутствует для поста ID: {{ $post->id }} (Локаль: {{ app()->getLocale() }})
                                @dump($post->defaultUrl?->toArray())
                                @dump($post->slug)
                            </div>
                        @endif
                    </article>
                @empty
                    <p>{{ __('Нет постов по выбранным параметрам.') }}</p>
                @endforelse
            </div>

            <!-- Pagination -->
            <nav class="flex flex-wrap gap-2 justify-center items-center pt-10 w-full max-md:max-w-full" aria-label="Навигация по страницам">
                {{ $posts->links() }}
            </nav>
        </section>
    </div>


    <style>
        /* Стили для сетки и списка */
        .blog-grid {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        }

        .blog-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .blog-list .post-card {
            display: flex;
            flex-direction: row;
            align-items: center;
            min-height: 150px;
        }

        .blog-list .post-card img {
            width: 150px;
            height: auto;
            object-fit: cover;
            margin-right: 1rem;
        }

        /* Стили для SVG-иконок в переключателе вида */
        .icon-view {
            stroke: #333333;
        }

        button[aria-pressed="true"] .icon-view {
            stroke: #16a34a;
        }

        button:hover .icon-view {
            stroke: #16a34a;
        }
    </style>
</main>
