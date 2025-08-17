{{-- resources/views/livewire/components/language-switcher.blade.php --}}
<div class="relative" x-data="{ desktopLanguageMenu: false }">
    <button
        x-on:click="desktopLanguageMenu = !desktopLanguageMenu"
        class="flex items-center gap-1 text-sm font-semibold text-zinc-800 hover:text-green-600 focus:outline-none focus:ring-2 focus:ring-green-600"
        aria-label="{{ __('messages.language.current') }}"
        :aria-expanded="desktopLanguageMenu"
    >
        <span class="uppercase">{{ $currentLocale }}</span>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <div
        x-show="desktopLanguageMenu"
        x-transition
        x-cloak
        class="absolute right-0 mt-2 w-32 bg-white shadow-lg rounded-md z-50"
        x-on:click.away="desktopLanguageMenu = false"
    >
        @foreach($availableLocales as $locale)
            @if($locale !== $currentLocale)
                <button
                    wire:click="switchLanguage('{{ $locale }}')"
                    class="block w-full text-left px-4 py-2 text-sm text-zinc-800 hover:bg-green-600 hover:text-white transition-colors"
                    wire:loading.attr="disabled"
                    wire:target="switchLanguage('{{ $locale }}')"
                >
                    <span wire:loading.remove wire:target="switchLanguage('{{ $locale }}')">
                        {{ $locale === 'en' ? __('messages.language.english') : __('messages.language.ukraine') }}
                    </span>
                    <span wire:loading wire:target="switchLanguage('{{ $locale }}')" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        {{ __('messages.loading') }}
                    </span>
                </button>
            @endif
        @endforeach
    </div>

    {{-- JavaScript для обработки событий --}}
    <script>
        document.addEventListener('livewire:initialized', () => {
            // Обработка успешного переключения языка
            Livewire.on('language-switched', (event) => {
                // Обрабатываем данные события (массив или объект)
                const data = Array.isArray(event) ? event[0] : event;
                console.log('Language switched:', data);

                // Обновляем URL в браузере
                if (data.url) {
                    // Используем Livewire.navigate для всех страниц
                    Livewire.navigate(data.url);
                }

                // Показываем уведомление (опционально)
                if (window.showToast) {
                    window.showToast('{{ __("messages.language.switched") }}', 'success');
                }
            });

            // Обработка ошибок
            Livewire.on('language-error', (event) => {
                const message = Array.isArray(event) ? event[0] : event;
                console.error('Language switch error:', message);

                if (window.showToast) {
                    window.showToast(message, 'error');
                } else {
                    alert(message);
                }
            });
        });
    </script>
</div>
