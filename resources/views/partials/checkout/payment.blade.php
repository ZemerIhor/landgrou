<form wire:submit.prevent="checkout" class="bg-white p-8 rounded-3xl border border-gray-100 max-md:p-5">
    <header class="flex gap-4 items-start w-full text-base font-semibold leading-none max-md:max-w-full">
        <div class="flex flex-col justify-center items-center text-center text-white whitespace-nowrap rounded-2xl bg-zinc-800 h-[22px] w-[22px]" aria-label="{{ __('messages.checkout.step_3') }}">
            <span class="text-white">3</span>
        </div>
        <h1 id="form-heading" class="flex-1 shrink basis-0 text-zinc-800">
            {{ __('messages.checkout.payment') }}
        </h1>
    </header>

    <div class="mt-10 w-full text-base font-semibold leading-none whitespace-nowrap text-neutral-400 max-md:max-w-full space-y-4">
        <div class="flex gap-4 flex-wrap">
            <button
                type="button"
                wire:click.prevent="$set('paymentType', 'card')"
                @class([
                    'flex gap-2 justify-center items-center px-6 py-2.5 text-sm font-medium rounded-2xl border border-solid min-h-11',
                    'text-white bg-green-600 border-green-600 hover:bg-green-700' => $paymentType === 'card',
                    'text-neutral-400 border-neutral-400 hover:bg-zinc-50' => $paymentType !== 'card',
                ])
                aria-label="{{ __('messages.checkout.pay_by_card') }}"
            >
                {{ __('messages.checkout.pay_by_card') }}
            </button>

            <button
                type="button"
                wire:click.prevent="$set('paymentType', 'cash-on-delivery')"
                @class([
                    'flex gap-2 justify-center items-center px-6 py-2.5 text-sm font-medium rounded-2xl border border-solid min-h-11',
                    'text-white bg-green-600 border-green-600 hover:bg-green-700' => $paymentType === 'cash-on-delivery',
                    'text-neutral-400 border-neutral-400 hover:bg-zinc-50' => $paymentType !== 'cash-on-delivery',
                ])
                aria-label="{{ __('messages.checkout.cash_on_delivery') }}"
            >
                {{ __('messages.checkout.cash_on_delivery') }}
            </button>
        </div>

        @if ($paymentType == 'card')
            <div class="mt-4">
                <livewire:stripe.payment :cart="$cart" :returnUrl="route('checkout.view')" />
            </div>
        @endif

        @if ($paymentType == 'cash-on-delivery')
            <div class="mt-4 p-4 text-sm text-center text-blue-700 rounded-2xl bg-blue-50">
                {{ __('messages.checkout.cash_on_delivery_info') }}
            </div>
        @endif
    </div>

    <!-- Navigation Buttons -->
    <div class="mt-8 flex gap-4 items-center w-full text-base font-bold leading-snug whitespace-nowrap max-md:max-w-full max-md:flex-col max-md:gap-4">
        <button
            type="button"
            wire:click="goBackStep"
            class="flex gap-2 justify-center items-center self-stretch px-6 py-2.5 my-auto text-green-600 rounded-2xl border-2 border-green-600 border-solid min-h-11 max-md:px-5 hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2"
            aria-label="{{ __('messages.checkout.back') }}"
        >
            <span class="self-stretch my-auto text-green-600">{{ __('messages.checkout.back') }}</span>
        </button>

        @if ($paymentType == 'cash-on-delivery')
            <button
                type="submit"
                class="flex gap-2 justify-center items-center self-stretch px-6 py-2.5 my-auto text-white bg-green-600 rounded-2xl min-h-11 max-md:px-5 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2"
                aria-label="{{ __('messages.checkout.confirm_order') }}"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove>{{ __('messages.checkout.confirm_order') }}</span>
                <span wire:loading>
                    <svg class="w-5 h-5 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
            </button>
        @endif
    </div>

    <!-- Step Indicators -->
    <nav class="mt-10 w-full text-base font-semibold leading-none whitespace-nowrap max-md:max-w-full" aria-label="{{ __('messages.checkout.steps') }}">
        <div class="flex gap-4 items-start max-w-full min-h-[22px] w-[440px]">
            <div class="flex flex-col justify-center items-center text-center text-white rounded-2xl bg-neutral-400 h-[22px] w-[22px]" aria-label="{{ __('messages.checkout.step_1') }}">
                <span class="text-white">1</span>
            </div>
            <span class="flex-1 shrink basis-0 text-neutral-400">{{ __('messages.checkout.personal_info') }}</span>
        </div>

        <div class="flex gap-4 items-start mt-4 max-w-full min-h-[22px] w-[440px]">
            <div class="flex flex-col justify-center items-center text-center text-white rounded-2xl bg-neutral-400 h-[22px] w-[22px]" aria-label="{{ __('messages.checkout.step_2') }}">
                <span class="text-white">2</span>
            </div>
            <span class="flex-1 shrink basis-0 text-neutral-400">{{ __('messages.checkout.delivery') }}</span>
        </div>
    </nav>
</form>

<style>
    /* Custom button styling */
    button:focus {
        outline: 2px solid #3b82f6;
        outline-offset: 2px;
    }
</style>
