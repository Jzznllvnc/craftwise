<!-- Hero Header -->
<div class="relative bg-gradient-to-r from-gray-900 via-gray-800 to-black pt-32 pb-16 px-6">
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.03\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    
    <div class="relative z-10 max-w-7xl mx-auto text-center">
        <h1 class="text-5xl md:text-6xl font-semibold text-white mb-4">
            <?php echo htmlspecialchars($title); ?>
        </h1>
        <p class="text-xl text-gray-300">
            Manage your <span class="text-[--color-primary-orange] font-semibold">product inventory</span> and pricing
        </p>
    </div>
</div>

<!-- Main Content -->
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-6">
        <?php if (isset($error) && $error): ?>
            <div class="bg-red-50 border-2 border-red-200 rounded-xl p-4 mb-6 flex items-start gap-3">
                <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <h3 class="font-bold text-red-900">Error!</h3>
                    <p class="text-red-700 text-sm"><?php echo htmlspecialchars($error); ?></p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Action Bar -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
            <a href="<?php echo BASE_URL; ?>/admin/products/create" class="px-8 py-3 bg-gradient-to-r from-[--color-primary-orange] to-orange-600 text-white font-bold rounded-xl shadow-lg hover:shadow-2xl transition-all transform hover:scale-105 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Add New Product
            </a>
            <a href="<?php echo BASE_URL; ?>/admin" class="flex items-center gap-2 text-[--color-primary-orange] hover:text-orange-600 font-semibold transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Dashboard
            </a>
        </div>

        <!-- Search Bar -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8">
            <form action="<?php echo BASE_URL; ?>/admin/products" method="GET" class="flex flex-col sm:flex-row gap-4">
                <input type="text" name="search" placeholder="Search by name or description..."
                       value="<?php echo htmlspecialchars($currentSearch ?? ''); ?>"
                       class="flex-1 px-5 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[--color-primary-orange] transition-colors">
                <button type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-[--color-primary-orange] to-orange-600 text-white font-bold rounded-xl hover:shadow-lg transition-all">
                    Search
                </button>
                <?php if (!empty($currentSearch) || !empty($currentCategory)): ?>
                    <a href="<?php echo BASE_URL; ?>/admin/products" class="px-8 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold rounded-xl transition-colors text-center">
                        Clear Filters
                    </a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Category Pills -->
        <div class="mb-8 overflow-x-auto pb-4 scrollbar-hide">
            <div class="flex flex-nowrap gap-3">
                <?php
                $categories = ['CPU', 'GPU', 'Motherboard', 'RAM', 'Storage', 'PSU', 'Case', 'Cooler', 'Keyboard', 'Monitor', 'Mouse'];
                ?>
                <a href="<?php echo BASE_URL; ?>/admin/products?search=<?php echo htmlspecialchars($currentSearch ?? ''); ?>"
                   class="flex-shrink-0 px-6 py-3 rounded-full font-medium transition-all whitespace-nowrap
                   <?php echo empty($currentCategory) ? 'bg-gradient-to-r from-[--color-primary-orange] to-orange-600 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'; ?>">
                    All Products
                </a>
                <?php foreach ($categories as $cat): ?>
                    <a href="<?php echo BASE_URL; ?>/admin/products?category=<?php echo urlencode($cat); ?>&search=<?php echo htmlspecialchars($currentSearch ?? ''); ?>"
                       class="flex-shrink-0 px-6 py-3 rounded-full font-medium transition-all whitespace-nowrap
                       <?php echo ($currentCategory === $cat) ? 'bg-gradient-to-r from-[--color-primary-orange] to-orange-600 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'; ?>">
                        <?php echo htmlspecialchars($cat); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Products Table -->
        <?php if (empty($products)): ?>
            <div class="bg-white rounded-2xl shadow-lg p-16 text-center border border-gray-100">
                <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No products found</h3>
                <p class="text-gray-600">Try adjusting your search or filter criteria</p>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-white border-b-2 border-gray-100">
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Image</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider hidden md:table-cell">Category</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($products as $product): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-900 font-semibold">
                                    #<?php echo htmlspecialchars($product['id']); ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="w-12 h-12 bg-gray-50 rounded-lg flex items-center justify-center p-1">
                                        <img src="<?php echo htmlspecialchars($product['image_url'] ?? 'https://placehold.co/48x48/cbd5e1/475569?text=Img'); ?>"
                                             alt="<?php echo htmlspecialchars($product['name']); ?>" class="w-full h-full object-contain">
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                    <?php echo htmlspecialchars($product['name']); ?>
                                </td>
                                <td class="px-6 py-4 text-sm hidden md:table-cell">
                                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full font-semibold">
                                        <?php echo htmlspecialchars($product['category'] ?? 'N/A'); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-bold text-[--color-primary-orange]">
                                    $<?php echo number_format($product['price'], 2); ?>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <?php if ($product['stock'] > 10): ?>
                                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full font-bold text-xs">
                                            <?php echo htmlspecialchars($product['stock']); ?> in stock
                                        </span>
                                    <?php elseif ($product['stock'] > 0): ?>
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full font-bold text-xs">
                                            <?php echo htmlspecialchars($product['stock']); ?> left
                                        </span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full font-bold text-xs">
                                            Out of stock
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <a href="<?php echo BASE_URL; ?>/admin/products/edit/<?php echo htmlspecialchars($product['id']); ?>"
                                           class="p-2 bg-[--color-primary-orange]/10 hover:bg-[--color-primary-orange]/20 text-[--color-primary-orange] rounded-lg transition-colors" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </a>
                                        <button type="button"
                                                class="js-delete-product-btn p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors"
                                                title="Delete"
                                                data-product-id="<?php echo htmlspecialchars($product['id']); ?>"
                                                data-product-name="<?php echo htmlspecialchars($product['name']); ?>">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<style>
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const successMsg = urlParams.get('success_msg');

        if (successMsg) {
            alertMessage('success', decodeURIComponent(successMsg));
            urlParams.delete('success_msg');
            const newUrl = window.location.pathname + (urlParams.toString() ? '?' + urlParams.toString() : '');
            window.history.replaceState({}, document.title, newUrl);
        }
    });
</script>