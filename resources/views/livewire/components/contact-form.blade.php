<div x-data="{ rating: @entangle('rating'), ready: false }" x-init="setTimeout(() => ready = true, 0)" class="relative">
    <!-- Modal Overlay -->
    <div
        x-show="ready && $wire.isOpen"
        x-cloak
        class="fixed inset-0 bg-black bg-opacity-70 flex justify-center items-center z-50 transition-opacity duration-200"
        x-transition:enter="transition-opacity ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-50"
        x-transition:leave="transition-opacity ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    ></div>

    <!-- Form State -->
    <section
        x-show="ready && $wire.isOpen && $wire.state === 'form'"
        x-cloak
        class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 flex flex-col gap-10 items-center p-20 rounded-3xl bg-neutral-200 w-[600px] max-md:p-16 max-md:w-[500px] max-sm:px-5 max-sm:py-10 max-sm:w-full max-sm:max-w-[400px] z-50 transition-all duration-200"
        x-transition:enter="transition-all ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition-all ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-4"
        role="dialog"
        aria-labelledby="form-title"
        aria-describedby="form-description"
        wire:init="resetModal"
    >
        <!-- Close Button -->
        <button
            wire:click="closeModal"
            class="flex absolute button-modal-close flex-col gap-2.5 justify-center items-center hover:bg-opacity-5 rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500"
            aria-label="{{ __('messages.contact_form.close_button_aria_label') }}"
        >
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.83951 7.05025C7.54662 6.75736 7.07174 6.75736 6.77885 7.05025C6.48596 7.34315 6.48595 7.81802 6.77885 8.11091L9.96083 11.2929C10.3514 11.6834 10.3514 12.3166 9.96083 12.7071L6.77885 15.8891C6.48596 16.182 6.48596 16.6569 6.77885 16.9497C7.07174 17.2426 7.54662 17.2426 7.83951 16.9497L11.0215 13.7678C11.412 13.3772 12.0452 13.3772 12.4357 13.7678L15.6177 16.9497C15.9106 17.2426 16.3854 17.2426 16.6783 16.9497C16.9712 16.6569 16.9712 16.182 16.6783 15.8891L13.4964 12.7071C13.1058 12.3166 13.1058 11.6834 13.4964 11.2929L16.6783 8.11091C16.9712 7.81802 16.9712 7.34315 16.6783 7.05025C16.3854 6.75736 15.9106 6.75736 15.6177 7.05025L12.4357 10.2322C12.0452 10.6228 11.412 10.6228 11.0215 10.2322L7.83951 7.05025Z" fill="#333333"/>
            </svg>
        </button>

        <!-- Header Section -->
        <header class="flex flex-col gap-3 items-start w-[440px] max-md:w-full header">
            <h1 id="form-title" class="text-xl font-bold leading-6 text-zinc-800 w-[440px] max-md:w-full max-sm:text-lg">
                {{ __('messages.contact_form.title') }}
            </h1>
            <p id="form-description" class="text-base font-semibold leading-5 text-zinc-800 w-[440px] max-md:w-full max-sm:text-sm">
                {{ __('messages.contact_form.description') }}
            </p>
        </header>

        <!-- Form Content -->
        <form wire:submit.prevent="submit" x-on:keydown.enter.prevent class="flex flex-col gap-4 items-start w-full max-w-[440px] max-md:max-w-full" novalidate>
            <fieldset class="w-full border-none p-0 m-0">
                <legend class="sr-only">{{ __('messages.contact_form.fieldset_legend') }}</legend>

                <!-- Rating Section -->
                <section class="flex gap-2 items-center" role="group" aria-labelledby="rating-label">
                    <span id="rating-label" class="text-base font-semibold leading-5 text-zinc-800 max-sm:text-sm">
                        {{ __('messages.contact_form.rating_label') }}
                    </span>
                    <div class="flex gap-0" role="radiogroup" aria-labelledby="rating-label">
                        @for ($i = 1; $i <= 5; $i++)
                            <button
                                type="button"
                                x-on:click="rating = {{ $i }}"
                                class="star-button w-8 h-8 flex justify-center items-center"
                                data-rating="{{ $i }}"
                                aria-label="{{ $i == 1 ? __('messages.contact_form.star_label_one') : __('messages.contact_form.star_label_multiple', ['count' => $i]) }}"
                                role="radio"
                                :aria-checked="rating === {{ $i }}"
                            >
                                <svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg" class="star-icon w-8 h-8">
                                    <path
                                        d="M18.8065 4.68L21.1532 9.37334C21.4732 10.0267 22.3265 10.6533 23.0465 10.7733L27.2999 11.48C30.0199 11.9333 30.6599 13.9067 28.6999 15.8533L25.3932 19.16C24.8332 19.72 24.5265 20.8 24.6999 21.5733L25.6465 25.6667C26.3932 28.9067 24.6732 30.16 21.8065 28.4667L17.8199 26.1067C17.0999 25.68 15.9132 25.68 15.1799 26.1067L11.1932 28.4667C8.33988 30.16 6.60655 28.8933 7.35321 25.6667L8.29988 21.5733C8.47321 20.8 8.16655 19.72 7.60655 19.16L4.29988 15.8533C2.35321 13.9067 2.97988 11.9333 5.69988 11.48L9.95321 10.7733C10.6599 10  .6533 11.5132 10.0267 11.8332 9.37334L14.1799 4.68C15.4599 2.13334 17.5399 2.13334 18.8065 4.68Z"
                                        :fill="rating >= {{ $i }} ? '#FACC15' : '#DBDBDB'"
                                    />
                                </svg>
                            </button>
                        @endfor
                    </div>
                </section>

                <div class="flex flex-col gap-4 w-full">
                    <input
                        type="text"
                        wire:model="name"
                        placeholder="{{ __('messages.contact_form.name_placeholder') }}"
                        class="box-border gap-2 px-4 py-3 w-full h-12 text-base font-semibold leading-5 rounded-2xl border border-solid border-neutral-400 flex-[1_0_0] text-neutral-400 placeholder-neutral-400 max-sm:px-3.5 max-sm:py-2.5 max-sm:h-11 max-sm:text-sm focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent @error('name') border-red-500 @enderror"
                        aria-label="{{ __('messages.contact_form.name_label') }}"
                        required
                    />
                    @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror

                    <input
                        type="email"
                        wire:model="email"
                        placeholder="{{ __('messages.contact_form.email_placeholder') }}"
                        class="box-border gap-2 px-4 py-3 w-full h-12 text-base font-bold leading-5 rounded-2xl border border-solid border-neutral-400 flex-[1_0_0] text-neutral-400 placeholder-neutral- neutral400 max-sm:px-3.5 max-sm:py-2.5 max-sm:h-11 max-sm:text-sm focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent @error('email') border-red-500 @enderror"
                        aria-label="{{ __('messages.contact_form.email_label') }}"
                        required
                    />
                    @error('email') <span class="text-sm text-red-600">{{ $message }}</span> @enderror

                    <input
                        type="tel"
                        wire:model="phone"
                        placeholder="{{ __('messages.contact_form.phone_placeholder') }}"
                        class="box-border gap-2 px-4 py-3 w-full h-12 text-base font-semibold leading-5 rounded-2xl border border-solid border-neutral-400 flex-[1_0_0] text-neutral-400 placeholder-neutral-400 max-sm:px-3.5 max-sm:py-2.5 max-sm:h-11 max-sm:text-sm focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent @error('phone') border-red-500 @enderror"
                        aria-label="{{ __('messages.contact_form.phone_label') }}"
                        required
                    />
                    @error('phone') <span class="text-sm text-red-600">{{ $message }}</span> @enderror

                    <input
                        type="text"
                        wire:model="subject"
                        placeholder="{{ __('messages.contact_form.subject_placeholder') }}"
                        class="box-border gap-2 px-4 py-3 w-full h-12 text-base font-semibold leading-5 rounded-2xl border border-solid border-neutral-400 flex-[1_0_0] text-neutral-400 placeholder-neutral-400 max-sm:px-3.5 max-sm:py-2.5 max-sm:h-11 max-sm:text-sm focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent @error('subject') border-red-500 @enderror"
                        aria-label="{{ __('messages.contact_form.subject_label') }}"
                        required
                    />
                    @error('subject') <span class="text-sm text-red-600">{{ $message }}</span> @enderror

                    <div class="box-border flex flex-col px-4 py-3 w-full rounded-2xl border border-solid border-neutral-400 focus-within:ring-2 focus-within:ring-green-600 focus-within:border-transparent @error('formMessage') border-red-500 @enderror">
                        <textarea
                            wire:model="formMessage"
                            placeholder="{{ __('messages.contact_form.message_placeholder') }}"
                            class="w-full text-base font-semibold leading-5 h-[90px] text-neutral-400 placeholder-neutral-400 max-sm:text-sm resize-none border-none outline-none bg-transparent"
                            aria-label="{{ __('messages.contact_form.message_label') }}"
                            required
                        ></textarea>
                    </div>
                    @error('formMessage') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
            </fieldset>

            <!-- Checkbox and Buttons -->
            <div class="flex flex-col gap-4 items-start w-full max-w-[440px] max-md:max-w-full">
                <div class="flex gap-2 items-center">
                    <input
                        type="checkbox"
                        wire:model="agreePrivacy"
                        id="privacy-agreement"
                        class="w-6 h-6 rounded border-solid border-[1.5px] border-neutral-400 text-green-600 focus:ring-green-600 focus:ring-2 @error('agreePrivacy') border-red-500 @enderror"
                        required
                    />
                    <label for="privacy-agreement" class="flex gap-0.5 items-start">
                        <span class="text-xs font-semibold leading-5 text-zinc-800 max-sm:text-xs">
                            {{ __('messages.contact_form.privacy_agreement') }}
                        </span>
                        <a href="{{ route('terms') }}" class="gap-2 text-xs leading-5 text-indigo-500 underline rounded-lg max-sm:text-xs hover:text-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            {{ __('messages.contact_form.privacy_policy_link') }}
                        </a>
                    </label>
                    @error('agreePrivacy') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div class="flex gap-4 items-center w-full max-sm:flex-col max-sm:gap-3">
                    <button
                        type="button"
                        wire:click="goBack"
                        class="gap-2 px-6 py-2.5 text-base font-bold leading-6 text-green-600 rounded-2xl border-2 border-green-600 border-solid cursor-pointer min-h-11 max-sm:px-5 max-sm:py-2 max-sm:text-sm max-sm:min-h-10 hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 transition-colors"
                    >
                        {{ __('messages.contact_form.back_button') }}
                    </button>
                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        x-bind:disabled="!$wire.name || !$wire.email || !$wire.subject || !$wire.formMessage || !$wire.agreePrivacy"
                        class="gap-2 px-6 py-2.5 text-base font-bold leading-6 text-white bg-green-600 rounded-2xl cursor-pointer border-[none] min-h-11 max-sm:px-5 max-sm:py-2 max-sm:text-sm max-sm:min-h-10 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 transition-colors"
                        x-show="!$wire.isOpen || $wire.state === 'form'"
                        x-cloak
                    >
                        <span wire:loading.remove>{{ __('messages.contact_form.submit_button') }}</span>
                        <span wire:loading>{{ __('messages.contact_form.submit_loading') }}</span>
                    </button>
                </div>
            </div>
        </form>
    </section>

    <!-- Success State -->
    <section
        x-show="ready && $wire.isOpen && $wire.state === 'success'"
        x-cloak
        class="fixed top-1/2 left-1/2 transform -translate-x-1/2 flex flex-col gap-10 items-center p-20 rounded-3xl bg-neutral-200 w-[600px] max-md:p-16 max-md:w-[500px] max-sm:px-5 max-sm:py-10 max-sm:w-full max-sm:max-w-[400px] z-50 transition-all duration-200"
        x-transition:enter="transition-all ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition-all ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-4"
        role="dialog"
        aria-labelledby="success-title"
        aria-describedby="success-description"
        wire:init="resetModal"
    >
        <button
            wire:click="closeModal"
            class="flex absolute button-modal-close flex-col gap-2.5 justify-center items-center hover:bg-opacity-5 rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500"
            aria-label="{{ __('messages.contact_form.close_button_aria_label') }}"
        >
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.83951 7.05025C7.54662 6.75736 7.07174 6.75736 6.77885 7.05025C6.48596 7.34315 6.48595 7.81802 6.77885 8.11091L9.96083 11.2929C10.3514 11.6834 10.3514 12.3166 9.96083 12.7071L6.77885 15.8891C6.48596 16.182 6.48596 16.6569 6.77885 16.9497C7.07174 17.2426 7.54662 17.2426 7.83951 16.9497L11.0215 13.7678C11.412 13.3772 12.0452 13.3772 12.4357 13.7678L15.6177 16.9497C15.9106 17.2426 16.3854 17.2426 16.6783 16.9497C16.9712 16.6569 16.9712 16.182 16.6783 15.8891L13.4964 12.7071C13.1058 12.3166 13.1058 11.6834 13.4964 11.2929L16.6783 8.11091C16.9712 7.81802 16.9712 7.34315 16.6783 7.05025C16.3854 6.75736 15.9106 6.75736 15.6177 7.05025L12.4357 10.2322C12.0452 10.6228 11.412 10.6228 11.0215 10.2322L7.83951 7.05025Z" fill="#333333"/>
            </svg>
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
                {{ __('messages.contact_form.thank_you') }}
            </h1>
            <p id="success-description" class="text-base font-semibold leading-5 text-center text-zinc-800 w-[440px] max-md:w-[380px] max-sm:w-full max-sm:text-sm">
                {{ __('messages.contact_form.order_processed') }}
            </p>
        </header>

        <div class="flex flex-col gap-4 items-center self-stretch">
            <button
                wire:click="continueFromSuccess"
                class="flex gap-2 justify-center items-center px-6 py-2.5 bg-sky-500 rounded-2xl cursor-pointer min-h-11 max-sm:w-full hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 transition-colors"
            >
                <span class="text-base font-bold leading-6 text-white">{{ __('messages.contact_form.submit_button') }}</span>
            </button>
        </div>
    </section>

    <!-- Error State -->
    <section
        x-show="ready && $wire.isOpen && $wire.state === 'error'"
        x-cloak
        class="fixed top-1/2 left-1/2 transform -translate-x-1/2 flex flex-col gap-10 items-center p-20 rounded-3xl bg-neutral-200 w-[600px] max-md:p-16 max-md:w-[500px] max-sm:px-5 max-sm:py-10 max-sm:w-full max-sm:max-w-[400px] z-50 transition-all duration-200"
        x-transition:enter="transition-all ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition-all ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-4"
        role="dialog"
        aria-labelledby="error-title"
        aria-describedby="error-description"
        wire:init="resetModal"
    >
        <button
            wire:click="closeModal"
            class="flex absolute button-modal-close flex-col gap-2.5 justify-center items-center hover:bg-opacity-5 rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500"
            aria-label="{{ __('messages.contact_form.close_button_aria_label') }}"
        >
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.83951 7.05025C7.54662 6.75736 7.07174 6.75736 6.77885 7.05025C6.48596 7.34315 6.48595 7.81802 6.77885 8.11091L9.96083 11.2929C10.3514 11.6834 10.3514 12.3166 9.96083 12.7071L6.77885 15.8891C6.48596 16.182 6.48596 16.6569 6.77885 16.9497C7.07174 17.2426 7.54662 17.2426 7.83951 16.9497L11.0215 13.7678C11.412 13.3772 12.0452 13.3772 12.4357 13.7678L15.6177 16.9497C15.9106 17.2426 16.3854 17.2426 16.6783 16.9497C16.9712 16.6569 16.9712 16.182 16.6783 15.8891L13.4964 12.7071C13.1058 12.3166 13.1058 11.6834 13.4964 11.2929L16.6783 8.11091C16.9712 7.81802 16.9712 7.34315 16.6783 7.05025C16.3854 6.75736 15.9106 6.75736 15.6177 7.05025L12.4357 10.2322C12.0452 10.6228 11.412 10.6228 11.0215 10.2322L7.83951 7.05025Z" fill="#333333"/>
            </svg>
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
                {{ __('messages.contact_form.error_occurred') }}
            </h1>
            <p id="error-description" class="text-base font-semibold leading-5 text-center text-zinc-800 w-[440px] max-md:w-[380px] max-sm:w-full max-sm:text-sm">
                {{ __('messages.contact_form.try_again') }}
            </p>
        </header>

        <div class="flex flex-col gap-4 items-center self-stretch">
            <button
                wire:click="tryAgain"
                class="flex gap-2 justify-center items-center px-6 py-2.5 bg-red-500 rounded-2xl cursor-pointer min-h-11 max-sm:w-full hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors"
            >
                <span class="text-base font-bold leading-6 text-white">{{ __('messages.contact_form.try_again_button') }}</span>
            </button>
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('livewire:initialized', () => {
                Livewire.on('formSubmitted', () => {
                    console.log('Form submitted successfully');
                });
                Livewire.on('formSubmissionFailed', () => {
                    console.log('Form submission failed');
                });
                Livewire.on('closeContactForm', () => {
                    console.log('Close contact form event received');
                });
            });
        </script>
    @endpush
</div>
