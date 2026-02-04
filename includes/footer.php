</main>
    <footer class="bg-[--footer-bg-dark] text-[--footer-text-light] py-10 shadow-inner">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row justify-between items-center lg:items-start text-center lg:text-left space-y-8 lg:space-y-0">
                <div class="flex-shrink-0 lg:w-1/4">
                    <h3 class="text-2xl font-bold text-white mb-2 flex items-center justify-center lg:justify-start">
                        <img src="<?php echo BASE_URL; ?>/assets/images/CraftWise.png" alt="CraftWise Logo" class="h-8 w-8 mr-2 object-contain">
                        CraftWise
                    </h3>
                    <p class="text-sm">Your ultimate destination for building custom PCs.</p>
                    <p class="text-sm mt-4">&copy; 2025 jzznllvnc. All rights reserved.</p>
                </div>

                <div class="hidden lg:block flex-grow lg:w-1/6 lg:w-auto ml-auto"> <h4 class="text-lg font-semibold text-white mb-3">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="<?php echo BASE_URL; ?>/products" class="hover:text-[--footer-link-hover] transition-colors">Products</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/build-rate" class="hover:text-[--footer-link-hover] transition-colors">Build Your PC</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/orderhistory" class="hover:text-[--footer-link-hover] transition-colors">My Orders</a></li>
                    </ul>
                </div>

                <div class="hidden lg:block flex-grow lg:w-1/6 lg:w-auto"> <h4 class="text-lg font-semibold text-white mb-3">Company Policies</h4>
                    <ul class="space-y-2">
                        <li><a href="<?php echo BASE_URL; ?>/privacy-policy" class="hover:text-[--footer-link-hover] transition-colors">Privacy Policy</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/terms-of-service" class="hover:text-[--footer-link-hover] transition-colors">Terms of Service</a></li>
                    </ul>
                </div>

                <div class="flex-grow lg:w-1/4 lg:w-1/5">
                    <h4 class="text-lg font-semibold text-white mb-3">Stay Updated</h4>
                    <p class="text-sm mb-4">Subscribe to our newsletter for the latest products and deals.</p>
                    <form id="newsletter-form" class="flex flex-row gap-2">
                        <input type="email" id="newsletter-email" name="user_email" placeholder="Your email address" aria-label="Email for newsletter" required
                            class="flex-grow px-4 py-2 rounded-md bg-gray-700 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:border-[--color-primary-orange] focus:ring-1 focus:ring-[--color-primary-orange]">
                        <button type="submit"
                                class="bg-[--color-primary-orange] hover:bg-[#e76c3e] text-white font-bold py-2 px-4 rounded-md transition-colors shadow-md">
                            Subscribe
                        </button>
                    </form>
                </div>

                <div class="flex-shrink-0 lg:w-1/5 lg:w-1/6">
                    <div class="flex flex-col items-center lg:items-end">
                        <h4 class="text-lg font-semibold text-white mb-3 text-center lg:text-right">Follow Us</h4>
                        <div class="flex justify-center lg:justify-end items-center space-x-4">
                            <a href="https://www.facebook.com/jazznelle.vince" target="_blank" rel="noopener noreferrer" class="text-[--footer-text-light] hover:text-[--footer-link-hover] transition-colors" aria-label="Facebook">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33V22C17.361 21.153 22 16.904 22 12z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="https://x.com/jzznllvnc_" target="_blank" rel="noopener noreferrer" class="text-[--footer-text-light] hover:text-[--footer-link-hover] transition-colors" aria-label="Twitter">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.007-.532A8.318 8.318 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 014 9.402v.053a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                </svg>
                            </a>
                            <a href="https://www.instagram.com/jzznllvnc/" target="_blank" rel="noopener noreferrer" class="text-[--footer-text-light] hover:text-[--footer-link-hover] transition-colors" aria-label="Instagram">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm3.333 4a.667.667 0 100 1.334.667.667 0 000-1.334zm-2.666 4a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zM12 10.667a1.333 1.333 0 100 2.666 1.333 1.333 0 000-2.666z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <button id="ai-chat-fab" aria-label="Open AI Chat">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
        </svg>
    </button>

    <div id="ai-chat-sidebar">
        <div class="sidebar-header">
            <h2 class="text-xl font-bold">AI Chat Assistant</h2>
            <div class="flex space-x-2"> <button id="new-chat-button" class="text-white mr-4 font-bold rounded-md underline underline-offset-4 hover:decoration-orange-500 decoration-transparent decoration-2 py-1 px-1">
                    New Chat
                </button>
                <button id="close-chat-sidebar" class="text-white hover:text-orange-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        <div id="ai-chat-content-placeholder">
            <div class="text-center text-gray-500 py-8">Loading AI Chat...</div>
        </div>
    </div>

    <div id="confirmation-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[1000] hidden opacity-0 transition-opacity duration-300 pointer-events-none">
        <div class="bg-white p-8 rounded-lg shadow-2xl max-w-sm w-full mx-4 transform scale-95 opacity-0 transition-all duration-300">
            <h3 id="confirmation-modal-title" class="text-2xl font-bold text-gray-900 mb-4 text-center">Confirm Action</h3>
            <p id="confirmation-modal-message" class="text-gray-700 mb-6 text-center">Are you sure you want to proceed?</p>
            <div class="flex justify-center space-x-4">
                <button id="confirm-action-btn" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-md transition-colors shadow-md">
                    Confirm
                </button>
                <button id="cancel-action-btn" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-md transition-colors shadow-md">
                    Cancel
                </button>
            </div>
        </div>
    </div>
    <div id="logout-confirmation-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[1000] hidden opacity-0 transition-opacity duration-300 pointer-events-none">
        <div class="bg-white p-8 rounded-lg shadow-2xl max-w-sm w-full mx-4 transform scale-95 opacity-0 transition-all duration-300">
            <h3 class="text-2xl font-bold text-gray-900 mb-4 text-center">Confirm Logout</h3>
            <p class="text-gray-700 mb-6 text-center">Are you sure you want to log out of your account?</p>
            <div class="flex justify-center space-x-4">
                <button id="confirm-logout-btn" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-md transition-colors shadow-md">
                    Yes, Log Out
                </button>
                <button id="cancel-logout-btn" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-md transition-colors shadow-md">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <div id="newsletter-success-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[1000] hidden opacity-0 transition-opacity duration-300 pointer-events-none">
        <div class="bg-white p-8 rounded-lg shadow-2xl max-w-sm w-full mx-4 text-center transform scale-95 opacity-0 transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Thank You!</h3>
            <p class="text-gray-700 mb-6">You've successfully subscribed to our newsletter for the latest updates!</p>
            <button id="newsletter-modal-close-btn" class="bg-[--color-primary-orange] hover:bg-[#e76c3e] text-white font-bold py-2 px-6 rounded-md transition-colors shadow-md">
                Got It!
            </button>
        </div>
    </div>

    <!-- Toast Container -->
    <div id="toast-container"></div>

    <script src="<?php echo BASE_URL; ?>/assets/js/main.js"></script>
</body>
</html>