function getCart() {
    const cart = localStorage.getItem('pcbuild_cart');
    return cart ? JSON.parse(cart) : [];
}
function saveCart(cart) {
    localStorage.setItem('pcbuild_cart', JSON.stringify(cart));
    updateCartCount();
}

function initializeNewOrderNotification() {
    const orderHistoryLink = document.getElementById('order-history-link');
    const newOrderNotificationSpan = document.getElementById('new-order-notification');

    if (!orderHistoryLink || !newOrderNotificationSpan) {
        return;
    }
    if (typeof hasNewOrderNotification !== 'undefined' && hasNewOrderNotification) {
        newOrderNotificationSpan.classList.remove('hidden');
    } else {
        newOrderNotificationSpan.classList.add('hidden');
    }
    orderHistoryLink.addEventListener('click', (e) => {
        newOrderNotificationSpan.classList.add('hidden');
        performActionViaFetch(BASE_URL + '/user/clear-order-notification', 'POST', {});
    });
}

/**
 * @param {string} url
 * @param {string} method
 * @param {object} body
 * @returns {Promise<object>}
 */
async function performActionViaFetch(url, method, body = {}) {
    const options = {
        method: method,
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
    };

    if (method === 'POST') {
        const formData = new URLSearchParams();
        for (const key in body) {
            formData.append(key, body[key]);
        }
        options.body = formData.toString();
    }

    try {
        const response = await fetch(url, options);
        if (!response.ok) {
            const errorData = await response.json().catch(() => ({ error: 'Unknown error', message: response.statusText }));
            throw new Error(errorData.error || errorData.message || `HTTP error! status: ${response.status}`);
        }
        return await response.json();
    } catch (error) {
        throw error;
    }
}

function addToCart(productId, productName, productPrice, productImage, quantity = 1) {
    if (isLoggedIn) { 
        performActionViaFetch(BASE_URL + '/cart/add', 'POST', {
            product_id: productId,
            quantity: quantity
        }).then(response => {
            if (response.success) {
                alertMessage('success', `${productName} added to cart!`);
                updateCartCount();
            } else {
                alertMessage('error', response.error || 'Failed to add to cart.');
            }
        }).catch(error => {
            alertMessage('error', 'An error occurred while adding to cart.');
        });
    } else {
        let cart = getCart();
        const existingItemIndex = cart.findIndex(item => String(item.id) === String(productId));

        if (existingItemIndex > -1) {
            cart[existingItemIndex].quantity += quantity;
        } else {
            cart.push({
                id: productId,
                name: productName,
                price: parseFloat(productPrice),
                image: productImage,
                quantity: quantity
            });
        }
        saveCart(cart);
        alertMessage('success', `${productName} added to cart!`);
    }
}

function updateCartItemQuantity(productId, newQuantity) {
    if (isLoggedIn) {
        performActionViaFetch(BASE_URL + '/cart/update-quantity', 'POST', {
            product_id: productId,
            quantity: newQuantity
        }).then(response => {
            if (response.success) {
                alertMessage('success', response.message);
                if (window.location.pathname.includes('/cart')) {
                    renderCartItems();
                }
                updateCartCount();
            } else {
                alertMessage('error', response.error || 'Failed to update quantity.');
            }
        }).catch(error => {
            alertMessage('error', 'An error occurred while updating quantity.');
        });
    } else {
        let cart = getCart();
        const itemIndex = cart.findIndex(item => String(item.id) === String(productId));

        if (itemIndex > -1) {
            const quantityToSet = Math.max(0, newQuantity);

            if (quantityToSet > 0) {
                cart[itemIndex].quantity = quantityToSet;
            } else {
                cart.splice(itemIndex, 1);
            }
            saveCart(cart);
            if (window.location.pathname.includes('/cart')) {
                renderCartItems();
            }
        }
    }
}

function removeFromCart(productId) {
    if (isLoggedIn) {
        performActionViaFetch(BASE_URL + '/cart/remove', 'POST', {
            product_id: productId
        }).then(response => {
            if (response.success) {
                alertMessage('success', response.message || 'Item removed from cart.');
                if (window.location.pathname.includes('/cart')) {
                    renderCartItems();
                }
                updateCartCount();
            } else {
                alertMessage('error', response.error || 'Failed to remove item.');
            }
        }).catch(error => {
            alertMessage('error', 'An error occurred while removing item.');
        });
    } else {
        let cart = getCart();
        cart = cart.filter(item => String(item.id) !== String(productId));
        saveCart(cart);
        alertMessage('success', 'Item removed from cart.');
        if (window.location.pathname.includes('/cart')) {
            renderCartItems();
        }
    }
}

function clearCart() {
    if (isLoggedIn) {
        performActionViaFetch(BASE_URL + '/cart/clear', 'POST', {})
            .then(response => {
                if (response.success) {
                    alertMessage('success', response.message || 'Cart cleared!');
                    if (window.location.pathname.includes('/cart')) {
                        renderCartItems();
                    }
                    updateCartCount();
                } else {
                    alertMessage('error', response.error || 'Failed to clear cart.');
                }
            })
            .catch(error => {
                alertMessage('error', 'An error occurred while clearing cart.');
            });
    } else {
        localStorage.setItem('pcbuild_cart', JSON.stringify([]));
        updateCartCount();
        if (window.location.pathname.includes('/cart')) {
            renderCartItems();
        }
        alertMessage('success', 'Cart cleared!');
    }
}

