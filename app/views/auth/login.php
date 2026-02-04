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
    <span class="text-2xl font-bold text-white group-hover:text-[--color-primary-orange] transition-colors">CraftWise</span>
</a>

<!-- Modern Login Page -->
<div class="min-h-screen flex">
    <!-- Left Side - Image/Branding -->
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-r from-gray-900 via-gray-800 to-black relative overflow-hidden">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.03\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        
        <div class="relative z-10 flex flex-col justify-center items-center px-8 text-white w-full">
            <div class="flex items-center justify-center mb-8 w-full max-w-xl">
                <img src="<?php echo BASE_URL; ?>/assets/images/loginhero.png" alt="Welcome Back" class="h-96 w-full object-contain">
            </div>
            
            <div class="space-y-3 w-full max-w-xl">
                <div class="flex items-start gap-3 bg-white/10 backdrop-blur-sm rounded-xl p-3">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-base mb-0.5">Track your orders</h3>
                        <p class="text-white/80 text-xs">Monitor your purchase history and delivery status</p>
                    </div>
                </div>
                
                <div class="flex items-start gap-3 bg-white/10 backdrop-blur-sm rounded-xl p-3">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-base mb-0.5">Save your builds</h3>
                        <p class="text-white/80 text-xs">Store and manage your custom PC configurations</p>
                    </div>
                </div>
                
                <div class="flex items-start gap-3 bg-white/10 backdrop-blur-sm rounded-xl p-3">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-base mb-0.5">AI-powered assistance</h3>
                        <p class="text-white/80 text-xs">Get intelligent recommendations and support</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side - Form -->
    <div class="flex-1 flex items-center justify-center px-6 py-12 bg-gray-50">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <h2 class="text-4xl font-semibold text-gray-900 mb-2"><?php echo htmlspecialchars($title); ?></h2>
                <p class="text-gray-600">Enter your credentials to access your account</p>
            </div>

            <?php if (isset($error) && $error): ?>
                <div class="alert-dismissible bg-red-50 border-2 border-red-200 rounded-xl p-4 mb-6 flex items-start gap-3 relative transition-all duration-300">
                    <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="flex-1">
                        <h3 class="font-bold text-red-900">Error!</h3>
                        <p class="text-red-700 text-sm"><?php echo htmlspecialchars($error); ?></p>
                    </div>
                    <button type="button" onclick="dismissAlert(this)" class="text-red-400 hover:text-red-600 transition-colors ml-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            <?php endif; ?>

            <?php if (isset($success) && $success): ?>
                <div class="alert-dismissible bg-green-50 border-2 border-green-200 rounded-xl p-4 mb-6 flex items-start gap-3 relative transition-all duration-300">
                    <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="flex-1">
                        <h3 class="font-bold text-green-900">Success!</h3>
                        <p class="text-green-700 text-sm"><?php echo htmlspecialchars($success); ?></p>
                    </div>
                    <button type="button" onclick="dismissAlert(this)" class="text-green-400 hover:text-green-600 transition-colors ml-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            <?php endif; ?>

        <form action="<?php echo BASE_URL; ?>/login" method="POST" class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Username or Email</label>
                    <input type="text" name="identifier" required
                           value="<?php echo htmlspecialchars($remembered_username ?? ''); ?>"
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

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember_me" 
                               <?php echo !empty($remembered_username) ? 'checked' : ''; ?>
                               class="w-4 h-4 text-[--color-primary-orange] border-gray-300 rounded focus:ring-[--color-primary-orange]">
                        <span class="text-gray-700">Remember me</span>
                    </label>
            </div>

                <button type="submit"
                        class="w-full py-4 bg-gradient-to-r from-[--color-primary-orange] to-orange-600 text-white font-bold text-lg rounded-xl hover:shadow-lg transition-all transform hover:scale-105">
                    Log In
                </button>
        </form>

        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-gray-50 text-gray-500 font-medium">Or continue with</span>
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
            Sign in with Google
        </a>

        <div class="mt-8 text-center">
                <p class="text-gray-600">
                    Don't have an account?
                    <a href="<?php echo BASE_URL; ?>/register" class="font-bold text-[--color-primary-orange] hover:underline ml-1">
                        Create account
                    </a>
                </p>
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

function dismissAlert(button) {
    const alert = button.closest('.alert-dismissible');
    alert.style.opacity = '0';
    alert.style.transform = 'translateY(-10px)';
    setTimeout(() => {
        alert.style.display = 'none';
    }, 300);
}

// Auto-dismiss alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                alert.style.display = 'none';
            }, 300);
        }, 5000); // 5 seconds
    });
});
</script>
