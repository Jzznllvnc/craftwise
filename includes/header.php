<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo BASE_URL; ?>/assets/images/CraftWise.png" type="image/png">
    <title>CraftWise - Shop Now!</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Lexend:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <style>
        :root {
            --color-primary-orange: #FE7743;
            --color-light-bg: #EFEEEE;
            --color-dark-blue: #273F4F;
            --color-black: #000000;
            --footer-bg-dark: #1A1E26;
            --footer-text-light: #E0E6EB;
            --footer-link-hover: #A0A9B0;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-light-bg);
            color: #334155;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        h1, h2 {
            font-family: 'Lexend', sans-serif;
        }
        .markdown-content p { margin-bottom: 0.5rem; }
        .markdown-content strong { font-weight: bold; }
        .markdown-content em { font-style: italic; }
        .markdown-content ul, .markdown-content ol { list-style-position: inside; margin-left: 1rem; }
        .markdown-content ul { list-style-type: disc; }
        .markdown-content ol { list-style-type: decimal; }
        .markdown-content li { margin-bottom: 0.25rem; }
        .markdown-content h1, .markdown-content h2, .markdown-content h3 { font-weight: bold; margin-top: 1rem; margin-bottom: 0.5rem; }
        .markdown-content h1 { font-size: 1.5rem; }
        .markdown-content h2 { font-size: 1.25rem; }
        .markdown-content h3 { font-size: 1.125rem; }
        .markdown-content pre { background-color: #e2e8f0; padding: 0.75rem; border-radius: 0.375rem; overflow-x: auto; margin-top: 0.5rem; margin-bottom: 0.5rem; font-size: 0.875rem; }
        .markdown-content code { background-color: #e2e8f0; padding: 0.125rem 0.25rem; border-radius: 0.25rem; color: #b91c1c; }
        .markdown-content pre code { background-color: transparent; padding: 0; border-radius: 0; color: inherit; }

        #ai-chat-fab {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            background-color: var(--color-primary-orange);
            color: white;
            border-radius: 9999px;
            padding: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: background-color 0.3s ease;
            cursor: pointer;
            z-index: 1000;
        }
        #ai-chat-fab:hover {
            background-color: #e76c3e;
        }
        #ai-chat-sidebar {
            position: fixed;
            top: 0;
            right: 0;
            width: 100vw;
            height: 100%;
            background-color: white;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
            z-index: 1010;
            display: flex;
            flex-direction: column;
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
            overflow: hidden;
            
            @media (min-width: 768px) {
                width: 448px;
                max-width: 448px;
                height: calc(100vh - 64px);
                top: 64px;
                border-top-left-radius: 0.5rem;
                border-bottom-left-radius: 0.5rem;
            }
        }
        #ai-chat-sidebar.open {
            transform: translateX(0);
        }
        body.ai-chat-open {
             overflow: hidden !important;
        }
        .sidebar-header {
            flex-shrink: 0;
            padding: 1rem;
            background-color: var(--color-dark-blue);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        #ai-chat-content-placeholder {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        #chat-messages {
            flex-grow: 1;
            overflow-y: auto;
            padding: 1rem;
            background-color: var(--color-light-bg);
        }
        .chat-input-area {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            padding: 1rem;
            border-top: 1px solid #e2e8f0;
            background-color: white;
        }
        .main-header {
            background-color: rgba(16, 19, 24, 0.45);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        #logout-confirmation-modal {
            background-color: rgba(0, 0, 0, 0.5);
            transition: opacity 0.3s ease-in-out;
        }

        #logout-confirmation-modal > div {
            transition: all 0.3s ease-in-out;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        input[type="password"]::-ms-reveal,
        input[type="password"]::-webkit-reveal,
        input[type="password"]::-webkit-password-reveal {
            display: none !important;
            -webkit-appearance: none;
            appearance: none;
        }
        @media (min-width: 525px) {
            .mobile-menu {
                background-color: rgba(16, 19, 24, 0.69);
                backdrop-filter: blur(8px);
                -webkit-backdrop-filter: blur(8px);
                box-shadow: 0 8px 10px -5px rgba(0, 0, 0, 0.2);}
            .sm-custom-flex { display: flex; }
            .sm-custom-hidden { display: none; }
        }
        @media (max-width: 1023px) {
            .mobile-menu {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background-color: rgba(16, 19, 24, 0.69);
                backdrop-filter: blur(8px);
                -webkit-backdrop-filter: blur(8px);
                padding: 1rem 0;
                box-shadow: 0 8px 10px -5px rgba(0, 0, 0, 0.2);
                z-index: 40;
            }
            .mobile-menu.active {
                display: flex;
            }
            .mobile-menu a {
                color: white;
                padding: 0.75rem 1rem;
                text-align: center;
                width: 100%;
            }
            .mobile-menu a:hover {
                background-color: rgba(255, 255, 255, 0.1);
            }
            .main-header .desktop-nav-links {
                display: none;
            }
            .main-header .mobile-nav-actions {
                display: flex;
                align-items: center;
                gap: 1rem;
            }
            .mobile-nav-actions a {
                padding: 0.5rem 0.75rem;
                font-size: 0.875rem;
                white-space: nowrap;
            }
            .mobile-nav-actions #logout-button-mobile {
                padding: 0.5rem 0.75rem;
            }
            .mobile-nav-actions #logout-button-mobile img {
                margin-right: 0.25rem;
            }
        }
        @media (max-width: 524px) {
            .main-header .mobile-nav-actions .sm-custom-hidden-below {
                display: none;
            }
            .mobile-menu {
                background-color: rgba(16, 19, 24, 0.69);
                backdrop-filter: blur(8px);
                -webkit-backdrop-filter: blur(8px);
                box-shadow: 0 8px 10px -5px rgba(0, 0, 0, 0.2);
            }
            .mobile-menu a#mobile-profile-link-in-menu,
            .mobile-menu a#logout-button-mobile-menu {
                display: block;
            }
        }
        @media (min-width: 525px) {
            .mobile-menu {
                background-color: rgba(16, 19, 24, 0.69);
                backdrop-filter: blur(8px);
                -webkit-backdrop-filter: blur(8px);
                box-shadow: 0 8px 10px -5px rgba(0, 0, 0, 0.2);
            }
            .mobile-menu .sm-custom-hidden-up {
                display: none !important;
            }
        }
        @media (min-width: 1024px) {
            .main-header .desktop-nav-links {
                display: flex;
            }
            .main-header .mobile-nav-actions {
                display: none;
            }
            .mobile-menu {
                display: none !important;
            }
        }

        /* Toast Notification Styles */
        #toast-container {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 12px;
            pointer-events: none;
        }

        .toast {
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
            padding: 16px 20px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            min-width: 320px;
            max-width: 420px;
            pointer-events: all;
            transform: translateX(400px);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .toast.show {
            transform: translateX(0);
            opacity: 1;
        }

        .toast.hide {
            transform: translateX(400px);
            opacity: 0;
        }

        .toast-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .toast-icon svg {
            width: 24px;
            height: 24px;
        }

        .toast-content {
            flex: 1;
            min-width: 0;
        }

        .toast-title {
            font-weight: 700;
            font-size: 15px;
            margin-bottom: 4px;
            color: #1a1a1a;
        }

        .toast-message {
            font-size: 13px;
            color: #666;
            line-height: 1.4;
            word-wrap: break-word;
        }

        .toast-close {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.2s;
            flex-shrink: 0;
        }

        .toast-close:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .toast-close svg {
            width: 18px;
            height: 18px;
            color: #666;
        }

        /* Success Toast */
        .toast.success {
            border-left: 4px solid #22c55e;
        }

        .toast.success .toast-icon {
            background-color: #dcfce7;
        }

        .toast.success .toast-icon svg {
            color: #22c55e;
        }

        /* Info Toast */
        .toast.info {
            border-left: 4px solid #3b82f6;
        }

        .toast.info .toast-icon {
            background-color: #dbeafe;
        }

        .toast.info .toast-icon svg {
            color: #3b82f6;
        }

        /* Warning Toast */
        .toast.warning {
            border-left: 4px solid #f59e0b;
        }

        .toast.warning .toast-icon {
            background-color: #fef3c7;
        }

        .toast.warning .toast-icon svg {
            color: #f59e0b;
        }

        /* Error Toast */
        .toast.error {
            border-left: 4px solid #ef4444;
        }

        .toast.error .toast-icon {
            background-color: #fee2e2;
        }

        .toast.error .toast-icon svg {
            color: #ef4444;
        }

        /* Mobile responsiveness */
        @media (max-width: 640px) {
            #toast-container {
                top: 10px;
                left: 10px;
                right: 10px;
                transform: none;
            }

            .toast {
                min-width: auto;
                max-width: 100%;
            }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    <header class="main-header text-white p-4 fixed top-0 w-full z-50">
        <nav class="container mx-auto flex justify-between items-center relative">
            <a href="<?php echo BASE_URL; ?>/" class="text-2xl font-bold rounded-md px-3 py-1 hover:bg-gray-700 transition-colors flex items-center">
                <img src="<?php echo BASE_URL; ?>/assets/images/CraftWise.png" alt="CraftWise Logo" class="h-12 w-12 mr-2 object-contain">
                CraftWise
            </a>

            <div class="desktop-nav-links items-center space-x-4">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="<?php echo BASE_URL; ?>/products" class="rounded-md px-3 py-2 text-sm font-medium hover:bg-gray-700 transition-colors">All Products</a>
                    <a href="<?php echo BASE_URL; ?>/orderhistory" id="order-history-link" class="relative rounded-md px-3 py-2 text-sm font-medium hover:bg-gray-700 transition-colors flex items-center">
                        Order History
                        <span id="new-order-notification" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center hidden">
                            1
                        </span>
                    </a>
                    <a href="<?php echo BASE_URL; ?>/build-rate" class="rounded-md px-3 py-2 text-sm font-medium hover:bg-gray-700 transition-colors">Rate Your Build</a>

                    <a href="<?php echo BASE_URL; ?>/cart" class="relative rounded-md px-3 py-2 text-sm font-medium hover:bg-gray-700 transition-colors flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Cart
                        <span id="cart-item-count" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center hidden">
                            </span>
                    </a>

                    <div class="w-4"></div> <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                        <a href="<?php echo BASE_URL; ?>/admin/dashboard" class="rounded-md px-3 py-2 text-sm font-medium hover:bg-gray-700 transition-colors">
                            Administration
                        </a>
                    <?php else: ?>
                        <a href="<?php echo BASE_URL; ?>/profile" class="rounded-md px-3 py-2 text-sm font-medium hover:bg-gray-700 transition-colors">
                            Manage Profile
                        </a>
                    <?php endif; ?>

                    <a href="javascript:void(0);" id="logout-button" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-md shadow-lg transition-colors flex items-center">
                        <img src="<?php echo BASE_URL; ?>/assets/images/logout.svg" alt="Logout Icon" class="h-5 w-5 mr-2 inline" />
                        Logout
                    </a>
                <?php else: ?>
                    <a href="<?php echo BASE_URL; ?>/products" class="rounded-md px-3 py-2 text-sm font-medium hover:bg-gray-700 transition-colors">All Products</a>
                    <a href="<?php echo BASE_URL; ?>/cart" class="relative rounded-md px-3 py-2 text-sm font-medium hover:bg-gray-700 transition-colors flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Cart
                        <span id="cart-item-count" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center hidden">
                            </span>
                    </a>
                    <div class="w-4"></div> <a href="<?php echo BASE_URL; ?>/login" class="bg-[--color-primary-orange] hover:bg-[#e76c3e] text-white font-bold py-2 px-4 rounded-md shadow-lg transition-colors">Login / Register</a>
                <?php endif; ?>
            </div>

            <div class="mobile-nav-actions md:hidden">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                        <a href="<?php echo BASE_URL; ?>/admin/dashboard" class="rounded-md px-2 py-1 text-sm font-medium hover:bg-gray-700 transition-colors sm-custom-hidden-below">
                            Administration
                        </a>
                    <?php else: ?>
                        <a href="<?php echo BASE_URL; ?>/profile" class="rounded-md px-2 py-1 text-sm font-medium hover:bg-gray-700 transition-colors sm-custom-hidden-below">
                            Manage Profile
                        </a>
                    <?php endif; ?>
                    <a href="javascript:void(0);" id="logout-button-mobile" class="bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-2 rounded-md shadow-lg transition-colors flex items-center text-sm sm-custom-hidden-below">
                        <img src="<?php echo BASE_URL; ?>/assets/images/logout.svg" alt="Logout Icon" class="h-4 w-4 mr-1 inline" />
                        Logout
                    </a>
                <?php else: ?>
                    <a href="<?php echo BASE_URL; ?>/login" class="bg-[--color-primary-orange] hover:bg-[#e76c3e] text-white font-bold py-1 px-2 rounded-md shadow-lg transition-colors text-sm sm-custom-hidden-below">Login / Register</a>
                <?php endif; ?>

                <button id="hamburger-button" class="text-white focus:outline-none p-1">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </nav>

        <div id="mobile-menu" class="mobile-menu md:hidden">
            <a href="<?php echo BASE_URL; ?>/products" class="block">All Products</a>
            <a href="<?php echo BASE_URL; ?>/orderhistory" class="block relative">
                Order History
                <span id="new-order-notification-mobile" class="absolute top-1/2 -translate-y-1/2 right-4 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center hidden">1</span>
            </a>
            <a href="<?php echo BASE_URL; ?>/build-rate" class="block">Rate Your Build</a>
            <a href="<?php echo BASE_URL; ?>/cart" class="block relative">
                Cart
                <span id="cart-item-count-mobile" class="absolute top-1/2 -translate-y-1/2 right-4 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center hidden"></span>
            </a>

            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="<?php echo BASE_URL; ?><?php echo (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) ? '/admin/dashboard' : '/profile'; ?>" class="block sm-custom-hidden-up">
                    <?php echo (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) ? 'Administration' : 'Manage Profile'; ?>
                </a>
                <a href="javascript:void(0);" id="logout-button-mobile-menu" class="block sm-custom-hidden-up">
                    <img src="<?php echo BASE_URL; ?>/assets/images/logout.svg" alt="Logout Icon" class="h-4 w-4 mr-2 inline" />
                    Logout
                </a>
            <?php else: ?>
                <a href="<?php echo BASE_URL; ?>/login" class="block sm-custom-hidden-up">Login / Register</a>
            <?php endif; ?>
        </div>

    <script>
        const BASE_URL = '<?php echo BASE_URL; ?>';
        const isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
        const performCartSync = <?php echo isset($_SESSION['sync_cart_on_load']) && $_SESSION['sync_cart_on_load'] === true ? 'true' : 'false'; ?>;
        <?php unset($_SESSION['sync_cart_on_load']);?>

        const hasNewOrderNotification = <?php echo isset($_SESSION['new_order_notification']) && $_SESSION['new_order_notification'] === true ? 'true' : 'false'; ?>;
        <?php unset($_SESSION['new_order_notification']);?>

        document.addEventListener('DOMContentLoaded', () => {
            const hamburgerButton = document.getElementById('hamburger-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const logoutButtonMobile = document.getElementById('logout-button-mobile');
            const logoutButtonMobileMenu = document.getElementById('logout-button-mobile-menu');
            const logoutButtonDesktop = document.getElementById('logout-button');

            if (hamburgerButton) {
                hamburgerButton.addEventListener('click', () => {
                    mobileMenu.classList.toggle('active');
                    document.body.classList.toggle('overflow-hidden');
                });
            }
            const handleLogoutClick = (e) => {
                e.preventDefault();
                if (typeof showLogoutConfirmation === 'function') {
                    showLogoutConfirmation();
                } else {
                    console.error('showLogoutConfirmation function not found. Ensure main.js is loaded.');
                    window.location.href = '<?php echo BASE_URL; ?>/logout';
                }
            };

            if (logoutButtonDesktop) {
                logoutButtonDesktop.addEventListener('click', handleLogoutClick);
            }

            if (logoutButtonMobile) {
                logoutButtonMobile.addEventListener('click', handleLogoutClick);
            }
            if (logoutButtonMobileMenu) {
                logoutButtonMobileMenu.addEventListener('click', handleLogoutClick);
            }

            const newOrderNotificationDesktop = document.getElementById('new-order-notification');
            const newOrderNotificationMobile = document.getElementById('new-order-notification-mobile');

            if (hasNewOrderNotification) {
                if (newOrderNotificationDesktop) newOrderNotificationDesktop.classList.remove('hidden');
                if (newOrderNotificationMobile) newOrderNotificationMobile.classList.remove('hidden');
            } else {
                if (newOrderNotificationDesktop) newOrderNotificationDesktop.classList.add('hidden');
                if (newOrderNotificationMobile) newOrderNotificationMobile.classList.add('hidden');
            }

            const cartItemCountDesktop = document.getElementById('cart-item-count');
            const cartItemCountMobile = document.getElementById('cart-item-count-mobile');

            function updateMobileCartCountDisplay() {
                if (!cartItemCountDesktop || !cartItemCountMobile) return;

                if (isLoggedIn) {
                    if (typeof performActionViaFetch === 'function') {
                        performActionViaFetch('<?php echo BASE_URL; ?>/cart/get', 'GET')
                            .then(response => {
                                if (response.success && response.cart) {
                                    const totalItems = response.cart.reduce((sum, item) => sum + item.quantity, 0);
                                    cartItemCountDesktop.textContent = totalItems > 0 ? totalItems : '';
                                    cartItemCountDesktop.classList.toggle('hidden', totalItems === 0);
                                    cartItemCountMobile.textContent = totalItems > 0 ? totalItems : '';
                                    cartItemCountMobile.classList.toggle('hidden', totalItems === 0);
                                } else {
                                    cartItemCountDesktop.textContent = '';
                                    cartItemCountDesktop.classList.add('hidden');
                                    cartItemCountMobile.textContent = '';
                                    cartItemCountMobile.classList.add('hidden');
                                }
                            })
                            .catch(error => {
                                console.error('Failed to fetch server cart count for mobile:', error);
                                cartItemCountDesktop.textContent = '';
                                cartItemCountDesktop.classList.add('hidden');
                                cartItemCountMobile.textContent = '';
                                cartItemCountMobile.classList.add('hidden');
                            });
                    } else {
                        console.error('performActionViaFetch function not found. Ensure main.js is loaded.');
                        const cart = getCart();
                        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
                        cartItemCountDesktop.textContent = totalItems > 0 ? totalItems : '';
                        cartItemCountDesktop.classList.toggle('hidden', totalItems === 0);
                        cartItemCountMobile.textContent = totalItems > 0 ? totalItems : '';
                        cartItemCountMobile.classList.toggle('hidden', totalItems === 0);
                    }
                } else {
                    const cart = getCart();
                    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
                    cartItemCountDesktop.textContent = totalItems > 0 ? totalItems : '';
                    cartItemCountDesktop.classList.toggle('hidden', totalItems === 0);
                    cartItemCountMobile.textContent = totalItems > 0 ? totalItems : '';
                    cartItemCountMobile.classList.toggle('hidden', totalItems === 0);
                }
            }
            updateMobileCartCountDisplay();
        });
    </script>
</head>
    </header>
    <main class="flex-grow">