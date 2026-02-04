<div class="container mx-auto p-8 bg-white shadow-lg rounded-lg mt-40 mb-24 max-w-3xl">
    <h1 class="text-4xl font-extrabold text-gray-900 mb-6 text-center"><?php echo htmlspecialchars($title); ?></h1>

        <?php if (isset($error) && $error): ?>
            <div class="js-dismissible-alert bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-4 transition-all duration-300 ease-in-out" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline"><?php echo htmlspecialchars($error); ?></span>
                <button type="button" class="js-dismiss-btn absolute top-2 right-2 text-red-700 hover:text-red-900 focus:outline-none">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        <?php endif; ?>

    <form action="<?php echo BASE_URL; ?>/admin/products/edit/<?php echo htmlspecialchars($product['id']); ?>" method="POST" class="space-y-6" enctype="multipart/form-data">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Product Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" required
                   value="<?php echo htmlspecialchars($product['name'] ?? ''); ?>"
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[--color-primary-orange] focus:border-[--color-primary-orange] sm:text-sm">
        </div>
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="4"
                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[--color-primary-orange] focus:border-[--color-primary-orange] sm:text-sm"><?php echo htmlspecialchars($product['description'] ?? ''); ?></textarea>
        </div>
        <div>
            <label for="additional_details" class="block text-sm font-medium text-gray-700">Additional Details (Bulleted List)</label>
            <textarea name="additional_details" id="additional_details" rows="6"
                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[--color-primary-orange] focus:border-[--color-primary-orange] sm:text-sm"
                      placeholder="Enter specs here, one per line (e.g.,&#10;• Processor Base Frequency: 3.0 GHz&#10;• Max Turbo Frequency: 4.8 GHz&#10;• Cores: 8&#10;• Threads: 16)"><?php echo htmlspecialchars($product['additional_details'] ?? ''); ?></textarea>
            <p class="mt-1 text-sm text-gray-500">Each line will be displayed as a new bullet point.</p>
        </div>
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700">Price ($) <span class="text-red-500">*</span></label>
            <input type="number" name="price" id="price" step="0.01" min="0.01" required
                   value="<?php echo htmlspecialchars($product['price'] ?? ''); ?>"
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[--color-primary-orange] focus:border-[--color-primary-orange] sm:text-sm">
        </div>
        <div>
            <label for="image_upload" class="block text-sm font-medium text-gray-700">Upload New Image (Optional)</label>
            <input type="file" name="image_upload" id="image_upload" accept="image/*"
                   class="mt-1 block w-full text-sm text-gray-500
                   file:mr-4 file:py-2 file:px-4
                   file:rounded-md file:border-0
                   file:text-sm file:font-semibold
                   file:bg-[--color-dark-blue] file:text-white
                   hover:file:bg-[#1a2d3a]"/>
            <p class="mt-1 text-sm text-gray-500">Upload a new image to replace the current one. Only image files (jpg, png, gif, webp) are allowed. Max 2MB.</p>
            <?php if (!empty($product['image_url'])): ?>
                <div class="mt-2">
                    <label class="block text-sm font-medium text-gray-700">Current Image:</label>
                    <img id="current_product_image_display" src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="Current Product Image" class="mt-2 w-24 h-24 object-contain rounded-md border border-gray-200">
                    </div>
            <?php endif; ?>
        </div>
        <div>
            <label for="category" class="block text-sm font-medium text-gray-700">Category <span class="text-red-500">*</span></label>
            <select name="category" id="category" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[--color-primary-orange] focus:border-[--color-primary-orange] sm:text-sm bg-white">
                <option value="">-- Select Category --</option>
                <?php
                $categories = ['CPU', 'GPU', 'Motherboard', 'RAM', 'Storage', 'PSU', 'Case', 'Cooler', 'Monitor', 'Keyboard', 'Mouse'];
                foreach ($categories as $cat) {
                    $selected = (isset($product['category']) && $product['category'] === $cat) ? 'selected' : '';
                    echo '<option value="' . htmlspecialchars($cat) . '" ' . $selected . '>' . htmlspecialchars($cat) . '</option>';
                }
                ?>
            </select>
        </div>
        <div>
            <label for="stock" class="block text-sm font-medium text-gray-700">Stock Quantity</label>
            <input type="number" name="stock" id="stock" min="0"
                   value="<?php echo htmlspecialchars($product['stock'] ?? '0'); ?>"
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[--color-primary-orange] focus:border-[--color-primary-orange] sm:text-sm">
        </div>

        <div class="flex justify-end space-x-4">
            <a href="<?php echo BASE_URL; ?>/admin/products" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-md shadow-lg transition-colors">
                Cancel
            </a>
            <button type="submit"
                    class="bg-[--color-primary-orange] hover:bg-[#e76c3e] text-white font-bold py-2 px-4 rounded-md shadow-lg transition-colors">
                Update Product
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageUploadInput = document.getElementById('image_upload');
        const currentImageDisplay = document.getElementById('current_product_image_display');

        if (imageUploadInput && currentImageDisplay) {
            imageUploadInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        currentImageDisplay.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>