// Function to update the cart count displayed in the header
function updateCartCount() {
    const cartCountElement = document.getElementById('cart-item-count');
    if (!cartCountElement) return;

    if (isLoggedIn) {
        performActionViaFetch(BASE_URL + '/cart/get', 'GET')
            .then(response => {
                if (response.success && response.cart) {
                    const totalItems = response.cart.reduce((sum, item) => sum + item.quantity, 0);
                    cartCountElement.textContent = totalItems > 0 ? totalItems : '';
                    cartCountElement.classList.toggle('hidden', totalItems === 0);
                } else {
                    cartCountElement.textContent = '';
                    cartCountElement.classList.add('hidden');
                }
            })
            .catch(error => {
                cartCountElement.textContent = '';
                cartCountElement.classList.add('hidden');
            });
    } else {
        const cart = getCart();
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        cartCountElement.textContent = totalItems > 0 ? totalItems : '';
        cartCountElement.classList.toggle('hidden', totalItems === 0);
    }
}

async function syncLocalCartToServer() {
    const localCart = getCart();
    if (localCart.length > 0) {
        try {
            const response = await performActionViaFetch(BASE_URL + '/cart/sync', 'POST', {
                cart: JSON.stringify(localCart)
            });
            if (response.success) {
                localStorage.removeItem('pcbuild_cart');
                updateCartCount();
            }
        } catch (error) {
            alertMessage('error', 'An error occurred during cart synchronization.');
        }
    }
}

// Global variables for the modal and current product
let currentProduct = null;
const quantityModal = document.getElementById('quantity-modal');
const modalProductName = document.getElementById('modal-product-name');
const modalProductPrice = document.getElementById('modal-product-price');
const modalProductImage = document.getElementById('modal-product-image');
const modalProductStock = document.getElementById('modal-product-stock');
const modalQuantityDisplay = document.getElementById('modal-quantity-display');
const modalQuantityInputHidden = document.getElementById('quantity-input');
const modalQuantityError = document.getElementById('quantity-error');
const addToCartModalBtn = document.getElementById('add-to-cart-modal-btn');
const cancelQuantityBtn = document.getElementById('cancel-quantity');

/**
 * Sets up quantity increment/decrement controls for a given quantity display and hidden input.
 * @param {HTMLElement} container
 * @param {string} displayId
 * @param {string} hiddenInputId
 * @param {string} minusBtnId
 * @param {string} plusBtnId
 * @param {string} errorId
 * @param {number} maxStock
 */
function setupQuantityControls(container, displayId, hiddenInputId, minusBtnId, plusBtnId, errorId, maxStock) {
    const quantityDisplay = document.getElementById(displayId);
    const quantityHiddenInput = document.getElementById(hiddenInputId);
    const minusBtn = document.getElementById(minusBtnId);
    const plusBtn = document.getElementById(plusBtnId);
    const errorElement = document.getElementById(errorId);

    if (!quantityDisplay || !quantityHiddenInput || !minusBtn || !plusBtn || !errorElement) {
        return;
    }

    let currentQuantity = parseInt(quantityHiddenInput.value) || 1;
    quantityDisplay.textContent = currentQuantity;
    errorElement.classList.add('hidden');

    const updateQuantity = (newQuantity) => {
        newQuantity = Math.max(1, newQuantity);
        newQuantity = Math.min(newQuantity, maxStock);

        currentQuantity = newQuantity;
        quantityDisplay.textContent = currentQuantity;
        quantityHiddenInput.value = currentQuantity;
        if (errorElement) {
             errorElement.classList.add('hidden');
        }

        // Disable buttons if limits are reached
        minusBtn.disabled = currentQuantity <= 1;
        plusBtn.disabled = currentQuantity >= maxStock;

        minusBtn.classList.toggle('opacity-50', currentQuantity <= 1);
        minusBtn.classList.toggle('cursor-not-allowed', currentQuantity <= 1);
        plusBtn.classList.toggle('opacity-50', currentQuantity >= maxStock);
        plusBtn.classList.toggle('cursor-not-allowed', currentQuantity >= maxStock);
    };

    updateQuantity(currentQuantity);
    minusBtn.onclick = () => updateQuantity(currentQuantity - 1);
    plusBtn.onclick = () => updateQuantity(currentQuantity + 1);

    // If stock is 0, disable buttons
    if (maxStock <= 0) {
        minusBtn.disabled = true;
        plusBtn.disabled = true;
        minusBtn.classList.add('opacity-50', 'cursor-not-allowed');
        plusBtn.classList.add('opacity-50', 'cursor-not-allowed');
        quantityDisplay.textContent = 0;
        quantityHiddenInput.value = 0;
    }
}

