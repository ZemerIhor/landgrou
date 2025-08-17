<!-- resources/views/livewire/components/language-switcher.blade.php -->
<div class="language-switcher flex gap-2 items-center" wire:loading.class="language-loading">
    @foreach ($availableLocales as $locale)
        <button
            wire:click="switchLanguage('{{ $locale }}')"
            class="{{ $currentLocale === $locale ? 'font-bold text-green-600' : 'text-gray-600 hover:text-green-600' }} px-2 py-1 text-sm font-semibold transition-colors duration-200"
            aria-label="{{ __('messages.language.switch_to', ['locale' => strtoupper($locale)]) }}"
        >
            {{ strtoupper($locale) }}
        </button>
    @endforeach
</div>
