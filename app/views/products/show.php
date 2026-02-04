<?php if ($product): ?>
<!-- Product Detail Page -->
<div class="bg-gray-50 min-h-screen pt-32 pb-16">
    <div class="max-w-7xl mx-auto px-6">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm mb-8">
            <a href="<?php echo BASE_URL; ?>/" class="text-gray-500 hover:text-[--color-primary-orange] transition-colors">Home</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="<?php echo BASE_URL; ?>/products" class="text-gray-500 hover:text-[--color-primary-orange] transition-colors">Products</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-900 font-medium"><?php echo htmlspecialchars($product['category']); ?></span>
        </nav>

        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
            <div class="grid lg:grid-cols-2 gap-12 p-8 lg:p-12">
                <!-- Product Image -->
                <div class="relative">
                    <div class="sticky top-8">
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-8 lg:p-12 aspect-square flex items-center justify-center shadow-inner">
                            <img src="<?php echo htmlspecialchars($product['image_url'] ?? 'https://placehold.co/600x600/e2e8f0/475569?text=No+Image'); ?>"
                                 alt="<?php echo htmlspecialchars($product['name']); ?>"
                                 class="max-w-full max-h-full object-contain hover:scale-105 transition-transform duration-500">
                        </div>
                        
                        <!-- Stock Badge -->
                        <div class="absolute top-6 right-6">
                            <?php if ($product['stock'] > 10): ?>
                                <span class="px-4 py-2 bg-green-500 text-white text-sm font-bold rounded-full shadow-lg flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    In Stock
                                </span>
                            <?php elseif ($product['stock'] > 0): ?>
                                <span class="px-4 py-2 bg-yellow-500 text-white text-sm font-bold rounded-full shadow-lg">
                                    Low Stock (<?php echo $product['stock']; ?> left)
                                </span>
                            <?php else: ?>
                                <span class="px-4 py-2 bg-red-500 text-white text-sm font-bold rounded-full shadow-lg">
                                    Out of Stock
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="flex flex-col">
                    <!-- Category Badge -->
                    <div class="flex items-center gap-3 mb-4">
                        <span class="px-4 py-2 bg-gradient-to-r from-[--color-primary-orange]/10 to-orange-600/10 border border-[--color-primary-orange]/30 text-[--color-primary-orange] text-sm font-bold rounded-full">
                            <?php echo htmlspecialchars($product['category']); ?>
                        </span>
                    </div>

                    <!-- Product Name -->
                    <h1 class="text-4xl lg:text-5xl font-semibold text-gray-900 mb-6 leading-tight">
                        <?php echo htmlspecialchars($product['name']); ?>
                    </h1>

                    <!-- Price -->
                    <div class="flex items-baseline gap-4 mb-8">
                        <span class="text-5xl font-semibold text-transparent bg-clip-text bg-gradient-to-r from-[--color-primary-orange] to-orange-600">
                            $<?php echo number_format($product['price'], 2); ?>
                        </span>
                        <span class="text-lg text-gray-500">
                            Stock: <span id="product-stock-display" class="font-bold <?php echo ($product['stock'] > 0) ? 'text-green-600' : 'text-red-600'; ?>">
                                <?php echo htmlspecialchars($product['stock']); ?>
                            </span>
                        </span>
                    </div>

                    <!-- Description -->
                    <div class="bg-gray-50 rounded-2xl p-6 mb-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-[--color-primary-orange]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Description
                        </h3>
                        <p class="text-gray-700 leading-relaxed">
                            <?php echo nl2br(htmlspecialchars($product['description'])); ?>
                        </p>
                    </div>

                    <!-- Specifications -->
                    <?php if (!empty($product['additional_details'])): ?>
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 mb-8 border border-blue-100">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                                Specifications
                            </h3>
                            <ul class="space-y-2">
                                <?php
                                $details = explode("\n", $product['additional_details']);
                                foreach ($details as $detail) {
                                    $trimmedDetail = trim($detail);
                                    if (!empty($trimmedDetail)) {
                                        $cleanedDetail = preg_replace('/^[\s\*\-\•]+\s*/', '', $trimmedDetail);
                                        echo '<li class="flex items-start gap-3 text-gray-700">';
                                        echo '<svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">';
                                        echo '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />';
                                        echo '</svg>';
                                        echo '<span>' . htmlspecialchars($cleanedDetail) . '</span>';
                                        echo '</li>';
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- Quantity Selector -->
                    <div class="bg-white border-2 border-gray-200 rounded-2xl p-6 mb-8">
                        <label class="text-sm font-bold text-gray-700 mb-3 block">Quantity</label>
                        <div class="flex items-center gap-4">
                            <button id="page-quantity-minus" class="w-14 h-14 rounded-xl bg-gray-100 hover:bg-gray-200 transition-colors flex items-center justify-center group">
                                <svg class="w-6 h-6 text-gray-700 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                </svg>
                            </button>
                            <span id="page-quantity-display" class="text-4xl font-semibold text-gray-900 w-24 text-center">1</span>
                            <button id="page-quantity-plus" class="w-14 h-14 rounded-xl bg-gray-100 hover:bg-gray-200 transition-colors flex items-center justify-center group">
                                <svg class="w-6 h-6 text-gray-700 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                            <input type="hidden" id="page-quantity-value" value="1">
                        </div>
                        <p id="page-quantity-error" class="text-red-500 text-sm mt-3 hidden"></p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button id="add-to-cart-page-btn"
                                data-product-id="<?php echo htmlspecialchars($product['id']); ?>"
                                data-product-name="<?php echo htmlspecialchars($product['name']); ?>"
                                data-product-price="<?php echo htmlspecialchars($product['price']); ?>"
                                data-product-image="<?php echo htmlspecialchars($product['image_url'] ?? ''); ?>"
                                data-product-stock="<?php echo htmlspecialchars($product['stock']); ?>"
                                class="flex-1 px-8 py-4 bg-gradient-to-r from-[--color-primary-orange] to-orange-600 text-white text-lg font-bold rounded-xl shadow-lg hover:shadow-2xl transition-all transform hover:scale-105 flex items-center justify-center gap-2 <?php echo ($product['stock'] <= 0) ? 'opacity-50 cursor-not-allowed' : ''; ?>"
                                <?php echo ($product['stock'] <= 0) ? 'disabled' : ''; ?>>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Add to Cart
                        </button>
                        <a href="<?php echo BASE_URL; ?>/products"
                           class="flex-1 sm:flex-initial px-8 py-4 bg-gray-100 hover:bg-gray-200 text-gray-800 text-lg font-bold rounded-xl transition-colors text-center flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back
                        </a>
                    </div>

                    <!-- Trust Badges -->
                    <div class="grid grid-cols-3 gap-4 mt-8 pt-8 border-t-2 border-gray-100">
                        <div class="text-center">
                            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-2">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-xs font-semibold text-gray-600">Authentic Products</p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-2">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <p class="text-xs font-semibold text-gray-600">Secure Payment</p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-2">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                            </div>
                            <p class="text-xs font-semibold text-gray-600">Fast Shipping</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<!-- Product Not Found -->
<div class="bg-gray-50 min-h-screen pt-32 pb-16">
    <div class="max-w-2xl mx-auto px-6">
        <div class="bg-white rounded-3xl shadow-2xl p-16 text-center border border-gray-100">
            <div class="w-24 h-24 mx-auto mb-6 bg-red-100 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
            <h2 class="text-3xl font-semibold text-gray-900 mb-4">Product Not Found</h2>
            <p class="text-gray-600 mb-8">Sorry, we couldn't find the product you're looking for.</p>
            <a href="<?php echo BASE_URL; ?>/products" class="inline-block px-8 py-4 bg-gradient-to-r from-[--color-primary-orange] to-orange-600 text-white font-bold rounded-xl hover:shadow-lg transition-all">
                Browse All Products
            </a>
        </div>
    </div>
</div>
<?php endif; ?>
