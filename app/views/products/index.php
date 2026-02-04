<!-- Hero Header -->
<div class="relative bg-gradient-to-r from-gray-900 via-gray-800 to-black pt-32 pb-16 px-6">
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.03\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    
    <div class="relative z-10 max-w-7xl mx-auto text-center">
        <h1 class="text-5xl md:text-6xl font-semibold text-white mb-4">
            <?php echo htmlspecialchars($title); ?>
        </h1>
        <p class="text-xl text-gray-300">
            Your <span class="text-[--color-primary-orange] font-semibold">perfect build</span> starts here
        </p>
    </div>
</div>

<!-- Main Content -->
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-6">
        <!-- Search and Filters -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
            <form action="<?php echo BASE_URL; ?>/products" method="GET" class="flex flex-col lg:flex-row gap-4">
                <div class="flex-1 relative">
                    <input type="text" name="search" placeholder="Search products..." 
                           value="<?php echo htmlspecialchars($currentSearch ?? ''); ?>"
                           class="w-full px-5 py-3 pl-12 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[--color-primary-orange] transition-colors">
                    <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                
                <div class="relative">
                    <select name="category" class="appearance-none px-5 py-3 pr-10 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[--color-primary-orange] transition-colors bg-white cursor-pointer">
                        <option value="">All Categories</option>
                        <?php
                        $categories = ['CPU', 'GPU', 'Motherboard', 'RAM', 'Storage', 'PSU', 'Case', 'Cooler', 'Keyboard', 'Monitor', 'Mouse'];
                        foreach ($categories as $cat) {
                            $selected = ($currentCategory === $cat) ? 'selected' : '';
                            echo "<option value=\"{$cat}\" {$selected}>{$cat}</option>";
                        }
                        ?>
                    </select>
                    <svg class="w-5 h-5 text-gray-400 absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
                
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-[--color-primary-orange] to-orange-600 text-white font-bold rounded-xl hover:shadow-lg transition-all transform hover:scale-105">
                    Apply Filters
                </button>
            </form>
        </div>

        <!-- Category Pills -->
        <div class="mb-8 overflow-x-auto pb-2" style="scrollbar-width: thin; scrollbar-color:rgba(33, 45, 73, 0.26) #f3f4f6;">
            <div class="flex gap-3 min-w-max">
                <a href="<?php echo BASE_URL; ?>/products?search=<?php echo htmlspecialchars($currentSearch ?? ''); ?>"
                   class="px-6 py-3 rounded-full font-medium transition-all <?php echo empty($currentCategory) ? 'bg-gradient-to-r from-[--color-primary-orange] to-orange-600 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'; ?>">
                    All Products
                </a>
                <?php foreach ($categories as $cat): ?>
                    <a href="<?php echo BASE_URL; ?>/products?category=<?php echo htmlspecialchars($cat); ?>&search=<?php echo htmlspecialchars($currentSearch ?? ''); ?>"
                       class="px-6 py-3 rounded-full font-medium transition-all whitespace-nowrap <?php echo ($currentCategory === $cat) ? 'bg-gradient-to-r from-[--color-primary-orange] to-orange-600 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'; ?>">
                        <?php echo htmlspecialchars($cat); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <?php if (empty($products)): ?>
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-lg p-16 text-center border border-gray-100">
                <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No products found</h3>
                <p class="text-gray-600">Try adjusting your search or filter to find what you're looking for</p>
            </div>
        <?php else: ?>
            <!-- Products Grid -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                <?php foreach ($products as $product): ?>
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-orange-200 hover:-translate-y-2">
                        <!-- Product Image -->
                        <div class="relative bg-gray-50 aspect-square flex items-center justify-center p-6 overflow-hidden">
                            <img src="<?php echo htmlspecialchars($product['image_url'] ?? 'https://placehold.co/400x400/e2e8f0/475569?text=No+Image'); ?>"
                                 alt="<?php echo htmlspecialchars($product['name']); ?>"
                                 class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                            
                            <!-- Stock Badge -->
                            <div class="absolute top-4 right-4">
                                <?php if ($product['stock'] > 10): ?>
                                    <span class="px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full">In Stock</span>
                                <?php elseif ($product['stock'] > 0): ?>
                                    <span class="px-3 py-1 bg-yellow-500 text-white text-xs font-bold rounded-full">Low Stock</span>
                                <?php else: ?>
                                    <span class="px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full">Out of Stock</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Product Info -->
                        <div class="p-6">
                            <span class="inline-block px-3 py-1 bg-gray-100 text-gray-600 text-xs font-semibold rounded-full mb-3">
                                <?php echo htmlspecialchars($product['category']); ?>
                            </span>
                            
                            <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 h-14">
                                <?php echo htmlspecialchars($product['name']); ?>
                            </h3>
                            
                            <div class="flex items-baseline justify-between mb-4">
                                <span class="text-3xl font-semibold text-[--color-primary-orange]">
                                    $<?php echo number_format($product['price'], 2); ?>
                                </span>
                                <span class="text-sm text-gray-500">
                                    Stock: <strong><?php echo htmlspecialchars($product['stock']); ?></strong>
                                </span>
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex gap-2">
                                <a href="<?php echo BASE_URL; ?>/products/<?php echo htmlspecialchars($product['id']); ?>"
                                   class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold rounded-xl transition-colors text-center">
                                    Details
                                </a>
                                <button onclick="openQuantityModal(<?php echo htmlspecialchars(json_encode($product)); ?>)"
                                        class="flex-1 px-4 py-3 bg-gradient-to-r from-[--color-primary-orange] to-orange-600 text-white font-semibold rounded-xl hover:shadow-lg transition-all <?php echo ($product['stock'] <= 0) ? 'opacity-50 cursor-not-allowed' : ''; ?>"
                                        <?php echo ($product['stock'] <= 0) ? 'disabled' : ''; ?>>
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center items-center gap-2">
                <?php if ($currentPage > 1): ?>
                    <a href="<?php echo BASE_URL; ?>/products?page=<?php echo $currentPage - 1; ?><?php echo $currentCategory ? '&category=' . htmlspecialchars($currentCategory) : ''; ?><?php echo $currentSearch ? '&search=' . htmlspecialchars($currentSearch) : ''; ?>"
                       class="px-5 py-3 bg-white border-2 border-gray-200 text-gray-700 font-medium rounded-xl hover:border-[--color-primary-orange] hover:text-[--color-primary-orange] transition-colors">
                        ← Previous
                    </a>
                <?php endif; ?>

                <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                    <a href="<?php echo BASE_URL; ?>/products?page=<?php echo $i; ?><?php echo $currentCategory ? '&category=' . htmlspecialchars($currentCategory) : ''; ?><?php echo $currentSearch ? '&search=' . htmlspecialchars($currentSearch) : ''; ?>"
                       class="w-12 h-12 flex items-center justify-center font-bold rounded-xl transition-all <?php echo ($i === $currentPage) ? 'bg-gradient-to-r from-[--color-primary-orange] to-orange-600 text-white shadow-md' : 'bg-white border-2 border-gray-200 text-gray-700 hover:border-[--color-primary-orange] hover:text-[--color-primary-orange]'; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages): ?>
                    <a href="<?php echo BASE_URL; ?>/products?page=<?php echo $currentPage + 1; ?><?php echo $currentCategory ? '&category=' . htmlspecialchars($currentCategory) : ''; ?><?php echo $currentSearch ? '&search=' . htmlspecialchars($currentSearch) : ''; ?>"
                       class="px-5 py-3 bg-white border-2 border-gray-200 text-gray-700 font-medium rounded-xl hover:border-[--color-primary-orange] hover:text-[--color-primary-orange] transition-colors">
                        Next →
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Quantity Modal -->
<div id="quantity-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-50 transition-opacity duration-300 opacity-0">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md transform scale-95 opacity-0 transition-all duration-300">
        <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">Add to Cart</h3>
        
        <div class="flex flex-col items-center mb-6">
            <img id="modal-product-image" src="" alt="Product" class="w-40 h-40 object-contain mb-4 rounded-xl bg-gray-50 p-4">
            <p id="modal-product-name" class="text-xl font-bold text-gray-800 text-center mb-2"></p>
            <p id="modal-product-price" class="text-2xl font-semibold text-[--color-primary-orange] mb-2"></p>
            <p id="modal-product-stock" class="text-sm text-gray-600"></p>
        </div>
        
        <div class="flex items-center justify-center gap-4 mb-8">
            <button id="modal-quantity-minus" class="w-12 h-12 rounded-xl bg-gray-100 hover:bg-gray-200 transition-colors flex items-center justify-center">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                </svg>
            </button>
            <span id="modal-quantity-display" class="text-3xl font-semibold text-gray-900 w-20 text-center">1</span>
            <button id="modal-quantity-plus" class="w-12 h-12 rounded-xl bg-gray-100 hover:bg-gray-200 transition-colors flex items-center justify-center">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </button>
            <input type="hidden" id="quantity-input" value="1">
        </div>
        
        <p id="quantity-error" class="text-red-500 text-sm text-center mb-4 hidden"></p>
        
        <div class="flex gap-3">
            <button id="cancel-quantity" class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold rounded-xl transition-colors">
                Cancel
            </button>
            <button id="add-to-cart-modal-btn" class="flex-1 px-6 py-3 bg-gradient-to-r from-[--color-primary-orange] to-orange-600 text-white font-bold rounded-xl hover:shadow-lg transition-all">
                Add to Cart
            </button>
        </div>
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
