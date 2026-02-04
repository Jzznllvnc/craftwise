<!-- Hero Header -->
<div class="relative bg-gradient-to-r from-gray-900 via-gray-800 to-black pt-32 pb-16 px-6">
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.03\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    
    <div class="relative z-10 max-w-7xl mx-auto">
        <!-- Progress Steps -->
        <div class="flex items-center justify-center gap-4 mb-8">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center text-white font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <span id="step-cart" class="text-white font-semibold hidden md:block">Cart</span>
            </div>
            
            <svg class="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7" />
            </svg>
            
            <div class="flex items-center gap-2">
                <div id="step-shipping-icon" class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-purple-900 font-bold transition-all">
                    2
                </div>
                <span id="step-shipping" class="text-white font-semibold hidden md:block">Shipping</span>
            </div>
            
            <svg class="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7" />
            </svg>
            
            <div class="flex items-center gap-2">
                <div id="step-payment-icon" class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white font-bold transition-all">
                    3
                </div>
                <span id="step-payment" class="text-white/70 font-semibold hidden md:block">Payment</span>
            </div>
        </div>
        
        <h1 class="text-5xl md:text-6xl font-semibold text-white text-center">Checkout</h1>
        <p class="text-xl text-white/80 text-center mt-4">Secure & fast checkout process</p>
    </div>
</div>

