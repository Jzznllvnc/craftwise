<!-- Hero Header -->
<div class="relative bg-gradient-to-r from-gray-900 via-gray-800 to-black pt-32 pb-16 px-6">
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.03\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    
    <div class="relative z-10 max-w-7xl mx-auto text-center">
        <div class="flex items-center justify-center gap-3 mb-4">
            <h1 class="text-5xl md:text-6xl font-semibold text-white">
                <?php echo htmlspecialchars($title); ?>
            </h1>
        </div>
        <p class="text-xl text-gray-300">Review your items and proceed to checkout</p>
    </div>
</div>

<!-- Main Content -->
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-6">
        <!-- Empty Cart State (Full Width) -->
        <div id="empty-cart-state" class="hidden">
            <div class="flex items-center justify-center min-h-[600px]">
                <div class="bg-white rounded-2xl shadow-2xl p-16 text-center border border-gray-100 w-full max-w-2xl">
                    <img src="<?php echo BASE_URL; ?>/assets/images/emptycart.png" alt="Empty Cart" class="w-80 h-80 mx-auto mb-8 object-contain">
                    <h2 class="text-4xl font-semibold text-gray-900 mb-6">
                        Your Cart is <span class="text-[--color-primary-orange]">Empty!</span>
                    </h2>
                    <p class="text-gray-600 mb-10 text-xl">Add items to your cart before proceeding to checkout</p>
                    <a href="<?php echo BASE_URL; ?>/products" class="inline-block px-10 py-5 bg-gradient-to-r from-[--color-primary-orange] to-orange-600 text-white text-lg font-bold rounded-xl shadow-lg hover:shadow-2xl transition-all transform hover:scale-105">
                        Browse Products
                    </a>
                </div>
            </div>
        </div>
        
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <!-- Loading State -->
                <div id="cart-loading" class="bg-white rounded-2xl shadow-lg p-12 text-center border border-gray-100">
                    <div class="animate-spin w-16 h-16 border-4 border-[--color-primary-orange] border-t-transparent rounded-full mx-auto mb-4"></div>
                    <p class="text-gray-600 font-medium">Loading your cart...</p>
                </div>

                <!-- Cart Items Container -->
                <div id="cart-items-container" class="space-y-4 hidden">
                    <!-- Items will be dynamically inserted here -->
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div id="checkout-section" class="sticky top-8">
                    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-[--color-primary-orange]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Order Summary
                        </h2>

                        <!-- Subtotal -->
                        <div class="space-y-4 mb-6 pb-6 border-b-2 border-gray-100">
                            <div class="flex justify-between text-lg">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-bold text-gray-900">$<span id="cart-subtotal">0.00</span></span>
                            </div>
                            <div class="flex justify-between text-lg">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-semibold text-green-600">Free</span>
                            </div>
                            <div class="flex justify-between text-lg">
                                <span class="text-gray-600">Tax</span>
                                <span class="font-bold text-gray-900">$<span id="cart-tax">0.00</span></span>
                            </div>
                        </div>

                        <!-- Total -->
                        <div class="flex justify-between text-2xl font-semibold mb-6">
                            <span class="text-gray-900">Total</span>
                            <span class="text-[--color-primary-orange]">$<span id="cart-total">0.00</span></span>
                        </div>

                        <!-- Actions -->
                        <div class="space-y-3">
                            <?php if ($isLoggedIn): ?>
                                <a href="<?php echo BASE_URL; ?>/checkout"
                                   id="proceed-to-checkout-button"
                                   class="flex items-center justify-center gap-2 w-full px-6 py-4 bg-gradient-to-r from-[--color-primary-orange] to-orange-600 text-white text-lg font-bold rounded-xl shadow-lg hover:shadow-2xl transition-all transform hover:scale-105">
                                    <span>Proceed to Checkout</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </a>
                            <?php else: ?>
                                <button type="button" disabled
                                        id="proceed-to-checkout-button"
                                        class="block w-full px-6 py-4 bg-gray-300 text-gray-500 text-lg font-bold rounded-xl cursor-not-allowed text-center">
                                    Login Required to Checkout
                                </button>
                            <?php endif; ?>
                            
                            <button onclick="clearCart()"
                                    class="block w-full px-6 py-4 bg-red-50 hover:bg-red-100 text-red-600 font-bold rounded-xl transition-colors border-2 border-red-200 hover:border-red-300">
                                Clear Cart
                            </button>
                            
                            <a href="<?php echo BASE_URL; ?>/products"
                               class="block w-full px-6 py-4 bg-gray-50 hover:bg-gray-100 text-gray-700 font-bold rounded-xl transition-colors border-2 border-gray-200 hover:border-gray-300 text-center">
                                Continue Shopping
                            </a>
                        </div>

                        <!-- Trust Badges -->
                        <div class="grid grid-cols-2 gap-4 mt-8 pt-8 border-t-2 border-gray-100">
                            <div class="text-center">
                                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <p class="text-xs font-semibold text-gray-600">Secure Payment</p>
                            </div>
                            <div class="text-center">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <p class="text-xs font-semibold text-gray-600">Free Shipping</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes spin {
    to { transform: rotate(360deg); }
}
.animate-spin {
    animation: spin 1s linear infinite;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('cart-items-container')) {
        // Hide loading, show cart
        setTimeout(() => {
            document.getElementById('cart-loading').classList.add('hidden');
            renderCartItems();
        }, 500);
    }
    
    // Calculate tax (8% for example)
    function updateCartTotals() {
        const subtotalElement = document.getElementById('cart-subtotal');
        if (subtotalElement) {
            const subtotal = parseFloat(subtotalElement.textContent);
            const tax = subtotal * 0.08;
            const total = subtotal + tax;
            
            document.getElementById('cart-tax').textContent = tax.toFixed(2);
            document.getElementById('cart-total').textContent = total.toFixed(2);
        }
    }
    
    // Override the existing renderCartItems to call updateCartTotals
    const originalRenderCartItems = window.renderCartItems;
    window.renderCartItems = function() {
        if (originalRenderCartItems) {
            originalRenderCartItems();
            updateCartTotals();
        }
    };
});
</script>
