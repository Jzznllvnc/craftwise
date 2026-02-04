<div class="container mx-auto p-8 pt-20 bg-white shadow-lg rounded-lg mt-40 mb-16 max-w-4xl">
    <h1 class="text-4xl font-extrabold text-gray-900 mb-6 text-center"><?php echo htmlspecialchars($title); ?></h1>

    <div class="flex justify-start mb-6">
        <a href="<?php echo BASE_URL; ?>/admin/users" class="text-[--color-primary-orange] hover:text-[#e76c3e] font-medium flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to User List
        </a>
    </div>

    <?php if (empty($orders)): ?>
        <div class="text-center py-12 bg-gray-50 rounded-lg border border-gray-200 shadow-md">
            <p class="text-gray-600 text-xl mb-4">This user has no orders yet.</p>
        </div>
    <?php else: ?>
        <div id="ordersAccordion" class="space-y-6">
            <?php 
            $orderCountForDisplay = count($orders); 

            foreach ($orders as $order):
            ?>
                <div class="bg-gray-50 border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                    <h2 class="text-lg font-semibold text-gray-800 p-4 bg-gray-100 cursor-pointer flex justify-between items-center" 
                        onclick="toggleAccordion('collapse<?php echo htmlspecialchars($order['id']); ?>')">
                        <span>Order #<?php echo htmlspecialchars($orderCountForDisplay); ?> - Total: $<?php echo htmlspecialchars(number_format($order['total_amount'], 2)); ?> (Status: <?php echo htmlspecialchars($order['status']); ?>) on <?php echo htmlspecialchars(date('Y-m-d', strtotime($order['order_date']))); ?></span>
                        <svg class="w-5 h-5 text-gray-600 transform transition-transform duration-300" 
                             id="arrow-collapse<?php echo htmlspecialchars($order['id']); ?>" 
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </h2>
                    <div id="collapse<?php echo htmlspecialchars($order['id']); ?>" class="p-4 hidden border-t border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800 mb-3">Order Details:</h3>
                        <ul class="list-disc list-inside text-gray-700 space-y-1 mb-4">
                            <li><strong>Order Date:</strong> <?php echo htmlspecialchars(date('Y-m-d H:i:s', strtotime($order['order_date']))); ?></li>
                            <li><strong>Payment Method:</strong> <?php echo htmlspecialchars($order['payment_method']); ?></li>
                            <li><strong>Shipping Method:</strong> <?php echo htmlspecialchars($order['shipping_method']); ?> ($<?php echo htmlspecialchars(number_format($order['shipping_cost'], 2)); ?>)</li>
                            <li><strong>Status:</strong> <span class="font-semibold <?php echo ($order['status'] === 'Pending') ? 'text-blue-600' : 'text-green-600'; ?>"><?php echo htmlspecialchars($order['status']); ?></span></li>
                            <li><strong>Total Amount:</strong> $<?php echo htmlspecialchars(number_format($order['total_amount'], 2)); ?></li>
                        </ul>

                        <h3 class="text-lg font-bold text-gray-800 mb-3">Shipping Address:</h3>
                        <address class="not-italic text-gray-700 mb-4">
                            <?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?><br>
                            <?php echo htmlspecialchars($order['address']); ?><br>
                            <?php echo htmlspecialchars($order['city'] . ', ' . $order['state'] . ' ' . $order['zip_code']); ?><br>
                            <?php echo htmlspecialchars($order['country_code'] . ' ' . $order['shipping_mobile_number']); ?><br>
                            <?php echo htmlspecialchars($order['email']); ?>
                        </address>

                        <?php if (!empty($order['notes'])): ?>
                            <h3 class="text-lg font-bold text-gray-800 mb-3">Notes:</h3>
                            <p class="text-gray-700 mb-4"><?php echo nl2br(htmlspecialchars($order['notes'])); ?></p>
                        <?php endif; ?>

                        <h3 class="text-lg font-bold text-gray-800 mb-3">Items:</h3>
                        <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                            <table class="min-w-full leading-normal bg-white">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Product
                                        </th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Quantity
                                        </th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Price at Purchase
                                        </th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Subtotal
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($order['items'])) {
                                        foreach ($order['items'] as $item) {
                                            ?>
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-5 py-3 border-b border-gray-200 text-sm text-gray-900">
                                                    <?php echo htmlspecialchars($item['product_name']); ?>
                                                </td>
                                                <td class="px-5 py-3 border-b border-gray-200 text-sm text-gray-900">
                                                    <?php echo htmlspecialchars($item['quantity']); ?>
                                                </td>
                                                <td class="px-5 py-3 border-b border-gray-200 text-sm text-gray-900">
                                                    $<?php echo htmlspecialchars(number_format($item['price_at_purchase'], 2)); ?>
                                                </td>
                                                <td class="px-5 py-3 border-b border-gray-200 text-sm text-gray-900">
                                                    $<?php echo htmlspecialchars(number_format($item['quantity'] * $item['price_at_purchase'], 2)); ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo '<tr><td colspan="4" class="px-5 py-3 border-b border-gray-200 text-sm text-gray-600 text-center">No items for this order.</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php 
            $orderCountForDisplay--;
            endforeach; 
            ?>
        </div>
    <?php endif; ?>
</div>

<script>
    function toggleAccordion(id) {
        const element = document.getElementById(id);
        const arrow = document.getElementById('arrow-' + id);
        if (element.classList.contains('hidden')) {
            element.classList.remove('hidden');
            arrow.classList.add('rotate-180');
        } else {
            element.classList.add('hidden');
            arrow.classList.remove('rotate-180');
        }
    }
</script>