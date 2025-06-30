<div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50" x-show="showContactForm" x-cloak x-transition x-init="$nextTick(() => { $el.querySelector('input').blur(); })">
    <div class="box-border flex relative flex-col gap-10 items-center p-10 rounded-3xl bg-neutral-200 w-[600px] max-md:max-w-[500px] max-md:w-[90%] max-sm:gap-8 max-sm:px-5 max-sm:py-10 max-sm:max-w-[400px] max-sm:w-[95%]">
        <!-- Header Section -->
        <header class="flex flex-col gap-3 items-start w-[440px] max-md:w-full">
            <h1 class="text-xl font-bold leading-6 text-zinc-800 w-[440px] max-md:w-full max-sm:text-lg">
                {{ __('messages.contact_form.title') }}
            </h1>
            <p class="text-base font-semibold leading-5 text-zinc-800 w-[440px] max-md:w-full max-sm:text-sm">
                {{ __('messages.contact_form.description') }}
            </p>
        </header>

        <!-- Rating Section -->
        <section class="flex gap-2 items-center" role="group" aria-labelledby="rating-label">
            <span id="rating-label" class="text-base font-semibold leading-5 text-zinc-800 max-sm:text-sm">
                {{ __('messages.contact_form.rating_label') }}
            </span>
            <div class="flex gap-0" role="radiogroup" aria-labelledby="rating-label">
                @for ($i = 1; $i <= 5; $i++)
                    <button type="button" wire:click="$set('rating', {{ $i }})" class="star-button w-8 h-8 flex justify-center items-center" data-rating="{{ $i }}" aria-label="{{ $i == 1 ? __('messages.contact_form.star_label_one') : __('messages.contact_form.star_label_multiple', ['count' => $i]) }}">
                        <svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg" class="star-icon w-8 h-8">
                            <path d="M18.8065 4.68L21.1532 9.37334C21.4732 10.0267 22.3265 10.6533 23.0465 10.7733L27.2999 11.48C30.0199 11.9333 30.6599 13.9067 28.6999 15.8533L25.3932 19.16C24.8332 19.72 24.5265 20.8 24.6999 21.5733L25.6465 25.6667C26.3932 28.9067 24.6732 30.16 21.8065 28.4667L17.8199 26.1067C17.0999 25.68 15.9132 25.68 15.1799 26.1067L11.1932 28.4667C8.33988 30.16 6.60655 28.8933 7.35321 25.6667L8.29988 21.5733C8.47321 20.8 8.16655 19.72 7.60655 19.16L4.29988 15.8533C2.35321 13.9067 2.97988 11.9333 5.69988 11.48L9.95321 10.7733C10.6599 10.6533 11.5132 10.0267 11.8332 9.37334L14.1799 4.68C15.4599 2.13334 17.5399 2.13334 18.8065 4.68Z" :fill="$wire.rating >= {{ $i }} ? '#FACC15' : '#DBDBDB'"/>
                        </svg>
                    </button>
                @endfor
            </div>
        </section>

        <!-- Form Fields -->
        <form wire:submit.prevent="submit" x-on:keydown.enter.prevent class="flex flex-col gap-4 items-start w-full max-w-[440px] max-md:max-w-full" novalidate>
            <fieldset class="w-full border-none p-0 m-0">
                <legend class="sr-only">{{ __('messages.contact_form.fieldset_legend') }}</legend>

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
                        class="box-border gap-2 px-4 py-3 w-full h-12 text-base font-semibold leading-5 rounded-2xl border border-solid border-neutral-400 flex-[1_0_0] text-neutral-400 placeholder-neutral-400 max-sm:px-3.5 max-sm:py-2.5 max-sm:h-11 max-sm:text-sm focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent @error('email') border-red-500 @enderror"
                        aria-label="{{ __('messages.contact_form.email_label') }}"
                        required
                    />
                    @error('email') <span class="text-sm text-red-600">{{ $message }}</span> @enderror

                    <input
                        type="tel"
                        wire:model="phone"
                        placeholder="{{ __('messages.contact_form.phone_placeholder') }}"
                        class="box-border gap-2 px-4 py-3 w-full h-12 text-base font-semibold leading-5 rounded-2xl border border-solid border-neutral-400 flex-[1_0_0] text-neutral-400 placeholder-neutral-400 max-sm:px-3.5 max-sm:py-2.5 max-sm:h-11 max-sm:text-sm focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent"
                        aria-label="{{ __('messages.contact_form.phone_label') }}"
                    />

                    <input
                        type="text"
                        wire:model="subject"
                        placeholder="{{ __('messages.contact_form.subject_placeholder') }}"
                        class="box-border gap-2 px-4 py-3 w-full h-12 text-base font-semibold leading-5 rounded-2xl border border-solid border-neutral-400 flex-[1_0_0] text-neutral-400 placeholder-neutral-400 max-sm:px-3.5 max-sm:py-2.5 max-sm:h-11 max-sm:text-sm focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent @error('subject') border-red-500 @enderror"
                        aria-label="{{ __('messages.contact_form.subject_label') }}"
                        required
                    />
                    @error('subject') <span class="text-sm text-red-600">{{ $message }}</span> @enderror

                    <div class="box-border flex flex-col items-end px-4 py-3 w-full rounded-2xl border border-solid border-neutral-400 focus-within:ring-2 focus-within:ring-green-600 focus-within:border-transparent @error('formMessage') border-red-500 @enderror">
                        <textarea
                            wire:model="formMessage"
                            placeholder="{{ __('messages.contact_form.message_placeholder') }}"
                            class="w-full text-base font-semibold leading-5 h-[90px] text-neutral-400 placeholder-neutral-400 max-sm:text-sm resize-none border-none outline-none bg-transparent"
                            aria-label="{{ __('messages.contact_form.message_label') }}"
                            required
                        ></textarea>
                        <div class="resize-handle cursor-se-resize">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6">
                                <path d="M8.21967 19.8869L19.8869 8.21967C20.1798 7.92678 20.6547 7.92678 20.9476 8.21967C21.2405 8.51256 21.2405 8.98744 20.9476 9.28033L9.28033 20.9476C8.98744 21.2405 8.51256 21.2405 8.21967 20.9476C7.92678 20.6547 7.92678 20.1798 8.21967 19.8869Z" fill="#8C8C8C"/>
                                <path d="M13.4477 19.4583L19.1215 13.7845C19.4144 13.4916 19.8892 13.4916 20.1821 13.7845C20.475 14.0774 20.475 14.5523 20.1821 14.8452L14.5084 20.5189C14.2155 20.8118 13.7406 20.8118 13.4477 20.5189C13.1548 20.226 13.1548 19.7512 13.4477 19.4583Z" fill="#8C8C8C"/>
                            </svg>
                        </div>
                    </div>
                    @error('formMessage') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
            </fieldset>

            <!-- Checkbox and Buttons Section -->
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
                        <a href="#" class="gap-2 text-xs leading-5 text-indigo-500 underline rounded-lg max-sm:text-xs hover:text-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            {{ __('messages.contact_form.privacy_policy_link') }}
                        </a>
                    </label>
                    @error('agreePrivacy') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div class="flex gap-4 items-center w-full max-sm:flex-col max-sm:gap-3">
                    <button
                        type="button"
                        x-on:click="showContactForm = false"
                        class="gap-2 px-6 py-2.5 text-base font-bold leading-6 text-green-600 rounded-2xl border-2 border-green-600 border-solid cursor-pointer min-h-11 max-sm:px-5 max-sm:py-2 max-sm:text-sm max-sm:min-h-10 hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 transition-colors"
                    >
                        {{ __('messages.contact_form.back_button') }}
                    </button>
                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        x-bind:disabled="!$wire.name || !$wire.email || !$wire.subject || !$wire.formMessage || !$wire.agreePrivacy"
                        class="gap-2 px-6 py-2.5 text-base font-bold leading-6 text-white bg-green-600 rounded-2xl cursor-pointer border-[none] min-h-11 max-sm:px-5 max-sm:py-2 max-sm:text-sm max-sm:min-h-10 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 transition-colors"
                    >
                        <span wire:loading.remove>{{ __('messages.contact_form.submit_button') }}</span>
                        <span wire:loading>{{ __('messages.contact_form.submit_loading') }}</span>
                    </button>
                </div>
            </div>
        </form>

        <!-- Close Button -->
        <button
            type="button"
            x-on:click="showContactForm = false"
            class="flex absolute top-0 right-0 flex-col gap-2.5 justify-center items-center p-8 cursor-pointer max-sm:p-5 hover:bg-black hover:bg-opacity-5 rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500"
            aria-label="{{ __('messages.contact_form.close_button_aria_label') }}"
        >
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6">
                <path d="M7.83951 7.05025C7.54662 6.75736 7.07174 6.75736 6.77885 7.05025C6.48596 7.34315 6.48595 7.81802 6.77885 8.11091L9.96083 11.2929C10.3514 11.6834 10.3514 12.3166 9.96083 12.7071L6.77885 15.8891C6.48596 16.182 6.48596 16.6569 6.77885 16.9497C7.07174 17.2426 7.54662 17.2426 7.83951 16.9497L11.0215 13.7678C11.412 13.3772 12.0452 13.3772 12.4357 13.7678L15.6177 16.9497C15.9106 17.2426 16.3854 17.2426 16.6783 16.9497C16.9712 16.6569 16.9712 16.182 16.6783 15.8891L13.4964 12.7071C13.1058 12.3166 13.1058 11.6834 13.4964 11.2929L16.6783 8.11091C16.9712 7.81802 16.9712 7.34315 16.6783 7.05025C16.3854 6.75736 15.9106 6.75736 15.6177 7.05025L12.4357 10.2322C12.0452 10.6228 11.412 10.6228 11.0215 10.2322L7.83951 7.05025Z" fill="#333333"/>
            </svg>
        </button>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('closeContactForm', () => {
                Alpine.store('contactForm').showContactForm = false;
            });
        });
    </script>
@endpush
