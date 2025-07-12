
<div class="container mx-auto px-[50px] py-[80p ">
    <!-- Form Block -->
    <main class="flex flex-wrap gap-2 justify-center p-4">
        <section class="flex relative flex-col flex-1 shrink justify-center self-start px-20 rounded-3xl basis-0 bg-neutral-200 min-h-[570px] min-w-60 max-md:px-5 max-md:max-w-full" role="form" aria-labelledby="form-title">
            <button type="button" class="flex absolute top-0 right-0 z-10 flex-col justify-center items-center self-start p-8 max-md:px-5" aria-label="Закрити форму">
                <img src="https://cdn.builder.io/api/v1/image/assets/bdb2240bae064d82b869b3fcebf2733a/ab93e5bbfd42aa72173a49be339c395bfb6e1ec3?placeholderIfAbsent=true" alt="Закрити" class="object-contain w-6 aspect-square" />
            </button>

            <header class="z-0 w-full text-zinc-800 max-md:max-w-full">
                <h1 id="form-title" class="text-xl font-bold leading-tight text-zinc-800 max-md:max-w-full">
                    Форма зворотнього зв'язку
                </h1>
                <p class="mt-3 text-base font-semibold leading-none text-zinc-800 max-md:max-w-full">
                    Заповніть поля
                </p>
            </header>

            <form wire:submit="submit" class="z-0 mt-10 w-full max-md:max-w-full" aria-labelledby="form-title" novalidate>
                <fieldset class="border-0 p-0 m-0">
                    <legend class="sr-only">{{ __('messages.feedback_form.contact_info') }}</legend>

                    <div class="mb-4">
                        <label for="name" class="sr-only">{{ __('messages.feedback_form.name_placeholder') }}</label>
                        <input
                            type="text"
                            id="name"
                            wire:model="name"
                            placeholder="{{ __('messages.feedback_form.name_placeholder') }}"
                            required
                            aria-required="true"
                            class="flex overflow-hidden gap-2 items-center px-4 py-3.5 w-full rounded-2xl border border-solid border-neutral-400 min-h-12 max-md:max-w-full text-base font-semibold leading-none text-neutral-400 bg-transparent focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 @error('name') border-red-500 @enderror"
                        />
                        @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="sr-only">{{ __('messages.feedback_form.phone_placeholder') }}</label>
                        <input
                            type="tel"
                            id="phone"
                            wire:model="phone"
                            placeholder="{{ __('messages.feedback_form.phone_placeholder') }}"
                            required
                            aria-required="true"
                            class="flex overflow-hidden gap-2 items-center px-4 py-3.5 w-full rounded-2xl border border-solid border-neutral-400 min-h-12 max-md:max-w-full text-base font-semibold leading-none text-neutral-400 bg-transparent focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 @error('phone') border-red-500 @enderror"
                        />
                        @error('phone') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="comment" class="sr-only">{{ __('messages.feedback_form.comment_label') }}</label>
                        <div class="flex flex-col px-4 py-3 w-full leading-6 rounded-2xl border border-solid border-neutral-400 max-md:max-w-full relative focus-within:ring-2 focus-within:ring-green-600 focus-within:border-green-600 @error('comment') border-red-500 @enderror">
                        <textarea
                            id="comment"
                            wire:model="comment"
                            placeholder="{{ __('messages.feedback_form.comment_placeholder') }}"
                            rows="4"
                            class="text-neutral-400 text-base font-semibold bg-transparent border-0 outline-none resize-none focus:ring-0 p-0"
                            aria-required="true"
                            aria-describedby="comment-help"
                        ></textarea>
                            <img src="https://cdn.builder.io/api/v1/image/assets/bdb2240bae064d82b869b3fcebf2733a/ce6cffb288cbd7b018b1dadae4b444f45d8bcd95?placeholderIfAbsent=true" alt="" class="object-contain self-end w-6 aspect-square mt-2" aria-hidden="true" />
                            <div id="comment-help" class="sr-only">{{ __('messages.feedback_form.comment_help') }}</div>
                        </div>
                        @error('comment') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                </fieldset>

                <div class="flex z-0 flex-col mt-10 w-full max-md:max-w-full">
                    <div class="flex gap-2 items-center self-start text-xs mb-4">
                        <div class="relative">
                            <input
                                type="checkbox"
                                id="privacy-agreement"
                                wire:model="privacyAgreement"
                                required
                                aria-required="true"
                                aria-describedby="privacy-text"
                                class="sr-only peer"
                            />
                            <label
                                for="privacy-agreement"
                                class="flex shrink-0 w-6 h-6 rounded border-solid border-[1.5px] border-neutral-400 cursor-pointer peer-checked:bg-green-600 peer-checked:border-green-600 peer-focus:ring-2 peer-focus:ring-green-600 peer-focus:ring-offset-2 relative"
                                aria-label="{{ __('messages.feedback_form.privacy_agreement') }}"
                            >
                                <svg class="w-4 h-4 text-white absolute top-0.5 left-0.5 hidden peer-checked:block" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </label>
                        </div>
                        <div id="privacy-text" class="flex gap-0.5 items-start min-w-60">
                            <span class="font-semibold text-zinc-800">{{ __('messages.feedback_form.privacy_agreement') }}</span>
                            <a
                                href="{{ route('terms') }}"
                                class="text-indigo-500 underline decoration-auto decoration-solid underline-offset-auto rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                aria-label="{{ __('messages.feedback_form.privacy_policy_link') }}"
                            >
                                {{ __('messages.feedback_form.privacy_policy_link') }}
                            </a>
                        </div>
                        @error('privacyAgreement') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex gap-4 items-center w-full text-base font-bold leading-snug whitespace-nowrap max-md:max-w-full">
                        <button
                            type="button"
                            wire:click="goBack"
                            class="flex gap-2 justify-center items-center self-stretch px-6 py-2.5 my-auto text-green-600 rounded-2xl border-2 border-green-600 border-solid min-h-11 max-md:px-5 hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 transition-colors"
                            aria-label="{{ __('messages.feedback_form.back_button') }}"
                        >
                            <span class="self-stretch my-auto text-green-600">{{ __('messages.feedback_form.back_button') }}</span>
                        </button>
                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            x-bind:disabled="!$wire.name || !$wire.phone || !$wire.comment || !$wire.privacyAgreement"
                            class="flex gap-2 justify-center items-center self-stretch px-6 py-2.5 my-auto text-white bg-green-600 rounded-2xl min-h-11 max-md:px-5 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                            aria-label="{{ __('messages.feedback_form.submit_button') }}"
                        >
                            <span wire:loading.remove>{{ __('messages.feedback_form.submit_button') }}</span>
                            <span wire:loading>{{ __('messages.feedback_form.submit_loading') }}</span>
                        </button>
                    </div>
                </div>
            </form>
        </section>

        <aside class="flex-1 shrink basis-40 min-w-60 max-md:max-w-full" aria-label="{{ __('messages.feedback_form.image_aria_label') }}">
            @if ($settings['feedback_form_image'])
                <img
                    src="{{ $settings['feedback_form_image'] }}"
                    alt="{{ __('messages.feedback_form.image_alt') }}"
                    class="object-contain w-full rounded-3xl aspect-[1.03]"
                />
            @else
                <p>{{ __('messages.feedback_form.no_image') }}</p>
            @endif
        </aside>
    </main>
    <div x-show="$wire.state === 'success' || $wire.state === 'error'" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50" x-cloak></div>

    <!-- Success Modal -->
    <section
        x-show="$wire.state === 'success'"
        class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 flex flex-col gap-10 items-center p-20 rounded-3xl bg-neutral-200 w-[600px] max-md:p-16 max-md:w-[500px] max-sm:px-5 max-sm:py-10 max-sm:w-full max-sm:max-w-[400px] z-50"
        role="dialog"
        aria-labelledby="success-title"
        aria-describedby="success-description"
        aria-live="polite"
        x-cloak
    >
        <button
            wire:click="continueFromSuccess"
            class="flex absolute top-0 right-0 flex-col gap-2.5 justify-center items-center p-8 cursor-pointer max-sm:p-4 hover:bg-black hover:bg-opacity-5 rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500"
            aria-label="{{ __('messages.feedback_form.close_button_aria_label') }}"
        >
            @include('components.close-button-svg')
        </button>

        <div aria-hidden="true">
            <svg width="86" height="86" viewBox="0 0 86 86" fill="none" xmlns="http://www.w3.org/2000/svg" class="success-icon" style="width: 66px; height: 66px">
                <g filter="url(#filter0_d_124_11283)">
                    <rect x="10" y="10" width="66" height="66" rx="32" fill="#008CFF"></rect>
                    <rect x="13" y="13" width="60" height="60" rx="29" stroke="#41A9FF" stroke-width="6"></rect>
                    <path d="M54.3798 37.5455C55.2067 36.7344 55.2067 35.4194 54.3798 34.6083C53.5528 33.7972 52.2119 33.7972 51.385 34.6083L38.7647 46.9859L34.615 42.916C33.7881 42.1049 32.4472 42.1049 31.6202 42.916C30.7933 43.7271 30.7933 45.0421 31.6202 45.8532L37.2673 51.3917C38.0943 52.2028 39.4351 52.2028 40.2621 51.3917L54.3798 37.5455Z" fill="#E6E6E6"></path>
                </g>
                <defs>
                    <filter id="filter0_d_124_11283" x="0" y="0" width="86" height="86" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                        <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                        <feOffset></feOffset>
                        <feGaussianBlur stdDeviation="5"></feGaussianBlur>
                        <feComposite in2="hardAlpha" operator="out"></feComposite>
                        <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0.54902 0 0 0 0 1 0 0 0 1 0"></feColorMatrix>
                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_124_11283"></feBlend>
                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_124_11283" result="shape"></feBlend>
                    </filter>
                </defs>
            </svg>
        </div>

        <header class="flex flex-col gap-3 items-start">
            <h1 id="success-title" class="text-xl font-bold leading-6 text-center text-zinc-800 w-[440px] max-md:w-[380px] max-sm:w-full max-sm:text-lg">
                {{ __('messages.feedback_form.thank_you') }}
            </h1>
            <p id="success-description" class="text-base font-semibold leading-5 text-center text-zinc-800 w-[440px] max-md:w-[380px] max-sm:w-full max-sm:text-sm">
                {{ __('messages.feedback_form.order_processed') }}
            </p>
        </header>

        <div class="flex flex-col gap-4 items-center self-stretch">
            <button
                wire:click="continueFromSuccess"
                class="flex gap-2 justify-center items-center px-6 py-2.5 bg-sky-500 rounded-2xl cursor-pointer min-h-11 max-sm:w-full hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 transition-colors"
            >
                <span class="text-base font-bold leading-6 text-white">{{ __('messages.feedback_form.continue_button') }}</span>
            </button>
        </div>
    </section>

    <!-- Error Modal -->
    <section
        x-show="$wire.state === 'error'"
        class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 flex flex-col gap-10 items-center p-20 rounded-3xl bg-neutral-200 w-[600px] max-md:p-16 max-md:w-[500px] max-sm:px-5 max-sm:py-10 max-sm:w-full max-sm:max-w-[400px] z-50"
        role="dialog"
        aria-labelledby="error-title"
        aria-describedby="error-description"
        aria-live="polite"
        x-cloak
    >
        <button
            wire:click="tryAgain"
            class="flex absolute top-0 right-0 flex-col gap-2.5 justify-center items-center p-8 cursor-pointer max-sm:p-4 hover:bg-black hover:bg-opacity-5 rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500"
            aria-label="{{ __('messages.feedback_form.close_button_aria_label') }}"
        >
            @include('components.close-button-svg')
        </button>

        <div aria-hidden="true">
            <svg width="86" height="86" viewBox="0 0 86 86" fill="none" xmlns="http://www.w3.org/2000/svg" class="error-icon" style="width: 66px; height: 66px">
                <g filter="url(#filter0_d_124_11288)">
                    <rect x="10" y="10" width="66" height="66" rx="32" fill="#EF4444"></rect>
                    <rect x="13" y="13" width="60" height="60" rx="29" stroke="#E88181" stroke-width="6"></rect>
                    <path d="M35.7274 31.8111C34.6459 30.7296 32.8925 30.7296 31.8111 31.8111C30.7296 32.8925 30.7296 34.6459 31.8111 35.7274L39.0838 43L31.8112 50.2726C30.7297 51.3541 30.7297 53.1075 31.8112 54.1889C32.8926 55.2704 34.646 55.2704 35.7275 54.1889L43 46.9163L50.2725 54.1888C51.354 55.2703 53.1074 55.2703 54.1888 54.1888C55.2703 53.1074 55.2703 51.354 54.1888 50.2726L46.9163 43L54.1889 35.7274C55.2704 34.646 55.2704 32.8926 54.1889 31.8112C53.1075 30.7297 51.3541 30.7297 50.2726 31.8112L43 39.0838L35.7274 31.8111Z" fill="#E6E6E6"></path>
                </g>
                <defs>
                    <filter id="filter0_d_124_11288" x="0" y="0" width="86" height="86" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                        <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                        <feOffset></feOffset>
                        <feGaussianBlur stdDeviation="5"></feGaussianBlur>
                        <feComposite in2="hardAlpha" operator="out"></feComposite>
                        <feColorMatrix type="matrix" values="0 0 0 0 0.937255 0 0 0 0 0.266667 0 0 0 0 0.266667 0 0 0 1 0"></feColorMatrix>
                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_124_11288"></feBlend>
                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_124_11288" result="shape"></feBlend>
                    </filter>
                </defs>
            </svg>
        </div>

        <header class="flex flex-col gap-3 items-start">
            <h1 id="error-title" class="text-xl font-bold leading-6 text-center text-zinc-800 w-[440px] max-md:w-[380px] max-sm:w-full max-sm:text-lg">
                {{ __('messages.feedback_form.error_occurred') }}
            </h1>
            <p id="error-description" class="text-base font-semibold leading-5 text-center text-zinc-800 w-[440px] max-md:w-[380px] max-sm:w-full max-sm:text-sm">
                {{ __('messages.feedback_form.try_again') }}
            </p>
        </header>

        <div class="flex flex-col gap-4 items-center self-stretch">
            <button
                wire:click="tryAgain"
                class="flex gap-2 justify-center items-center px-6 py-2.5 bg-red-500 rounded-2xl cursor-pointer min-h-11 max-sm:w-full hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors"
            >
                <span class="text-base font-bold leading-6 text-white">{{ __('messages.feedback_form.try_again_button') }}</span>
            </button>
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('formSubmitted', () => {
                    console.log('Form submitted successfully');
                });
                Livewire.on('formSubmissionFailed', () => {
                    console.log('Form submission failed');
                });
                Livewire.on('closeFeedbackForm', () => {
                    console.log('Close feedback form event received');
                });
            });
        </script>
    @endpush
</div>
