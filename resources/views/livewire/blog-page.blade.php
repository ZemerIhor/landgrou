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
                    <article
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
                        ></a>
                    </article>
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
</section>
