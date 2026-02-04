<!-- Hero Header -->
<div class="relative bg-gradient-to-r from-gray-900 via-gray-800 to-black pt-32 pb-16 px-6">
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.03\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    
    <div class="relative z-10 max-w-7xl mx-auto text-center">
        <h1 class="text-5xl md:text-6xl font-semibold text-white mb-4">
            My Orders
        </h1>
        <p class="text-xl text-gray-300">
            Track your <span class="text-[--color-primary-orange] font-semibold">order history</span> and purchases
        </p>
    </div>
</div>

<!-- Main Content -->
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-6">
        <?php if (empty($orders)): ?>
            <!-- Empty State -->
            <div class="flex items-center justify-center min-h-[500px]">
                <div class="bg-white rounded-2xl shadow-2xl p-16 text-center border border-gray-100 w-full max-w-2xl">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <h2 class="text-4xl font-semibold text-gray-900 mb-4">
                        No Orders Yet
                    </h2>
                    <p class="text-gray-600 mb-8 text-lg">
                        You haven't placed any orders yet. Successful checkout orders will appear here.
                    </p>
                    <a href="<?php echo BASE_URL; ?>/products" 
                       class="inline-block px-10 py-4 bg-gradient-to-r from-[--color-primary-orange] to-orange-600 text-white text-lg font-bold rounded-xl shadow-lg hover:shadow-2xl transition-all transform hover:scale-105">
                        Start Shopping
                    </a>
                </div>
            </div>
        <?php else: ?>
            <!-- Orders List -->
            <div class="space-y-6">
                <?php
                $orderCountForDisplay = count($orders); 
                foreach ($orders as $order):
                ?>
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300">
                        <!-- Order Header -->
                        <div class="p-6 bg-gradient-to-r from-gray-50 to-white border-b-2 border-gray-100">
                            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-[--color-primary-orange] to-orange-600 flex items-center justify-center text-white font-bold text-xl shadow-lg">
                                        #<?php echo htmlspecialchars($orderCountForDisplay); ?>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900 mb-1">Order #<?php echo htmlspecialchars($orderCountForDisplay); ?></h3>
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <?php echo date('F j, Y, g:i a', strtotime($order['order_date'])); ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex flex-wrap gap-4 items-center">
                                    <div class="text-center lg:text-right">
                                        <p class="text-sm text-gray-600 mb-1">Total Amount</p>
                                        <p class="text-2xl font-bold text-[--color-primary-orange]">$<?php echo number_format($order['total_amount'], 2); ?></p>
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-xl border-2 border-gray-200">
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                            <span class="text-sm font-semibold text-gray-700"><?php echo htmlspecialchars($order['payment_method']); ?></span>
                                        </div>
                                        <?php if ($order['status'] === 'Pending'): ?>
                                            <span class="px-4 py-2 bg-blue-100 text-blue-800 text-sm font-bold rounded-xl text-center">
                                                <span class="inline-block w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                                                Pending
                                            </span>
                                        <?php else: ?>
                                            <span class="px-4 py-2 bg-green-100 text-green-800 text-sm font-bold rounded-xl text-center">
                                                <span class="inline-block w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                                <?php echo htmlspecialchars($order['status']); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <?php if (!empty($order['items'])): ?>
                            <div class="p-6">
                                <div class="flex items-center gap-2 mb-4">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    <h4 class="text-lg font-bold text-gray-800">Order Items</h4>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <?php foreach ($order['items'] as $item): ?>
                                        <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-xl border border-gray-200 hover:border-orange-200 transition-colors">
                                            <div class="w-20 h-20 bg-white rounded-lg flex items-center justify-center flex-shrink-0 p-2">
                                                <img src="<?php echo htmlspecialchars($item['image_url'] ?? 'https://placehold.co/80x80/e2e8f0/475569?text=No+Image'); ?>" 
                                                     alt="<?php echo htmlspecialchars($item['product_name']); ?>" 
                                                     class="w-full h-full object-contain">
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-md font-semibold text-gray-900 mb-1 truncate"><?php echo htmlspecialchars($item['product_name']); ?></p>
                                                <div class="flex items-center justify-between text-sm">
                                                    <span class="text-gray-600">Qty: <span class="font-bold text-gray-900"><?php echo htmlspecialchars($item['quantity']); ?></span></span>
                                                    <span class="text-[--color-primary-orange] font-bold">$<?php echo number_format($item['price_at_purchase'], 2); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="p-6 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p class="italic">No items found for this order.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php 
                $orderCountForDisplay--;
                endforeach; 
                ?>
            </div>
        <?php endif; ?>
    </div>
</div>