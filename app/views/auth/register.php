<style>
    .main-header,
    footer {
        display: none !important;
    }
    body {
        padding-top: 0 !important;
    }
</style>

<!-- Logo in top left -->
<a href="<?php echo BASE_URL; ?>/" class="fixed top-6 left-6 z-50 flex items-center gap-3 group">
    <img src="<?php echo BASE_URL; ?>/assets/images/CraftWise.png" alt="CraftWise" class="w-12 h-12 transition-transform group-hover:scale-110">
    <span class="text-2xl font-bold text-gray-900 group-hover:text-[--color-primary-orange] transition-colors">CraftWise</span>
</a>

<!-- Modern Register Page -->
<div class="min-h-screen flex">
    <!-- Left Side - Form -->
    <div class="flex-1 flex items-center justify-center px-6 py-12 bg-gray-50">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <h2 class="text-4xl font-semibold text-gray-900 mb-2"><?php echo htmlspecialchars($title); ?></h2>
                <p class="text-gray-600">Create your account and start building</p>
            </div>

            <?php if (isset($error) && $error): ?>
                <div class="bg-red-50 border-2 border-red-200 rounded-xl p-4 mb-6 flex items-start gap-3">
                    <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="flex-1">
                        <h3 class="font-bold text-red-900">Error!</h3>
                        <p class="text-red-700 text-sm"><?php echo htmlspecialchars($error); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($success) && $success): ?>
                <div class="bg-green-50 border-2 border-green-200 rounded-xl p-4 mb-6 flex items-start gap-3">
                    <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="flex-1">
                        <h3 class="font-bold text-green-900">Success!</h3>
                        <p class="text-green-700 text-sm"><?php echo htmlspecialchars($success); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <form action="<?php echo BASE_URL; ?>/register" method="POST" class="space-y-5">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Username</label>
                    <input type="text" name="username" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[--color-primary-orange] transition-colors">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                    <input type="email" name="email" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[--color-primary-orange] transition-colors">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required autocomplete="off"
                               class="w-full px-4 py-3 pr-12 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[--color-primary-orange] transition-colors">
                        <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700" onclick="togglePassword('password')">
                            <svg id="eye-show-password" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eye-hide-password" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Confirm Password</label>
                    <div class="relative">
                        <input type="password" name="confirm_password" id="confirm_password" required autocomplete="off"
                               class="w-full px-4 py-3 pr-12 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[--color-primary-orange] transition-colors">
                        <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700" onclick="togglePassword('confirm_password')">
                            <svg id="eye-show-confirm_password" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eye-hide-confirm_password" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-start gap-2 text-sm pt-2">
                    <input type="checkbox" id="terms" required class="w-4 h-4 mt-1 text-[--color-primary-orange] border-gray-300 rounded focus:ring-[--color-primary-orange]">
                    <label for="terms" class="text-gray-600">
                        I agree to the <a href="<?php echo BASE_URL; ?>/terms-of-service" class="text-[--color-primary-orange] hover:underline font-semibold">Terms of Service</a> and <a href="<?php echo BASE_URL; ?>/privacy-policy" class="text-[--color-primary-orange] hover:underline font-semibold">Privacy Policy</a>
                    </label>
                </div>

                <button type="submit"
                        class="w-full py-4 bg-gradient-to-r from-[--color-primary-orange] to-orange-600 text-white font-bold text-lg rounded-xl hover:shadow-lg transition-all transform hover:scale-105">
                    Create Account
                </button>
            </form>

            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-gray-50 text-gray-500 font-medium">Or sign up with</span>
                </div>
            </div>

            <a href="<?php echo BASE_URL; ?>/auth/google" 
               class="w-full flex items-center justify-center gap-3 px-4 py-3 border-2 border-gray-300 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all font-medium text-gray-700">
                <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Sign up with Google
            </a>

            <div class="mt-8 text-center">
                <p class="text-gray-600">
                    Already have an account?
                    <a href="<?php echo BASE_URL; ?>/login" class="font-bold text-[--color-primary-orange] hover:underline ml-1">
                        Sign in
                    </a>
                </p>
            </div>
        </div>
    </div>

    <!-- Right Side - Image/Branding -->
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-r from-gray-900 via-gray-800 to-black relative overflow-hidden">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.03\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        
        <div class="relative z-10 flex flex-col justify-center items-center px-8 text-white w-full">
            <div class="flex items-center justify-center mb-8 w-full max-w-xl">
                <img src="<?php echo BASE_URL; ?>/assets/images/registerhero.png" alt="Join CraftWise" class="h-96 w-full object-contain">
            </div>
            
            <div class="w-full max-w-xl text-center mb-6">
                <h1 class="text-4xl font-semibold mb-4">Join CraftWise Today!</h1>
                <p class="text-lg text-white/90 leading-relaxed">
                    Start your journey to building the perfect custom PC with our expert guidance and tools.
                </p>
            </div>
            
            <div class="space-y-3 w-full max-w-xl">
                <div class="flex items-start gap-3 bg-white/10 backdrop-blur-sm rounded-xl p-3">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-base mb-0.5">PC Build Assistant</h3>
                        <p class="text-white/80 text-xs">Get AI-powered recommendations for your perfect build</p>
                    </div>
                </div>
                
                <div class="flex items-start gap-3 bg-white/10 backdrop-blur-sm rounded-xl p-3">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-base mb-0.5">Compatibility Check</h3>
                        <p class="text-white/80 text-xs">Automatically verify all components work together</p>
                    </div>
                </div>
                
                <div class="flex items-start gap-3 bg-white/10 backdrop-blur-sm rounded-xl p-3">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-base mb-0.5">Best Prices</h3>
                        <p class="text-white/80 text-xs">Premium components at competitive prices</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(id) {
    const input = document.getElementById(id);
    const showIcon = document.getElementById('eye-show-' + id);
    const hideIcon = document.getElementById('eye-hide-' + id);
    
    if (input.type === 'password') {
        input.type = 'text';
        showIcon.classList.add('hidden');
        hideIcon.classList.remove('hidden');
    } else {
        input.type = 'password';
        showIcon.classList.remove('hidden');
        hideIcon.classList.add('hidden');
    }
}
</script>
