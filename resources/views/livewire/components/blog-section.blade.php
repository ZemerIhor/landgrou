<section class="flex  mx-auto flex-col self-stretch px-12 py-12 container relative" role="main" aria-labelledby="blog-heading">
    <h1 id="blog-heading" class="text-2xl font-bold leading-tight text-zinc-800 max-md:max-w-full">
        {{ __('messages.blog.title') }}
    </h1>

    <div class="flex flex-wrap gap-2 items-center mt-5 w-full min-h-[307px] max-md:max-w-full" role="region" aria-label="{{ __('blog.articles') }}">
        @forelse ($blogPosts->take(4) as $post)
            <a href="{{ route('blog.post', $post->slug) }}" class="block overflow-hidden relative flex-1 shrink self-stretch my-auto rounded-3xl basis-0 bg-neutral-200 min-w-60 hover:shadow-lg transition-shadow" aria-label="{{ __('blog.read_article', ['title' => $post->getTranslation('title', app()->getLocale())]) }}">
                <article class="overflow-hidden" role="article">
                    <div class="overflow-hidden z-0 w-full">
                        <img
                            src="{{ $post->banner ? Storage::url($post->banner) : 'https://via.placeholder.com/300x158' }}"
                            alt="{{ $post->getTranslation('title', app()->getLocale()) }}"
                            class="object-contain w-full"
                            loading="lazy"
                        />
                    </div>
                    <div class="z-0 p-4 w-full font-semibold">
                        <h2 class="text-base leading-6 text-ellipsis text-zinc-800">
                            {{ Str::limit($post->getTranslation('title', app()->getLocale()), 50) }}
                        </h2>
                        <p class="text-sm text-zinc-600 mt-2">
                            {{ Str::limit($post->getTranslation('excerpt', app()->getLocale()), 100) }}
                        </p>
                        <time class="mt-4 text-xs text-neutral-400" datetime="{{ $post->published_at->format('Y-m-d') }}">
                            {{ $post->published_at->format('d.m.Y') }}
                        </time>
                    </div>
                    <div class="flex absolute top-0 right-0 z-0 gap-2.5 justify-center items-center w-14 h-14 min-h-14" aria-hidden="true">
                    </div>
                </article>
            </a>
        @empty
            <p class="text-sm text-neutral-400 w-full text-center">{{ __('messages.blog.no_posts') }}</p>
        @endforelse
    </div>

    @if ($blogPosts->count() > 0)
        <a
            href="{{ route('blog.index') }}"
            class="flex gap-2 justify-center items-center self-center px-6 py-2.5 mt-5 text-base font-bold leading-snug text-green-600 whitespace-nowrap rounded-2xl border-2 border-green-600 border-solid min-h-11 max-md:px-5 hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 transition-colors"
            aria-label="{{ __('messages.blog.read_more') }}"
        >
            <span class="self-stretch my-auto text-green-600">
                {{ __('messages.blog.more_button') }}
            </span>
            <img
                src="https://cdn.builder.io/api/v1/image/assets/bdb2240bae064d82b869b3fcebf2733a/36db99e17e88cc88a207dbd4e62c4e8a3518a4bf?placeholderIfAbsent=true"
                alt=""
                class="object-contain shrink-0 self-stretch my-auto w-6 aspect-square"
                aria-hidden="true"
            />
        </a>
    @endif
</section>
