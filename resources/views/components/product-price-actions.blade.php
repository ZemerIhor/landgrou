@props(['product', 'variant', 'quantity' => 1])

<div class="product-actions-card">
    <!-- Price Display -->
    <div class="price-section mb-6">
        <div class="flex items-baseline space-x-2">
            <span class="text-3xl font-bold text-gray-900">0 000</span>
            <span class="text-lg text-gray-600">₴</span>
        </div>
    </div>

    <!-- Quantity and Actions -->
    <div class="actions-section space-y-4">
        <!-- Quantity Selector -->
        <div class="flex relative gap-4 items-center max-sm:flex-col max-sm:gap-3">
            <!-- Quantity Selection -->
            <div class="flex relative gap-2 items-center px-2 py-0 h-11 rounded-2xl bg-neutral-200"
                 role="group"
                 aria-label="{{ __('messages.product.quantity_selection') }}">
                <button wire:click="incrementQuantity"
                        class="flex relative gap-2.5 items-center"
                        aria-label="{{ __('messages.product.increment_quantity') }}">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="plus-icon">
                        <path d="M12.75 7C12.75 6.58579 12.4142 6.25 12 6.25C11.5858 6.25 11.25 6.58579 11.25 7L11.25 11.25H7C6.58579 11.25 6.25 11.5858 6.25 12C6.25 12.4142 6.58579 12.75 7 12.75H11.25V17C11.25 17.4142 11.5858 17.75 12 17.75C12.4142 17.75 12.75 17.4142 12.75 17L12.75 12.75H17C17.4142 12.75 17.75 12.4142 17.75 12C17.75 11.5858 17.4142 11.25 17 11.25H12.75V7Z" fill="#333333"/>
                    </svg>
                </button>
                <div class="flex relative gap-2.5 justify-center items-center">
                                <span class="relative text-base font-semibold leading-5 text-zinc-800 max-sm:text-sm">
                                    {{ $this->quantity }}
                                </span>
                </div>
                <button wire:click="decrementQuantity"
                        class="flex relative gap-2.5 items-center"
                        aria-label="{{ __('messages.product.decrement_quantity') }}">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="minus-icon">
                        <path d="M17.2174 12.5C17.6496 12.5 18 12.1642 18 11.75C18 11.3358 17.6496 11 17.2174 11H6.78261C6.35039 11 6 11.3358 6 11.75C6 11.5858 6.35039 12.5 6.78261 12.5H17.2174Z" fill="#333333"/>
                    </svg>
                </button>
            </div>
            <livewire:components.add-to-cart :purchasable="$this->variant" :quantity="$this->quantity" :wire:key="$this->variant->id" />
        </div>

        <!-- Action Buttons -->
    </div>

    <!-- Additional Info -->
    @if($product->article_number)
        <div class="article-info mt-4 text-center">
            <span class="text-sm text-gray-500">
                ID/Код/Артикул: {{ $product->article_number }}
            </span>
        </div>
    @endif
</div>

<style>
.product-actions-card {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.quantity-selector {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(229, 231, 235, 0.5);
}

.button-group button {
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.button-group button:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}
</style>
