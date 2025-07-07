<div class="flex flex-col container mx-auto w-full max-md:max-w-full">
    <!-- Breadcrumb Navigation -->
    @include('livewire.components.breadcrumbs', ['currentPage' => __('messages.breadcrumbs.blog')])

    <!-- Tab Navigation -->
    <section class="flex flex-wrap items-start py-2 mt-2 text-sm font-bold leading-tight text-center whitespace-nowrap"
             role="tablist" aria-label="{{ __('blog.categories_aria_label') }}">
        @foreach (['all' => __('messages.blog.tab_all'), 'blog' => __('messages.blog.tab_blog'), 'articles' => __('messages.blog.tab_articles'), 'label' => __('messages.blog.tab_label')] as $key => $label)
            <div
                class="{{ $selectedCategory === $key ? 'text-green-600' : 'text-zinc-800' }} {{ $key === 'label' ? 'flex-1 shrink basis-0 min-w-60 max-md:max-w-full' : 'w-' . ($key === 'all' ? '[53px]' : ($key === 'blog' ? '[66px]' : '[77px]')) }}"
                role="presentation">
                <button
                    wire:click="setCategory('{{ $key }}')"
                    class="flex gap-2.5 {{ $key === 'label' ? 'justify-center self-center' : '' }} items-center px-4 {{ $key === 'blog' ? 'w-full' : '' }} hover:text-green-600 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 rounded"
                    role="tab"
                    aria-selected="{{ $selectedCategory === $key ? 'true' : 'false' }}"
                    tabindex="{{ $selectedCategory === $key ? '0' : '-1' }}"
                >
                    <span
                        class="self-stretch my-auto {{ $selectedCategory === $key ? 'text-green-600' : 'text-zinc-800' }}">{{ $label }}</span>
                </button>
                <div
                    class="flex mt-2 w-full {{ $selectedCategory === $key ? 'bg-green-600 rounded min-h-[3px]' : 'bg-neutral-400 min-h-px' }}"
                    aria-hidden="true"></div>
            </div>
        @endforeach
    </section>

    <!-- Page Title -->
    <h1 class="self-start mt-2 text-2xl font-bold leading-tight text-black">
        {{ __('messages.blog.title') }}
    </h1>

    <!-- Blog Cards Grid -->
    <section class="grid gap-4 w-full mt-2"
         style="grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));"
             aria-label="{{ __('blog.articles') }}">
        @forelse ($posts as $post)
            <div class="flex flex-wrap gap-2 items-center w-full">
                    <a href="{{ route('blog.post', $post->slug) }}"
                        class="overflow-hidden relative flex-1 shrink self-stretch my-auto rounded-3xl basis-0 bg-neutral-200 min-w-60">
                        <div class="overflow-hidden z-0 w-full">
                            <img
                                src="{{ $post->banner ? Storage::url($post->banner) : 'https://via.placeholder.com/300x158' }}"
                                alt="{{ $post->getTranslation('title', app()->getLocale()) }}"
                                class="object-contain w-full aspect-[1.89]"
                            />
                        </div>
                        <div class="z-0 p-4 w-full font-semibold">
                            <h2 class="text-base leading-6 text-ellipsis text-zinc-800">
                                {{ Str::limit($post->getTranslation('title', app()->getLocale()), 50) }}
                            </h2>
                            <p class="text-sm text-zinc-600 mt-2">
                                {{ Str::limit($post->getTranslation('excerpt', app()->getLocale()), 100) }}
                            </p>
                            <time class="mt-4 text-xs text-neutral-400"
                                  datetime="{{ $post->published_at ? $post->published_at->format('Y-m-d') : '' }}">
                                {{ $post->published_at ? $post->published_at->format('d.m.Y') : __('blog.no_date') }}
                            </time>
                        </div>
                        <a
                            href="{{ route('blog.post', $post->slug) }}"
                            class="flex absolute top-0 right-0 z-0 gap-2.5 justify-center items-center w-14 h-14 min-h-14 hover:bg-black hover:bg-opacity-10 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 rounded"
                            aria-label="{{ __('blog.read_full_article') }}"
                        >
                            <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M27.8039 23.6143L27.8039 8.19658L8.19714 27.8033L16.8675 19.133C20.8868 15.1137 27.7607 17.9304 27.8039 23.6143Z" fill="white"/>
                                <path d="M27.8039 8.19658L17.5254 8.19658L12.3862 8.19658C18.0731 8.21717 20.9068 15.0936 16.8856 19.1149L8.19714 27.8033L27.8039 8.19658Z" fill="white"/>
                                <path d="M27.8027 7.19672C28.3548 7.19693 28.8027 7.64463 28.8027 8.19672V28.7534C28.8027 29.3055 28.3548 29.7531 27.8027 29.7534C27.2507 29.7531 26.8038 29.3054 26.8037 28.7534L26.8027 23.6137C26.7603 18.8976 21.1435 16.5251 17.7344 19.685L17.5732 19.8403L8.90332 28.5102C8.51284 28.9007 7.87979 28.9006 7.48926 28.5102C7.12332 28.1441 7.09979 27.565 7.41992 27.1723L7.48926 27.0961L16.1777 18.4077C19.5696 15.0152 17.1791 9.21438 12.3818 9.19672H7.24609C6.69388 9.19672 6.24622 8.7489 6.24609 8.19672C6.24617 7.6445 6.69386 7.19672 7.24609 7.19672H27.8027ZM21.1689 16.2455C23.2741 16.1954 25.3478 17.053 26.8018 18.5776L26.8037 10.6108L21.1689 16.2455ZM17.4424 9.19672C18.9621 10.6475 19.8183 12.7158 19.7695 14.8159L25.3887 9.19672H17.4424Z" fill="white"/>
                            </svg>


                        </a>
                    </a>
            </div>
        @empty
            <p class="text-sm text-neutral-400 w-full text-center">{{ __('messages.blog.no_posts') }}</p>
        @endforelse
    </section>

    <!-- Pagination -->
    <nav class="flex flex-wrap gap-2 justify-center items-center pt-10 mt-2 w-full max-md:max-w-full"
         aria-label="{{ __('blog.pagination_aria_label') }}">
        @if ($posts->hasPages())
            <!-- Previous Page -->
            <button
                wire:click="previousPage"
                {{ $posts->onFirstPage() ? 'disabled' : '' }}
                class="flex gap-2.5 items-center self-stretch p-2 my-auto w-8 rounded-[32px] hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 {{ $posts->onFirstPage() ? 'opacity-50 cursor-not-allowed' : '' }}"
                aria-label="{{ __('blog.previous_page') }}"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <!-- Page Numbers -->
            @foreach ($posts->links()->elements[0] as $page => $url)
                <button
                    wire:click="gotoPage({{ $page }})"
                    class="flex gap-1 justify-center items-center self-stretch px-2 py-1.5 my-auto w-8 text-base font-semibold leading-none text-center whitespace-nowrap rounded-2xl min-h-8 {{ $posts->currentPage() === $page ? 'text-white bg-green-600' : 'text-zinc-800 hover:bg-gray-200' }} focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2"
                    aria-label="{{ __('blog.page', ['page' => $page]) }}"
                    {{ $posts->currentPage() === $page ? 'aria-current="page"' : '' }}
                >
                    <span class="self-stretch my-auto">{{ $page }}</span>
                </button>
            @endforeach

            <!-- Next Page -->
            <button
                wire:click="nextPage"
                {{ $posts->hasMorePages() ? '' : 'disabled' }}
                class="flex gap-2.5 items-center self-stretch p-2 my-auto w-8 rounded-[32px] hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 {{ $posts->hasMorePages() ? '' : 'opacity-50 cursor-not-allowed' }}"
                aria-label="{{ __('messages.blog.next_page') }}"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        @endif
    </nav>
</div>
