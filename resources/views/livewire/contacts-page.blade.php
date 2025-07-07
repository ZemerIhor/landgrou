<style>
    .contacts-container {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    @media (min-width: 768px) {
        .contacts-container {
            grid-template-columns: 1fr 1fr;
        }
    }

    .contact-section {
        padding: 1.5rem;
        background-color: #ffffff;
        border-radius: 1.5rem;
    }

    .contact-section-alt {
        background-color: #e5e5e5;
    }

    .contact-image {
        width: 100%;
        max-width: 24rem;
        height: auto;
        border-radius: 1.5rem;
        margin: 0 auto;
    }

    .map-image {
        width: 100%;
        height: auto;
        border-radius: 1.5rem;
    }

    .contact-title {
        font-size: 1.25rem;
        font-weight: 700;
        line-height: 1.5rem;
        color: #27272a;
    }

    .contact-text {
        font-size: 1rem;
        font-weight: 600;
        line-height: 1.5rem;
        color: #27272a;
    }

    .form-container {
        padding: 1.5rem;
        background-color: #e5e5e5;
        border-radius: 1.5rem;
        position: relative;
    }

    .form-input {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 1px solid #a3a3a3;
        border-radius: 1rem;
        background: transparent;
        color: #27272a;
        outline: none;
    }

    .form-input:focus {
        border-color: #15803d;
        box-shadow: 0 0 0 2px rgba(21, 128, 61, 0.2);
    }

    .form-textarea {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 1px solid #a3a3a3;
        border-radius: 1rem;
        background: transparent;
        color: #27272a;
        outline: none;
        resize: none;
    }

    .form-textarea:focus {
        border-color: #15803d;
        box-shadow: 0 0 0 2px rgba(21, 128, 61, 0.2);
    }

    .form-button {
        padding: 0.625rem 1.5rem;
        border-radius: 1rem;
        font-weight: 700;
        transition: all 0.3s ease-in-out;
    }

    .form-button-primary {
        background-color: #15803d;
        color: #ffffff;
        border: none;
    }

    .form-button-primary:hover,
    .form-button-primary:focus {
        background-color: #166534;
        outline: none;
        box-shadow: 0 0 0 2px rgba(21, 128, 61, 0.2);
    }

    .form-button-secondary {
        border: 2px solid #15803d;
        color: #15803d;
        background: transparent;
    }

    .form-button-secondary:hover,
    .form-button-secondary:focus {
        background-color: rgba(21, 128, 61, 0.1);
        outline: none;
        box-shadow: 0 0 0 2px rgba(21, 128, 61, 0.2);
    }

    @media (max-width: 767px) {
        .contacts-container {
            grid-template-columns: 1fr;
        }

        .contact-image,
        .map-image {
            max-width: 100%;
        }

        .contact-title {
            font-size: 1rem;
        }

        .contact-text {
            font-size: 0.875rem;
        }

        .form-container {
            padding: 1rem;
        }

        .form-input,
        .form-textarea {
            font-size: 0.875rem;
        }
    }

    @media (max-width: 640px) {
        .contact-title {
            font-size: 0.875rem;
        }

        .contact-text {
            font-size: 0.75rem;
        }

        .form-input,
        .form-textarea {
            font-size: 0.75rem;
        }
    }
</style>

<div class="container mx-auto px-2">
    <main class="px-3 md:px-12 pt-14">
        <!-- Breadcrumbs -->
        <livewire:components.breadcrumbs
            :currentPage="__('messages.contacts.title')"
            :items="[]"
        />

        <!-- Page Title -->
        <header class="mt-5">
            <h1 class="text-2xl font-bold leading-tight text-zinc-800">
                {{ __('messages.contacts.title') }}
            </h1>
        </header>

        <!-- Contact Information Section -->
        <section class="mt-5 text-zinc-800" aria-labelledby="contact-info">
            <h2 id="contact-info" class="sr-only">{{ __('messages.contacts.info') }}</h2>

            <!-- Main Contact Info -->
            <article class="contacts-container contact-section">
                <section>
                    <h3 class="contact-title">
                        {{ __('messages.contacts.address') }}
                    </h3>
                    <address class="contact-text mt-4 not-italic">
                        @php
                            $address = data_get($settings, 'main_address.' . app()->getLocale(), data_get($settings, 'main_address.en', ''));
                        @endphp
                        {!! nl2br(e($address)) !!}<br>
                        E-Mail: <a href="mailto:{{ $settings->main_email }}" class="text-green-600 hover:text-green-700 focus:text-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 rounded">
                            {{ $settings->main_email }}
                        </a>
                    </address>
                </section>

                <section>
                    <h3 class="contact-title">
                        {{ __('messages.contacts.sales') }}
                    </h3>
                    <div class="contact-text mt-4">
                        @foreach ($settings->sales_phones as $phone)
                            @php
                                $phoneNumber = is_array($phone) ? ($phone['phone'] ?? '') : $phone;
                            @endphp
                            <a href="tel:{{ $phoneNumber }}" class="block text-green-600 hover:text-green-700 focus:text-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 rounded">
                                {{ $phoneNumber }}
                            </a>
                        @endforeach
                        E-Mail: <a href="mailto:{{ $settings->sales_email }}" class="text-green-600 hover:text-green-700 focus:text-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 rounded">
                            {{ $settings->sales_email }}
                        </a>
                    </div>
                </section>
            </article>

            <!-- Export and Additional Contacts -->
            <article class="contacts-container contact-section contact-section-alt mt-2">
                <section>
                    <h3 class="contact-title">
                        {{ __('messages.contacts.export') }}
                    </h3>
                    <div class="contact-text mt-4">
                        @php
                            $contact = data_get($settings, 'export_contact.' . app()->getLocale(), data_get($settings, 'export_contact.en', ''));
                        @endphp
                        <a href="tel:{{ $settings->export_phone }}" class="text-green-600 hover:text-green-700 focus:text-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 rounded">
                            {{ $settings->export_phone }}
                        </a> {{ e($contact) }}<br>
                        E-Mail: <a href="mailto:{{ $settings->export_email }}" class="text-green-600 hover:text-green-700 focus:text-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 rounded">
                            {{ $settings->export_email }}
                        </a>
                    </div>
                </section>

                <section>
                    <h3 class="contact-title">
                        {{ __('messages.contacts.additional_emails') }}
                    </h3>
                    <div class="contact-text mt-4">
                        @foreach ($settings->additional_emails as $key => $email)
                            {{ __('messages.contacts.' . $key, [], app()->getLocale()) ?: $key }}: <a href="mailto:{{ $email }}" class="text-green-600 hover:text-green-700 focus:text-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 rounded">
                                {{ $email }}
                            </a><br>
                        @endforeach
                    </div>
                </section>
            </article>

            <!-- Map and Route Section -->
            <section class="mt-2" aria-labelledby="map-section">
                <h3 id="map-section" class="sr-only">{{ __('messages.contacts.map') }}</h3>
                @if ($settings->map_image)
                    <img
                        src="{{ Storage::url($settings->map_image) }}"
                        alt="{{ data_get($settings, 'map_image_alt.' . app()->getLocale(), data_get($settings, 'map_image_alt.en', '')) }}"
                        class="map-image"
                    />
                @else
                    <p class="text-neutral-400">{{ __('messages.contacts.no_map_image') }}</p>
                @endif
                <button
                    type="button"
                    class="form-button form-button-secondary mt-4"
                    x-on:click="window.open('https://www.google.com/maps/search/' + encodeURIComponent('{{ e(data_get($settings, 'main_address.' . app()->getLocale(), data_get($settings, 'main_address.en', ''))) }}'), '_blank')"
                >
                    <span>{{ __('messages.contacts.route') }}</span>
                    <img
                        src="{{ asset('images/route-icon.png') }}"
                        alt=""
                        class="w-6 h-6"
                        aria-hidden="true"
                    />
                </button>
            </section>
        </section>

        <!-- Contact Form and Image Section -->
        <section class="py-20" aria-labelledby="contact-form">
            <div class="contacts-container">
                <!-- Contact Form Component -->
                <livewire:components.feedback-form-block />
            </div>
        </section>
    </main>
</div>
