<main class="flex flex-col px-4 py-6 max-w-7xl mx-auto">
    <!-- Breadcrumbs -->
    <nav aria-label="Breadcrumb" class="flex gap-2 items-center text-sm font-medium text-neutral-500 mb-4">
        <a href="/" class="hover:text-black transition">Головна</a>
        <span>/</span>
        <span class="text-black font-semibold">Блог</span>
    </nav>

    <!-- Title -->
    <header class="mb-6">
        <h1 class="text-3xl font-bold text-black">Блог</h1>
    </header>

    <!-- Blog Grid -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" aria-label="Статті блогу">
        @foreach ($posts as $post)
            <article class="flex flex-col overflow-hidden bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                @if($post->banner)
                    <img src="{{ asset('storage/' . $post->banner) }}"
                         alt="{{ $post->getTranslation('title', app()->getLocale()) }}"
                         class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-neutral-200 flex items-center justify-center text-neutral-500">
                        No Image
                    </div>
                @endif

                <div class="flex flex-col p-5 flex-1">
                    <time class="text-xs text-neutral-400 mb-2" datetime="{{ $post->published_at->format('Y-m-d') }}">
                        {{ $post->published_at->format('d.m.Y') }}
                    </time>

                    <h2 class="text-lg font-semibold text-zinc-800 mb-2 line-clamp-2">
                        {{ $post->getTranslation('title', app()->getLocale()) }}
                    </h2>

                    <p class="text-sm text-neutral-600 mb-4 line-clamp-3">
                        {{ $post->getTranslation('excerpt', app()->getLocale()) }}
                    </p>

                    <a href="{{ route('blog.post', $post->slug) }}"
                       class="mt-auto inline-flex items-center gap-1 text-green-600 font-medium hover:underline">
                        Читать далее
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </article>
        @endforeach
    </section>
</main>
