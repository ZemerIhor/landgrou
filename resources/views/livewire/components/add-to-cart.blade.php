<div>
    <button
        wire:click.prevent="addToCart"
        class="gap-2 self-stretch px-6 py-2.5 my-auto text-white bg-green-600 rounded-2xl min-h-11 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-zinc-800"
        aria-label="{{ __('messages.cart.add_to_cart_aria') }}"
        type="button"
    >
        {{ __('messages.cart.add_to_cart') }}
    </button>

    @if ($errors->has('quantity'))
        <div class="p-2 mt-4 text-xs font-medium text-center text-red-700 rounded bg-red-50" role="alert">
            @foreach ($errors->get('quantity') as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif

    <div
        x-data="{ open: false }"
        x-on:add-to-cart.window="open = true; setTimeout(() => open = false, 2000)"
        class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg"
        x-show="open"
        x-transition
        style="display: none;"
    >
        {{ __('messages.cart.added_to_cart') }}
    </div>
</div>
