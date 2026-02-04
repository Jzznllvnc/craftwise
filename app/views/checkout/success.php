<div class="container mx-auto p-8 bg-white shadow-lg rounded-lg mt-40 mb-8 max-w-3xl text-center">
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-6 rounded-lg relative mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <h1 class="text-4xl font-extrabold text-green-800 mb-2"><?php echo htmlspecialchars($title); ?></h1>
        <p class="text-xl text-green-700">Thank you for your purchase!</p>
    </div>

    <?php if (isset($order) && $order): ?>
        <p class="text-gray-700 text-lg mb-4">Your order has been placed successfully.</p>
        <p class="text-gray-600 mb-2">Total Amount: <span class="font-bold text-gray-800">$<?php echo number_format($order['total_amount'], 2); ?></span></p>
        <p class="text-gray-600 mb-2">Payment Method: <span class="font-bold text-gray-800"><?php echo htmlspecialchars($order['payment_method']); ?></span></p>
        <p class="text-gray-600 mb-6">Order Date: <span class="font-bold text-gray-800"><?php echo date('F j, Y, g:i a', strtotime($order['order_date'])); ?></span></p>

        <?php if (!empty($order['items'])): ?>
            <h2 class="text-2xl font-semibold text-gray-800 mb-3">Order Details:</h2>
            <div class="border border-gray-200 rounded-lg p-4 text-left">
                <?php foreach ($order['items'] as $item): ?>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-b-0">
                        <span class="text-gray-800"><?php echo htmlspecialchars($item['product_name']); ?></span>
                        <span><?php echo htmlspecialchars($item['quantity']); ?> x $<?php echo number_format($item['price_at_purchase'], 2); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <p class="text-red-600 text-lg my-6">Could not retrieve order details. Please contact support if you believe there's an issue.</p>
    <?php endif; ?>

    <div class="mt-8">
        <a href="<?php echo BASE_URL; ?>/products"
           class="inline-flex items-center bg-[--color-dark-blue] hover:bg-[#1a2d3a] text-white font-bold py-3 px-6 rounded-md shadow-lg transition-colors">
            Continue Shopping
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10.293 15.707a1 1 0 010-1.414L14.586 10l-4.293-4.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                <path fill-rule="evenodd" d="M4.293 15.707a1 1 0 010-1.414L8.586 10l-4.293-4.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
        </a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        clearCart(); // Function from main.js
    });
</script>