function openQuantityModal(product) {
    currentProduct = product;

    modalProductImage.src = product.image_url || 'https://placehold.co/128x128/e2e8f0/475569?text=No+Image';
    modalProductName.textContent = product.name;
    modalProductPrice.textContent = `$${parseFloat(product.price).toFixed(2)}`;
    modalProductStock.textContent = `Available Stock: ${product.stock}`;
    modalQuantityInputHidden.value = 1;
    setupQuantityControls(quantityModal.querySelector('.bg-white'), 'modal-quantity-display', 'quantity-input', 'modal-quantity-minus', 'modal-quantity-plus', 'quantity-error', product.stock);

    if (product.stock <= 0) {
        modalProductStock.classList.remove('text-green-600');
        modalProductStock.classList.add('text-red-600');
        addToCartModalBtn.disabled = true;
        addToCartModalBtn.classList.add('opacity-50', 'cursor-not-allowed');
    } else {
        modalProductStock.classList.remove('text-red-600');
        modalProductStock.classList.add('text-green-600');
        addToCartModalBtn.disabled = false;
        addToCartModalBtn.classList.remove('opacity-50', 'cursor-not-allowed');
    }

    // Show modal with animation
    quantityModal.classList.remove('hidden', 'pointer-events-none');
    setTimeout(() => {
        quantityModal.classList.add('opacity-100');
        quantityModal.querySelector('div').classList.remove('scale-95', 'opacity-0');
        quantityModal.querySelector('div').classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeQuantityModal() {
    quantityModal.classList.remove('opacity-100');
    quantityModal.querySelector('div').classList.remove('scale-100', 'opacity-100');
    quantityModal.querySelector('div').classList.add('scale-95', 'opacity-0');
    quantityModal.addEventListener('transitionend', () => {
        quantityModal.classList.add('hidden', 'pointer-events-none');
    }, { once: true });
    currentProduct = null;
    modalQuantityError.classList.add('hidden');
}

if (addToCartModalBtn) {
    addToCartModalBtn.addEventListener('click', () => {
        const quantity = parseInt(modalQuantityInputHidden.value);

        if (isNaN(quantity) || quantity <= 0) {
            modalQuantityError.textContent = 'Please enter a valid quantity greater than 0.';
            modalQuantityError.classList.remove('hidden');
            return;
        }
        if (quantity > currentProduct.stock) {
            modalQuantityError.textContent = `You can only add up to ${currentProduct.stock} units.`;
            modalQuantityError.classList.remove('hidden');
            return;
        }
        addToCart(currentProduct.id, currentProduct.name, currentProduct.price, currentProduct.image_url, quantity);
        closeQuantityModal();
    });
}

if (cancelQuantityBtn) {
    cancelQuantityBtn.addEventListener('click', () => {
        closeQuantityModal();
    });
}

if (quantityModal) {
    quantityModal.addEventListener('click', (e) => {
        if (e.target === quantityModal) {
            closeQuantityModal();
        }
    });
}

// Event listener for adding to cart on the product show page (products/show.php)
document.addEventListener('DOMContentLoaded', () => {
    const addToCartPageBtn = document.getElementById('add-to-cart-page-btn');
    if (addToCartPageBtn) {
        const productId = addToCartPageBtn.dataset.productId;
        const productName = addToCartPageBtn.dataset.productName;
        const productPrice = addToCartPageBtn.dataset.productPrice;
        const productImage = addToCartPageBtn.dataset.productImage;
        const productStock = parseInt(addToCartPageBtn.dataset.productStock);
        // Use document as container since IDs are unique
        const pageQuantityDisplay = document.getElementById('page-quantity-display');
        if (pageQuantityDisplay) {
            setupQuantityControls(document, 'page-quantity-display', 'page-quantity-value', 'page-quantity-minus', 'page-quantity-plus', 'page-quantity-error', productStock);
        }

        const stockDisplay = document.getElementById('product-stock-display');
        if (productStock <= 0) {
            addToCartPageBtn.disabled = true;
            addToCartPageBtn.classList.add('opacity-50', 'cursor-not-allowed');
            if (stockDisplay) {
                stockDisplay.classList.remove('text-green-600');
                stockDisplay.classList.add('text-red-600');
            }
        } else {
             addToCartPageBtn.disabled = false;
             addToCartPageBtn.classList.remove('opacity-50', 'cursor-not-allowed');
             if (stockDisplay) {
                 stockDisplay.classList.remove('text-red-600');
                 stockDisplay.classList.add('text-green-600');
             }
        }

        addToCartPageBtn.addEventListener('click', () => {
            const quantity = parseInt(document.getElementById('page-quantity-value').value);
            const errorElement = document.getElementById('page-quantity-error');

            if (isNaN(quantity) || quantity <= 0) {
                errorElement.textContent = 'Please enter a valid quantity greater than 0.';
                errorElement.classList.remove('hidden');
                return;
            }

            if (quantity > productStock) {
                errorElement.textContent = `You can only add up to ${productStock} units.`;
                errorElement.classList.remove('hidden');
                return;
            }

            addToCart(productId, productName, productPrice, productImage, quantity);
        });
    }
});

// Custom toast notification system
function alertMessage(type, message, title = null) {
    const container = document.getElementById('toast-container');
    if (!container) return;

    // Set default titles if not provided
    const titles = {
        success: title || 'Success!',
        error: title || 'Error!',
        warning: title || 'Warning!',
        info: title || 'Did you know?'
    };

    // SVG icons for each type
    const icons = {
        success: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>`,
        error: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>`,
        warning: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>`,
        info: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
        </svg>`
    };

    // Create toast element
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.innerHTML = `
        <div class="toast-icon">
            ${icons[type] || icons.info}
        </div>
        <div class="toast-content">
            <div class="toast-title">${titles[type] || titles.info}</div>
            <div class="toast-message">${message}</div>
        </div>
        <div class="toast-close">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </div>
    `;

    // Add to container
    container.appendChild(toast);

    // Trigger show animation
    setTimeout(() => {
        toast.classList.add('show');
    }, 10);

    // Close button functionality
    const closeBtn = toast.querySelector('.toast-close');
    closeBtn.addEventListener('click', () => {
        removeToast(toast);
    });

    // Auto remove after 5 seconds
    setTimeout(() => {
        removeToast(toast);
    }, 5000);
}

function removeToast(toast) {
    if (!toast || !toast.parentElement) return;
    
    toast.classList.remove('show');
    toast.classList.add('hide');
    
    setTimeout(() => {
        if (toast.parentElement) {
            toast.remove();
        }
    }, 300);
}

// Additional helper function to show toasts with custom titles
function showToast(type, message, title = null) {
    alertMessage(type, message, title);
}

function initializePasswordToggle() {
    document.querySelectorAll('.toggle-password-visibility').forEach(toggleBtn => {
        const targetId = toggleBtn.dataset.target;
        const passwordInput = document.getElementById(targetId);
        const eyeShow = toggleBtn.querySelector('.eye-show-password');
        const eyeHide = toggleBtn.querySelector('.eye-hide-password');

        const updateIconVisibility = () => {
            if (passwordInput.type === 'password') {
                eyeShow.classList.remove('hidden');
                eyeHide.classList.add('hidden');
            } else {
                eyeShow.classList.add('hidden');
                eyeHide.classList.remove('hidden');
            }
        };

        if (passwordInput.value === '') {
            toggleBtn.classList.add('hidden');
        } else {
            toggleBtn.classList.remove('hidden');
            updateIconVisibility();
        }

        toggleBtn.addEventListener('click', () => {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
            updateIconVisibility();
            passwordInput.focus();
        });
        passwordInput.addEventListener('input', () => {
            if (passwordInput.value === '') {
                toggleBtn.classList.add('hidden');
            } else {
                toggleBtn.classList.remove('hidden');
                if (passwordInput.type === 'password') {
                    eyeShow.classList.remove('hidden');
                    eyeHide.classList.add('hidden');
                }
            }
        });
        passwordInput.addEventListener('focus', () => {
            if (passwordInput.value !== '') {
                toggleBtn.classList.remove('hidden');
                updateIconVisibility();
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    updateCartCount();
    initializeAiChat();
    initializePasswordToggle();
    initializeLogoutConfirmation();
    initializeConfirmationModals();
    if (typeof performCartSync !== 'undefined' && performCartSync) {
        syncLocalCartToServer();
    }

    // Initialize new order notification
    initializeNewOrderNotification();
    initializeDismissibleAlerts();
    initializeNewsletterSubscription();
});

function renderCartItems() {
    const cartItemsContainer = document.getElementById('cart-items-container');
    const emptyCartState = document.getElementById('empty-cart-state');
    if (!cartItemsContainer || !emptyCartState) return;
    const checkoutSection = document.getElementById('checkout-section');
    let subtotal = 0;

    if (isLoggedIn) {
        performActionViaFetch(BASE_URL + '/cart/get', 'GET')
            .then(response => {
                if (response.success && response.cart) {
                    displayCartContent(response.cart);
                } else {
                    cartItemsContainer.innerHTML = '';
                    cartItemsContainer.classList.add('hidden');
                    emptyCartState.classList.remove('hidden');
                    checkoutSection.classList.add('hidden');
                    updateCheckoutButtonState(0, false);
                }
            })
            .catch(error => {
                cartItemsContainer.innerHTML = '';
                cartItemsContainer.classList.add('hidden');
                emptyCartState.classList.remove('hidden');
                checkoutSection.classList.add('hidden');
                updateCheckoutButtonState(0, false);
            });
    } else {
        const cart = getCart();
        displayCartContent(cart);
    }
    function displayCartContent(cart) {
        let cartHtml = '';
        subtotal = 0;

        if (cart.length === 0) {
            cartItemsContainer.innerHTML = '';
            cartItemsContainer.classList.add('hidden');
            emptyCartState.classList.remove('hidden');
            checkoutSection.classList.add('hidden');
            updateCheckoutButtonState(0, false);
        } else {
            emptyCartState.classList.add('hidden');
            cartItemsContainer.classList.remove('hidden');
            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;

                const isMinusDisabled = item.quantity <= 1 ? 'disabled' : '';
                const minusButtonClasses = item.quantity <= 1 ? 'opacity-50 cursor-not-allowed' : '';
                const isPlusDisabled = item.quantity >= item.stock ? 'disabled' : '';
                const plusButtonClasses = item.quantity >= item.stock ? 'opacity-50 cursor-not-allowed' : '';

            cartHtml += `
                <div class="flex flex-wrap items-center border-b border-gray-200 py-4 min-w-0">
                    <img src="${item.image || '/assets/images/placeholder.png'}" alt="${item.name}" class="w-20 h-20 object-contain rounded-md mr-4 flex-shrink-0">
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm sm:text-lg font-semibold text-gray-800 break-words">${item.name}</h3>
                        <p class="text-gray-600 text-sm">$${item.price.toFixed(2)}</p>
                    </div>
                    <div class="flex items-center space-x-2 ml-auto whitespace-nowrap">
                        <button class="quantity-btn p-1 bg-gray-200 rounded-md hover:bg-gray-300 transition-colors ${minusButtonClasses}"
                                onclick="updateCartItemQuantity(${item.id}, ${item.quantity - 1})"
                                ${isMinusDisabled}>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6" />
                            </svg>
                        </button>
                        <span class="text-lg font-semibold text-gray-900 w-12 text-center">${item.quantity}</span>
                        <button class="quantity-btn p-1 bg-gray-200 rounded-md hover:bg-gray-300 transition-colors ${plusButtonClasses}"
                                onclick="updateCartItemQuantity(${item.id}, ${item.quantity + 1})"
                                ${isPlusDisabled}>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m0 0H6" />
                            </svg>
                        </button>
                        <span class="text-lg font-semibold text-gray-800 ml-2">$${itemTotal.toFixed(2)}</span>
                        <button onclick="removeFromCart(${item.id})" class="ml-4 text-red-600 hover:text-red-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            `;
            });
            checkoutSection.classList.remove('hidden');
            updateCheckoutButtonState(cart.length, isLoggedIn);
        }

        cartItemsContainer.innerHTML = cartHtml;
        document.getElementById('cart-subtotal').textContent = subtotal.toFixed(2);
    }
}
function updateCheckoutButtonState(cartItemCount, isUserLoggedIn) {
    const checkoutButton = document.getElementById('proceed-to-checkout-button');
    if (!checkoutButton) return;

    if (cartItemCount === 0) {
        checkoutButton.disabled = true;
        checkoutButton.classList.add('opacity-50', 'cursor-not-allowed');
        checkoutButton.textContent = 'Your cart is empty';
    } else if (!isUserLoggedIn) {
        checkoutButton.disabled = true;
        checkoutButton.classList.add('opacity-50', 'cursor-not-allowed');
        checkoutButton.textContent = 'You must be logged in to checkout';
    } else {
        checkoutButton.disabled = false;
        checkoutButton.classList.remove('opacity-50', 'cursor-not-allowed');
        checkoutButton.innerHTML = `
            Proceed to Checkout
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10.293 15.707a1 1 0 010-1.414L14.586 10l-4.293-4.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                <path fill-rule="evenodd" d="M4.293 15.707a1 1 0 010-1.414L8.586 10l-4.293-4.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
        `;
    }
}

// --- AI Chat Pop-up Logic (Centralized and Initialized) ---
let chatHistory = [];
let chatMessages, userInput, sendButton, chatInputForm, initialAiGreeting;
let initialChatHtmlContent = '';

function initializeAiChat() {
    const aiChatFab = document.getElementById('ai-chat-fab');
    const aiChatSidebar = document.getElementById('ai-chat-sidebar');
    const closeChatSidebarButton = document.getElementById('close-chat-sidebar');
    const newChatButton = document.getElementById('new-chat-button');
    const chatContentPlaceholder = document.getElementById('ai-chat-content-placeholder');
    const body = document.body;

    async function loadInitialChatContent() {
        try {
            const response = await fetch(BASE_URL + '/ai-chat-content');
            const htmlContent = await response.text();

            if (response.ok) {
                chatContentPlaceholder.innerHTML = htmlContent;
                chatMessages = document.getElementById('chat-messages');
                userInput = document.getElementById('user-input');
                sendButton = document.getElementById('send-button');
                chatInputForm = document.getElementById('chat-input-form');
                initialAiGreeting = document.getElementById('initial-ai-greeting');
                initialChatHtmlContent = chatMessages.innerHTML;
                if (chatHistory.length > 0) {
                    if (initialAiGreeting) {
                        initialAiGreeting.classList.add('hidden');
                    }
                    chatMessages.innerHTML = '';
                    chatHistory.forEach(msg => appendMessage(msg.role, msg.text));
                } else {
                    if (initialAiGreeting) {
                        initialAiGreeting.classList.remove('hidden');
                    }
                    const initialMessageTextForHistory = "Hello! I'm Kraft-E, your PC Build Assistant.\n\nAsk me anything about PC components, compatibility,\nor general build advice!"; //
                    if (chatHistory.length === 0) {
                        chatHistory.push({ role: "model", text: initialMessageTextForHistory });
                    }
                }
                if (chatInputForm) {
                    chatInputForm.addEventListener('submit', (e) => {
                        e.preventDefault();
                        sendMessage();
                    });
                } else if (sendButton && userInput) {
                    sendButton.addEventListener('click', sendMessage);
                    userInput.addEventListener('keypress', (e) => {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            sendMessage();
                        }
                    });
                }

                if (chatMessages) {
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }

            } else {
                chatContentPlaceholder.innerHTML = `<p class="text-center text-red-600 py-8">Failed to load AI Chat content.</p>`;
            }
        } catch (error) {
            alertMessage('error', 'Could not connect to the AI assistant.');
        }
    }

    // Function to reset the chat to its initial state
    function resetChat() {
        chatHistory = [];
        if (chatMessages && initialChatHtmlContent) {
            chatMessages.innerHTML = initialChatHtmlContent;
        }
        initialAiGreeting = document.getElementById('initial-ai-greeting');
        if (initialAiGreeting) {
            initialAiGreeting.classList.remove('hidden');
        }

        const initialMessageTextForHistory = "Hello! I'm Kraft-E, your PC Build Assistant.\n\nAsk me anything about PC components, compatibility,\nor general build advice!"; //
        chatHistory.push({ role: "model", text: initialMessageTextForHistory });

        if (userInput) {
            userInput.value = '';
            userInput.focus();
        }

        if (chatMessages) {
            chatMessages.scrollTop = 0;
        }
    }

    loadInitialChatContent();

    if (aiChatFab) {
        aiChatFab.addEventListener('click', () => {
            aiChatSidebar.classList.add('open');
            body.classList.add('ai-chat-open');
            if (chatMessages) {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
            if (userInput) {
                userInput.focus();
            }
        });
    }

    if (closeChatSidebarButton) {
        closeChatSidebarButton.addEventListener('click', () => {
            aiChatSidebar.classList.remove('open');
            body.classList.remove('ai-chat-open');
        });
    }

    if (newChatButton) {
        newChatButton.addEventListener('click', resetChat);
    }

    document.addEventListener('click', (event) => {
        if (aiChatSidebar && aiChatFab && aiChatSidebar.classList.contains('open') &&
            !aiChatSidebar.contains(event.target) &&
            !aiChatFab.contains(event.target)) {
            aiChatSidebar.classList.remove('open');
            body.classList.remove('ai-chat-open');
        }
    });
}

function appendMessage(role, text) {
    if (!chatMessages) {
        return;
    }

    const messageDiv = document.createElement('div');
    messageDiv.className = `flex items-start ${role === 'user' ? 'justify-end' : ''} p-2`;

    const avatar = document.createElement('div');
    avatar.className = `flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center text-white font-bold text-sm ${role === 'user' ? 'bg-[--color-primary-orange] ml-3' : 'bg-[--color-dark-blue] mr-3'}`;
    avatar.textContent = role === 'user' ? 'You' : 'AI';

    const textBubble = document.createElement('div');
    textBubble.className = `p-3 rounded-lg max-w-[80%] shadow-sm ${role === 'user' ? 'bg-[--color-primary-orange] text-white ml-auto' : 'bg-gray-200 text-gray-800 mr-auto'} markdown-content`;

    if (role === 'model') {
        textBubble.innerHTML = marked.parse(text);
    } else {
        textBubble.textContent = text;
    }

    if (role === 'user') {
        messageDiv.appendChild(textBubble);
        messageDiv.appendChild(avatar);
    } else {
        messageDiv.appendChild(avatar);
        messageDiv.appendChild(textBubble);
    }

    chatMessages.appendChild(messageDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

async function sendMessage() {
    const prompt = userInput.value.trim();
    if (prompt === '') return;

    if (initialAiGreeting && !initialAiGreeting.classList.contains('hidden')) {
        initialAiGreeting.classList.add('hidden');
        chatMessages.innerHTML = '';
    }

    appendMessage('user', prompt);
    chatHistory.push({ role: "user", text: prompt });

    userInput.value = '';

    sendButton.disabled = true;
    sendButton.innerHTML = `<svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>`;
    sendButton.classList.add('opacity-50', 'cursor-not-allowed');

    try {
        const response = await fetch(BASE_URL + '/ai-chat/api', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ prompt: prompt, history: chatHistory }),
        });

        const data = await response.json();

        if (response.ok) {
            const aiResponse = data.response;
            appendMessage('model', aiResponse);
            chatHistory.push({ role: "model", text: aiResponse });
        } else {
            alertMessage('error', `AI Service error: ${data.error || 'Something went wrong.'}`);
        }
    } catch (error) {
        alertMessage('error', 'Could not connect to the AI assistant.');
    } finally {
        sendButton.disabled = false;
        sendButton.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>`;
        sendButton.classList.remove('opacity-50', 'cursor-not-allowed');
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
}

// --- Logout Confirmation Modal Logic ---
function showLogoutConfirmation() {
    const logoutModal = document.getElementById('logout-confirmation-modal');
    if (logoutModal) {
        logoutModal.classList.remove('hidden', 'pointer-events-none');
        setTimeout(() => {
            logoutModal.classList.add('opacity-100');
            logoutModal.querySelector('div').classList.remove('scale-95', 'opacity-0');
            logoutModal.querySelector('div').classList.add('scale-100', 'opacity-100');
        }, 10);
    }
}

function hideLogoutConfirmation() {
    const logoutModal = document.getElementById('logout-confirmation-modal');
    if (logoutModal) {
        logoutModal.classList.remove('opacity-100');
        logoutModal.querySelector('div').classList.remove('scale-100', 'opacity-100');
        logoutModal.querySelector('div').classList.add('scale-95', 'opacity-0');
        logoutModal.addEventListener('transitionend', () => {
            logoutModal.classList.add('hidden', 'pointer-events-none');
        }, { once: true });
    }
}

function initializeLogoutConfirmation() {
    const logoutButton = document.getElementById('logout-button');
    if (logoutButton) {
        logoutButton.addEventListener('click', (e) => {
            e.preventDefault();
            showLogoutConfirmation();
        });
    }

    const confirmLogoutBtn = document.getElementById('confirm-logout-btn');
    const cancelLogoutBtn = document.getElementById('cancel-logout-btn');

    if (confirmLogoutBtn) {
        confirmLogoutBtn.addEventListener('click', () => {
            const logoutForm = document.getElementById('logout-form');
            if (logoutForm) {
                if (typeof logoutForm.requestSubmit === 'function') {
                    logoutForm.requestSubmit();
                } else {
                    logoutForm.submit();
                }
            } else {
                window.location.href = BASE_URL + '/logout';
            }
        });
    }

    if (cancelLogoutBtn) {
        cancelLogoutBtn.addEventListener('click', () => {
            hideLogoutConfirmation();
        });
    }

    const logoutModal = document.getElementById('logout-confirmation-modal');
    if (logoutModal) {
        logoutModal.addEventListener('click', (e) => {
            if (e.target === logoutModal) {
                hideLogoutConfirmation();
            }
        });
    }
}

function initializeDismissibleAlerts() {
    const dismissibleAlerts = document.querySelectorAll('.js-dismissible-alert');

    dismissibleAlerts.forEach(alertDiv => {
        const dismissBtn = alertDiv.querySelector('.js-dismiss-btn');

        alertDiv.classList.add('transition-opacity', 'duration-300', 'ease-in-out');
        
        alertDiv.classList.remove('opacity-0');
        alertDiv.style.opacity = '1';

        const hideAndRemoveAlert = () => {
            alertDiv.style.opacity = '0';
            alertDiv.style.pointerEvents = 'none';

            setTimeout(() => {
                alertDiv.remove();
            }, 300);
        };

        setTimeout(hideAndRemoveAlert, 5000);

        if (dismissBtn) {
            dismissBtn.addEventListener('click', hideAndRemoveAlert);
        }
    });
}

// --- Custom Confirmation Modal Logic ---
let currentConfirmationCallback = null;

function showConfirmationModal(title, message, callback) {
    const confirmationModal = document.getElementById('confirmation-modal');
    const modalTitle = document.getElementById('confirmation-modal-title');
    const modalMessage = document.getElementById('confirmation-modal-message');

    if (!confirmationModal || !modalTitle || !modalMessage) {
        return;
    }

    modalTitle.textContent = title;
    modalMessage.textContent = message;
    currentConfirmationCallback = callback;

    confirmationModal.classList.remove('hidden', 'pointer-events-none');
    setTimeout(() => {
        confirmationModal.classList.add('opacity-100');
        confirmationModal.querySelector('div').classList.remove('scale-95', 'opacity-0');
        confirmationModal.querySelector('div').classList.add('scale-100', 'opacity-100');
    }, 10);
}

function hideConfirmationModal() {
    const confirmationModal = document.getElementById('confirmation-modal');
    if (confirmationModal) {
        confirmationModal.classList.remove('opacity-100');
        confirmationModal.querySelector('div').classList.remove('scale-100', 'opacity-100');
        confirmationModal.querySelector('div').classList.add('scale-95', 'opacity-0');
        confirmationModal.addEventListener('transitionend', () => {
            confirmationModal.classList.add('hidden', 'pointer-events-none');
        }, { once: true });
    }
}

function initializeConfirmationModals() {
    const confirmationModal = document.getElementById('confirmation-modal');
    const confirmActionBtn = document.getElementById('confirm-action-btn');
    const cancelActionBtn = document.getElementById('cancel-action-btn');

    if (confirmActionBtn) {
        confirmActionBtn.addEventListener('click', () => {
            hideConfirmationModal();
            const callbackToExecute = currentConfirmationCallback;
            currentConfirmationCallback = null;

            if (callbackToExecute) {
                callbackToExecute(true);
            }
        });
    }

    if (cancelActionBtn) {
        cancelActionBtn.addEventListener('click', () => {
            hideConfirmationModal();
            const callbackToExecute = currentConfirmationCallback;
            currentConfirmationCallback = null;

            if (callbackToExecute) {
                callbackToExecute(false);
            }
        });
    }

    if (confirmationModal) {
        confirmationModal.addEventListener('click', (e) => {
            if (e.target === confirmationModal) {
                hideConfirmationModal();
                const callbackToExecute = currentConfirmationCallback;
                currentConfirmationCallback = null;

                if (callbackToExecute) {
                    callbackToExecute(false);
                }
            }
        });
    }

    document.addEventListener('click', (e) => {
        const target = e.target;

        if (target.matches('.js-toggle-ban-btn')) {
            e.preventDefault();
            const userId = target.dataset.userId;
            const username = target.dataset.username;
            const isBanned = target.dataset.isBanned === '1';
            const actionUrl = BASE_URL + `/admin/users/toggle-ban/${userId}`;

            showConfirmationModal(
                isBanned ? 'Unban User' : 'Ban User',
                `Are you sure you want to ${isBanned ? 'unban' : 'ban'} user ${username}?`,
                (confirmed) => {
                    if (confirmed) {
                        performActionViaFetch(actionUrl, 'POST', {})
                            .then(response => {
                                window.location.reload();
                            })
                            .catch(error => {
                                alertMessage('error', 'An error occurred during the ban/unban action.');
                            });
                    }
                }
            );
        }

        if (target.matches('.js-delete-user-btn')) {
            e.preventDefault();
            const userId = target.dataset.userId;
            const username = target.dataset.username;
            const actionUrl = BASE_URL + `/admin/users/delete/${userId}`;

            showConfirmationModal(
                'Delete User',
                `Are you sure you want to delete user ${username}? This action cannot be undone.`,
                (confirmed) => {
                    if (confirmed) {
                        performActionViaFetch(actionUrl, 'POST', {})
                            .then(response => {
                                window.location.reload();
                            })
                            .catch(error => {
                                alertMessage('error', 'An error occurred during the delete action.');
                            });
                    }
                }
            );
        }

        const deleteProductButton = target.closest('.js-delete-product-btn');
        if (deleteProductButton) {
            e.preventDefault();
            const productId = deleteProductButton.dataset.productId;
            const productName = deleteProductButton.dataset.productName;
            const actionUrl = BASE_URL + `/admin/products/delete/${productId}`;

            showConfirmationModal(
                'Delete Product',
                `Are you sure you want to delete product "${productName}"? This action cannot be undone.`,
                (confirmed) => {
                    if (confirmed) {
                        fetch(actionUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: new URLSearchParams({ product_id: productId }).toString(),
                        })
                        .then(response => {
                            if (response.redirected) {
                                window.location.href = response.url;
                            } else {
                                return response.json()
                                    .then(errorData => {
                                        alertMessage('error', errorData.error || 'Deletion failed with unexpected response.');
                                    })
                                    .catch(() => {
                                        alertMessage('error', 'Deletion failed: Unexpected non-redirecting response from server.');
                                    });
                            }
                        })
                        .catch(error => {
                            alertMessage('error', 'A network error occurred during deletion. Please try again.');
                        });
                    }
                }
            );
        }
    });
}

// Handle newsletter subscription form submission (dummy modal)
function initializeNewsletterSubscription() {
    const newsletterForm = document.getElementById('newsletter-form');
    const newsletterEmailInput = document.getElementById('newsletter-email');
    const newsletterSuccessModal = document.getElementById('newsletter-success-modal');
    const newsletterModalCloseBtn = document.getElementById('newsletter-modal-close-btn');

    if (newsletterForm && newsletterEmailInput && newsletterSuccessModal && newsletterModalCloseBtn) {
        newsletterForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const userEmail = newsletterEmailInput.value.trim();

            if (!userEmail) {
                alertMessage('error', 'Please enter your email address.');
                return;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(userEmail)) {
                alertMessage('error', 'Please enter a valid email format.');
                return;
            }

            // --- Dummy Submission Logic ---
            newsletterEmailInput.disabled = true;
            newsletterForm.querySelector('button[type="submit"]').disabled = true;
            newsletterForm.querySelector('button[type="submit"]').textContent = 'Subscribing...';
            newsletterForm.querySelector('button[type="submit"]').classList.add('opacity-50', 'cursor-not-allowed');

            setTimeout(() => {
                newsletterSuccessModal.classList.remove('hidden', 'pointer-events-none');
                setTimeout(() => {
                    newsletterSuccessModal.classList.add('opacity-100');
                    newsletterSuccessModal.querySelector('div').classList.remove('scale-95', 'opacity-0');
                    newsletterSuccessModal.querySelector('div').classList.add('scale-100', 'opacity-100');
                }, 10);

                newsletterEmailInput.value = '';
                newsletterEmailInput.disabled = false;
                newsletterForm.querySelector('button[type="submit"]').disabled = false;
                newsletterForm.querySelector('button[type="submit"]').textContent = 'Subscribe';
                newsletterForm.querySelector('button[type="submit"]').classList.remove('opacity-50', 'cursor-not-allowed');
            }, 1000);

        });

        newsletterModalCloseBtn.addEventListener('click', () => {
            newsletterSuccessModal.classList.remove('opacity-100');
            newsletterSuccessModal.querySelector('div').classList.remove('scale-100', 'opacity-100');
            newsletterSuccessModal.querySelector('div').classList.add('scale-95', 'opacity-0');
            newsletterSuccessModal.addEventListener('transitionend', () => {
                newsletterSuccessModal.classList.add('hidden', 'pointer-events-none');
            }, { once: true });
        });

        newsletterSuccessModal.addEventListener('click', (e) => {
            if (e.target === newsletterSuccessModal) {
                newsletterSuccessModal.classList.remove('opacity-100');
                newsletterSuccessModal.querySelector('div').classList.remove('scale-100', 'opacity-100');
                newsletterSuccessModal.querySelector('div').classList.add('scale-95', 'opacity-0');
                newsletterSuccessModal.addEventListener('transitionend', () => {
                    newsletterSuccessModal.classList.add('hidden', 'pointer-events-none');
                }, { once: true });
            }
        });
    }
}