<!-- Main Content -->
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-6">
        <?php if (isset($_SESSION['error']) && $_SESSION['error']): ?>
            <div class="bg-red-50 border-2 border-red-200 rounded-xl p-4 mb-8 flex items-start gap-3">
                <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <h3 class="font-bold text-red-900">Error!</h3>
                    <p class="text-red-700"><?php echo htmlspecialchars($_SESSION['error']); ?></p>
                </div>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Main Content Column -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 relative overflow-hidden" style="min-height: 500px;" id="main-content-column">
                    
                    <!-- Shipping Section -->
                    <div id="shipping-section" class="checkout-step">
                        <div class="flex items-center justify-between mb-8">
                            <h2 class="text-3xl font-semibold text-gray-900 flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-100 to-gray-300 flex items-center justify-center text-white">
                                <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                            Shipping Details
                        </h2>
                            <button type="button" id="import-address-btn" class="px-6 py-3 bg-gradient-to-r from-gray-600 to-black text-white font-bold rounded-xl hover:shadow-lg transition-all transform hover:scale-105 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                </svg>
                                Import Address
                            </button>
                        </div>
                        
                        <form id="shipping-form" autocomplete="on" class="space-y-6">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">First Name<span class="text-red-500">*</span></label>
                                    <input type="text" id="first_name" name="first_name" autocomplete="given-name" required
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-orange-600 transition-colors">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Last Name<span class="text-red-500">*</span></label>
                                    <input type="text" id="last_name" name="last_name" autocomplete="family-name" required
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-orange-600 transition-colors">
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Email<span class="text-red-500">*</span></label>
                                    <input type="email" id="email" name="email" autocomplete="email" required
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-orange-600 transition-colors">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Phone<span class="text-red-500">*</span></label>
                                    <div class="flex gap-2">
                                        <select id="country_code" name="country_code" autocomplete="tel-country-code" class="px-3 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-orange-600 transition-colors">
                                            <option value="+63">PH +63</option>
                                            <option value="+1">US +1</option>
                                            <option value="+44">UK +44</option>
                                            <option value="+61">AU +61</option>
                                            <option value="+81">JP +81</option>
                                            <option value="+86">CN +86</option>
                                        </select>
                                        <input type="tel" id="mobile_number" name="mobile_number" autocomplete="tel-national" placeholder="9123456789" required
                                               class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-orange-600 transition-colors"
                                               value="<?php echo htmlspecialchars($user['phone_number'] ?? ''); ?>">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Address<span class="text-red-500">*</span></label>
                                <input type="text" id="address" name="address" autocomplete="street-address" required
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-orange-600 transition-colors">
                            </div>

                            <div class="grid md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">City<span class="text-red-500">*</span></label>
                                    <input type="text" id="city" name="city" autocomplete="address-level2" required
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-orange-600 transition-colors">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">State<span class="text-red-500">*</span></label>
                                    <input type="text" id="state" name="state" autocomplete="address-level1" required
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-orange-600 transition-colors">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Zip Code<span class="text-red-500">*</span></label>
                                    <input type="text" id="zip_code" name="zip_code" autocomplete="postal-code" required
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-orange-600 transition-colors">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Delivery Notes</label>
                                <textarea id="notes" name="notes" rows="3" placeholder="Any special delivery instructions?"
                                          class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-orange-600 transition-colors"></textarea>
                            </div>

                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border-2 border-blue-100">
                                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                    </svg>
                                    Shipping Method
                                </h3>
                                <div class="grid sm:grid-cols-2 gap-4">
                                    <label class="relative flex items-center cursor-pointer p-4 bg-white border-2 border-gray-200 rounded-xl hover:border-blue-300 transition-all has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                        <input type="radio" name="shipping_method" value="Free Shipping" class="sr-only" checked>
                                        <div class="flex-1">
                                            <p class="font-bold text-gray-900">Free Shipping</p>
                                            <p class="text-sm text-gray-600">3-5 business days</p>
                                        </div>
                                        <span class="font-bold text-green-600">FREE</span>
                                    </label>
                                    <label class="relative flex items-center cursor-pointer p-4 bg-white border-2 border-gray-200 rounded-xl hover:border-blue-300 transition-all has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                        <input type="radio" name="shipping_method" value="Express Shipping" class="sr-only">
                                        <div class="flex-1">
                                            <p class="font-bold text-gray-900">Express</p>
                                            <p class="text-sm text-gray-600">Same-day delivery</p>
                                        </div>
                                        <span class="font-bold text-gray-900">$1.50</span>
                                    </label>
                                </div>
                            </div>

                            <button type="button" id="continue-to-payment-button-shipping" class="w-full px-6 py-4 bg-gradient-to-r from-[--color-primary-orange] to-orange-600 text-white font-bold rounded-xl hover:shadow-lg transition-all hidden flex items-center justify-center gap-2">
                                <span>Continue to Payment</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </button>
                        </form>
                    </div>

                    <!-- Payment Section -->
                    <div id="payment-section" class="checkout-step">
                        <h2 class="text-3xl font-semibold text-gray-900 mb-8 flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center text-white">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                            </div>
                            Payment Method
                        </h2>
                        
                        <form id="payment-form-final" action="<?php echo BASE_URL; ?>/checkout/process" method="POST" class="space-y-6">
                            <div class="grid sm:grid-cols-2 gap-4">
                                <label class="relative cursor-pointer p-6 bg-white border-2 border-gray-200 rounded-xl hover:border-green-300 transition-all has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                    <input type="radio" name="payment_method" value="GCash" class="sr-only" required>
                                    <div class="flex flex-col items-center gap-3">
                                        <img src="<?php echo BASE_URL; ?>/assets/images/gcash.svg" alt="GCash" class="h-12 object-contain">
                                        <span class="font-bold text-gray-900">GCash</span>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer p-6 bg-white border-2 border-gray-200 rounded-xl hover:border-blue-300 transition-all has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                    <input type="radio" name="payment_method" value="PayPal" class="sr-only" required>
                                    <div class="flex flex-col items-center gap-3">
                                        <img src="<?php echo BASE_URL; ?>/assets/images/paypal.svg" alt="PayPal" class="h-12 object-contain">
                                        <span class="font-bold text-gray-900">PayPal</span>
                                    </div>
                                </label>
                            </div>

                            <div id="payment-mobile-number-group" class="hidden">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Mobile Number<span class="text-red-500">*</span></label>
                                <input type="tel" id="p_mobile_number_display" name="payment_mobile_number" placeholder="09123456789"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-green-500 transition-colors">
                                <p id="payment-mobile-number-error" class="text-red-500 text-sm mt-2 hidden"></p>
                            </div>

                            <!-- Hidden fields for form data -->
                            <?php
                            $hiddenFields = ['first_name', 'last_name', 'email', 'country_code', 'mobile_number', 'address', 'city', 'state', 'zip_code', 'notes', 'shipping_method', 'shipping_cost', 'cart_items_json', 'total_amount'];
                            foreach ($hiddenFields as $field):
                            ?>
                                <input type="hidden" name="<?php echo $field; ?>" id="h_<?php echo $field; ?>">
                            <?php endforeach; ?>

                            <div class="flex gap-4 pt-4">
                                <button type="button" id="back-to-shipping-button" class="flex-1 px-6 py-4 bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold rounded-xl transition-colors">
                                    ← Back
                                </button>
                                <button type="submit" id="place-order-button" class="flex-1 px-6 py-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold rounded-xl hover:shadow-lg transition-all">
                                    Pay Now
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-8 space-y-6">
                    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Order Summary</h2>
                        
                        <div id="checkout-cart-summary" class="space-y-3 mb-6 max-h-64 overflow-y-auto">
                            <p class="text-center text-gray-500 py-4">Loading...</p>
                        </div>

                        <div class="space-y-3 pt-6 border-t-2 border-gray-100">
                            <div class="flex justify-between text-gray-700">
                                <span>Subtotal</span>
                                <span class="font-semibold">$<span id="cart-subtotal">0.00</span></span>
                            </div>
                            <div class="flex justify-between text-gray-700">
                                <span>Shipping</span>
                                <span class="font-semibold">$<span id="cart-shipping-cost">0.00</span></span>
                            </div>
                            <div class="flex justify-between text-gray-700">
                                <span>Tax</span>
                                <span class="font-semibold">$0.25</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center text-2xl font-semibold pt-6 border-t-2 border-gray-100 mt-6">
                            <span class="text-gray-900">Total</span>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-orange-600">
                                $<span id="cart-total-amount">0.00</span>
                            </span>
                        </div>
                    </div>

                    <button type="button" id="continue-to-payment-button-outside-summary"
                            class="w-full px-6 py-4 bg-gradient-to-r from-[--color-primary-orange] to-orange-600 text-white font-bold rounded-xl hover:shadow-lg transition-all transform hover:scale-105 flex items-center justify-center gap-2">
                        <span>Continue to Payment</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
