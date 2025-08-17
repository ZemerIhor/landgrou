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
        <div class="quantity-selector flex items-center justify-center space-x-4 bg-gray-100 rounded-full px-4 py-2">
            <button
                wire:click="decrementQuantity"
                class="w-8 h-8 flex items-center justify-center text-gray-600 hover:text-gray-800 transition-colors"
                aria-label="Зменшити кількість"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                </svg>
            </button>

            <span class="text-lg font-semibold text-gray-800 min-w-[3rem] text-center">
                {{ $quantity }} 000
            </span>

            <button
                wire:click="incrementQuantity"
                class="w-8 h-8 flex items-center justify-center text-gray-600 hover:text-gray-800 transition-colors"
                aria-label="Збільшити кількість"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
            </button>
        </div>

        <!-- Action Buttons -->
        <div class="button-group space-y-3">
            <!-- Buy in 1 Click Button -->
            <button
                wire:click="$dispatch('openQuickOrder', { productId: {{ $product->id }} })"
                class="w-full bg-white border-2 border-green-600 text-green-600 px-6 py-3 rounded-full font-semibold hover:bg-green-600 hover:text-white transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2"
            >
                Купити в 1 клік
            </button>

            <!-- Add to Cart Button -->
            <button
                wire:click="$dispatch('addToCart', { productId: {{ $product->id }}, quantity: {{ $quantity }} })"
                class="w-full bg-green-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-green-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2"
            >
                В кошик
            </button>
        </div>
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