#main-content-column {
    position: relative;
}
.checkout-step {
    display: none;
    transition: opacity 0.3s ease-in-out;
}
.checkout-step.active {
    display: block;
    opacity: 1;
    animation: fadeIn 0.3s ease-in-out;
}
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
#checkout-cart-summary::-webkit-scrollbar {
    width: 6px;
}
#checkout-cart-summary::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}
#checkout-cart-summary::-webkit-scrollbar-thumb {
    background: rgba(33, 45, 73, 0.26);
    border-radius: 10px;
}
</style>

<!-- Import Address Modal -->
<div id="import-address-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b border-gray-200 px-8 py-6 flex items-center justify-between">
            <h3 class="text-2xl font-bold text-gray-900">Select Saved Address</h3>
            <button id="close-import-modal" class="w-10 h-10 rounded-full hover:bg-gray-100 flex items-center justify-center transition-colors">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div id="saved-addresses-list" class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <p class="col-span-2 text-center text-gray-500 py-8">Loading addresses...</p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 'shipping';
    let shippingData = {};
    
    // Initialize - Show shipping section
    document.getElementById('shipping-section').classList.add('active');
    
    // Load cart summary
    loadCartSummary();
    
    function loadCartSummary() {
        const summaryContainer = document.getElementById('checkout-cart-summary');
        const subtotalEl = document.getElementById('cart-subtotal');
        const shippingCostEl = document.getElementById('cart-shipping-cost');
        const totalEl = document.getElementById('cart-total-amount');
        
        if (typeof isLoggedIn !== 'undefined' && isLoggedIn) {
            // Fetch from server for logged-in users
            fetch(BASE_URL + '/cart/get')
                .then(res => res.json())
                .then(data => {
                    if (data.success && data.cart) {
                        displayCart(data.cart);
                    } else {
                        summaryContainer.innerHTML = '<p class="text-center text-gray-500 py-4">Your cart is empty</p>';
                    }
                })
                .catch(err => {
                    console.error('Error loading cart:', err);
                    summaryContainer.innerHTML = '<p class="text-center text-gray-500 py-4">Error loading cart</p>';
                });
        } else {
            // Load from localStorage for guest users
            const cart = typeof getCart === 'function' ? getCart() : [];
            displayCart(cart);
        }
        
        function displayCart(items) {
            if (items.length === 0) {
                summaryContainer.innerHTML = '<p class="text-center text-gray-500 py-4">Your cart is empty</p>';
                return;
            }
            
            let html = '';
            let subtotal = 0;
            
            items.forEach(item => {
                const price = parseFloat(item.price);
                const quantity = parseInt(item.quantity);
                const itemTotal = price * quantity;
                subtotal += itemTotal;
                
                const imageSrc = item.image || '';
                const productName = item.name || '';
                
                html += `
                    <div class="flex items-center gap-3 pb-3 border-b border-gray-100">
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <img src="${imageSrc}" alt="${productName}" class="w-full h-full object-contain p-1" onerror="this.style.display='none'">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate">${productName}</p>
                            <p class="text-xs text-gray-600">Qty: ${quantity} × $${price.toFixed(2)}</p>
                        </div>
                    </div>
                `;
            });
            
            summaryContainer.innerHTML = html;
            
            // Update totals
            const shippingCost = 0; // Free shipping
            const tax = 0.25;
            const total = subtotal + shippingCost + tax;
            
            subtotalEl.textContent = subtotal.toFixed(2);
            shippingCostEl.textContent = shippingCost.toFixed(2);
            totalEl.textContent = total.toFixed(2);
            
            // Store cart data for form submission
            const cartItemsJson = JSON.stringify(items);
            document.getElementById('h_cart_items_json').value = cartItemsJson;
            document.getElementById('h_total_amount').value = total.toFixed(2);
        }
    }
    
    // Continue to payment buttons
    document.getElementById('continue-to-payment-button-shipping')?.addEventListener('click', continueToPayment);
    document.getElementById('continue-to-payment-button-outside-summary')?.addEventListener('click', continueToPayment);
    
    function continueToPayment() {
        // Validate shipping form
        const form = document.getElementById('shipping-form');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        // Collect shipping data
        shippingData = {
            first_name: document.getElementById('first_name').value,
            last_name: document.getElementById('last_name').value,
            email: document.getElementById('email').value,
            country_code: document.getElementById('country_code').value,
            mobile_number: document.getElementById('mobile_number').value,
            address: document.getElementById('address').value,
            city: document.getElementById('city').value,
            state: document.getElementById('state').value,
            zip_code: document.getElementById('zip_code').value,
            notes: document.getElementById('notes').value,
            shipping_method: document.querySelector('input[name="shipping_method"]:checked').value,
            shipping_cost: document.querySelector('input[name="shipping_method"]:checked').value === 'Free Shipping' ? '0.00' : '1.50'
        };
        
        // Update hidden fields
        Object.keys(shippingData).forEach(key => {
            const hiddenField = document.getElementById('h_' + key);
            if (hiddenField) {
                hiddenField.value = shippingData[key];
            }
        });
        
        // Update shipping cost display
        document.getElementById('cart-shipping-cost').textContent = shippingData.shipping_cost;
        const subtotal = parseFloat(document.getElementById('cart-subtotal').textContent);
        const tax = 0.25;
        const total = subtotal + parseFloat(shippingData.shipping_cost) + tax;
        document.getElementById('cart-total-amount').textContent = total.toFixed(2);
        document.getElementById('h_total_amount').value = total.toFixed(2);
        
        // Switch to payment step
        document.getElementById('shipping-section').classList.remove('active');
        document.getElementById('payment-section').classList.add('active');
        
        // Hide the Continue to Payment button in sidebar
        const continueButton = document.getElementById('continue-to-payment-button-outside-summary');
        if (continueButton) {
            continueButton.classList.add('hidden');
        }
        
        // Update progress indicators
        document.getElementById('step-shipping-icon').innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>';
        document.getElementById('step-shipping-icon').classList.add('bg-green-500');
        document.getElementById('step-shipping-icon').classList.remove('bg-white', 'text-purple-900');
        document.getElementById('step-payment-icon').classList.add('bg-white');
        document.getElementById('step-payment-icon').classList.remove('bg-white/20', 'text-white');
        document.getElementById('step-payment-icon').textContent = '3';
        
        // Scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    
    // Back to shipping button
    document.getElementById('back-to-shipping-button')?.addEventListener('click', function() {
        document.getElementById('payment-section').classList.remove('active');
        document.getElementById('shipping-section').classList.add('active');
        
        // Show the Continue to Payment button in sidebar
        const continueButton = document.getElementById('continue-to-payment-button-outside-summary');
        if (continueButton) {
            continueButton.classList.remove('hidden');
        }
        
        // Update progress indicators
        document.getElementById('step-shipping-icon').textContent = '2';
        document.getElementById('step-shipping-icon').classList.remove('bg-green-500');
        document.getElementById('step-shipping-icon').classList.add('bg-white', 'text-purple-900');
        document.getElementById('step-payment-icon').classList.remove('bg-white');
        document.getElementById('step-payment-icon').classList.add('bg-white/20', 'text-white');
        
        // Scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
    
    // Handle GCash selection - show mobile number field
    const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
    const mobileNumberGroup = document.getElementById('payment-mobile-number-group');
    
    paymentRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'GCash') {
                mobileNumberGroup.classList.remove('hidden');
                document.getElementById('p_mobile_number_display').required = true;
            } else {
                mobileNumberGroup.classList.add('hidden');
                document.getElementById('p_mobile_number_display').required = false;
            }
        });
    });
    
    // Form submission
    document.getElementById('payment-form-final')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const selectedPayment = document.querySelector('input[name="payment_method"]:checked');
        if (!selectedPayment) {
            alertMessage('error', 'Please select a payment method');
            return;
        }
        
        // If GCash is selected, validate mobile number
        if (selectedPayment.value === 'GCash') {
            const mobileNumber = document.getElementById('p_mobile_number_display').value.trim();
            const errorEl = document.getElementById('payment-mobile-number-error');
            
            if (!mobileNumber || mobileNumber.length < 10) {
                errorEl.textContent = 'Please enter a valid mobile number';
                errorEl.classList.remove('hidden');
                return;
            }
            errorEl.classList.add('hidden');
        }
        
        // Disable button to prevent double submission
        const submitBtn = document.getElementById('place-order-button');
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Processing...';
        
        // Submit the form
        this.submit();
    });
    
    // Update shipping cost when shipping method changes
    document.querySelectorAll('input[name="shipping_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const cost = this.value === 'Free Shipping' ? 0 : 1.50;
            document.getElementById('cart-shipping-cost').textContent = cost.toFixed(2);
            
            const subtotal = parseFloat(document.getElementById('cart-subtotal').textContent);
            const tax = 0.25;
            const total = subtotal + cost + tax;
            document.getElementById('cart-total-amount').textContent = total.toFixed(2);
        });
    });

    // Import Address Functionality
    const importAddressBtn = document.getElementById('import-address-btn');
    const importModal = document.getElementById('import-address-modal');
    const closeImportModal = document.getElementById('close-import-modal');
    const savedAddressesList = document.getElementById('saved-addresses-list');

    // Open import modal
    importAddressBtn?.addEventListener('click', function() {
        importModal.classList.remove('hidden');
        loadSavedAddresses();
    });

    // Close import modal
    closeImportModal?.addEventListener('click', function() {
        importModal.classList.add('hidden');
    });

    // Close modal on outside click
    importModal?.addEventListener('click', function(e) {
        if (e.target === importModal) {
            importModal.classList.add('hidden');
        }
    });

    // Load saved addresses
    function loadSavedAddresses() {
        savedAddressesList.innerHTML = '<p class="col-span-2 text-center text-gray-500 py-8">Loading addresses...</p>';
        
        fetch(BASE_URL + '/user/addresses')
            .then(res => res.json())
            .then(data => {
                if (data.success && data.addresses) {
                    if (data.addresses.length === 0) {
                        savedAddressesList.innerHTML = `
                            <div class="col-span-2 text-center py-12">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <p class="text-gray-500 text-lg font-medium mb-2">No saved addresses</p>
                                <p class="text-gray-400 text-sm">Go to your profile to add addresses</p>
                                <a href="${BASE_URL}/profile" class="inline-block mt-4 px-6 py-3 bg-gradient-to-r from-[--color-primary-orange] to-orange-600 text-white font-bold rounded-xl hover:shadow-lg transition-all">
                                    Go to Profile
                                </a>
                            </div>
                        `;
                    } else {
                        let html = '';
                        data.addresses.forEach(address => {
                            html += `
                                <div class="border-2 border-gray-200 rounded-xl p-6 hover:border-orange-500 transition-all cursor-pointer address-card" data-address='${JSON.stringify(address).replace(/'/g, "&#39;")}'>
                                    <div class="flex items-start gap-3 mb-4">
                                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-orange-100 to-orange-200 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between gap-2 mb-1">
                                                <h4 class="text-lg font-bold text-gray-900">${address.label}</h4>
                                                ${address.is_default == 1 ? '<span class="px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full flex-shrink-0">Default</span>' : ''}
                                            </div>
                                            <p class="text-sm text-gray-700 font-semibold">${address.first_name} ${address.last_name}</p>
                                        </div>
                                    </div>
                                    <div class="space-y-2 text-sm text-gray-600">
                                        <p>${address.address}</p>
                                        <p>${address.city}, ${address.state} ${address.zip_code}</p>
                                        <p class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            ${address.country_code} ${address.mobile_number}
                                        </p>
                                    </div>
                                    <button class="w-full mt-4 px-4 py-3 bg-gradient-to-r from-orange-600 to-orange-600 text-white font-bold rounded-lg hover:shadow-lg transition-all">
                                        Use This Address
                                    </button>
                                </div>
                            `;
                        });
                        savedAddressesList.innerHTML = html;
                        
                        // Add click handlers
                        document.querySelectorAll('.address-card').forEach(card => {
                            card.addEventListener('click', function() {
                                const address = JSON.parse(this.dataset.address);
                                fillShippingForm(address);
                                importModal.classList.add('hidden');
                                alertMessage('success', 'Address imported successfully!');
                            });
                        });
                    }
                } else {
                    savedAddressesList.innerHTML = '<p class="col-span-2 text-center text-red-500 py-8">Failed to load addresses</p>';
                }
            })
            .catch(err => {
                console.error(err);
                savedAddressesList.innerHTML = '<p class="col-span-2 text-center text-red-500 py-8">Error loading addresses</p>';
            });
    }

    // Fill shipping form with address data
    function fillShippingForm(address) {
        document.getElementById('first_name').value = address.first_name;
        document.getElementById('last_name').value = address.last_name;
        document.getElementById('email').value = address.email || '';
        document.getElementById('country_code').value = address.country_code;
        document.getElementById('mobile_number').value = address.mobile_number;
        document.getElementById('address').value = address.address;
        document.getElementById('city').value = address.city;
        document.getElementById('state').value = address.state;
        document.getElementById('zip_code').value = address.zip_code;
    }
});
</script>
