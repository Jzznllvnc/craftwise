<!-- Hero Section with Modern Gradient -->
<div class="relative bg-gradient-to-br from-gray-900 via-gray-800 to-black pt-32 pb-40 px-6 overflow-hidden">
    <!-- Animated Background Pattern -->
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.02\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    
    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 bg-cover bg-center opacity-10" style="background-image: url('<?php echo BASE_URL; ?>/app/views/products/images/landing.jpg');"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-70"></div>
    
    <div class="relative z-10 max-w-7xl mx-auto text-center">
        <div class="mb-8 animate-fade-in-down">
            <span class="inline-block px-4 py-2 bg-[--color-primary-orange]/10 border border-[--color-primary-orange]/30 rounded-full text-[--color-primary-orange] text-sm font-semibold mb-6">
                🚀 Welcome to the Future of PC Building
            </span>
        </div>
        
        <h1 class="text-6xl md:text-7xl lg:text-8xl font-semibold text-white mb-6 animate-fade-in-up leading-tight">
            Build Your
            <span class="block text-transparent bg-clip-text bg-gradient-to-r from-[--color-primary-orange] via-orange-400 to-yellow-500 animate-gradient">
                Dream PC
            </span>
        </h1>
        
        <p class="text-xl md:text-2xl text-gray-300 mb-12 max-w-3xl mx-auto animate-scale-in">
            Your ultimate destination for premium components. Expert guidance, AI-powered assistance, and seamless compatibility checking.
        </p>
        
        <div class="flex flex-col sm:flex-row justify-center gap-4 animate-slide-up">
            <a href="<?php echo BASE_URL; ?>/products" class="group relative px-8 py-4 bg-gradient-to-r from-[--color-primary-orange] to-orange-600 text-white font-bold rounded-xl transition-all duration-300 transform hover:scale-105 shadow-2xl hover:shadow-orange-500/50 overflow-hidden">
                <span class="relative z-10 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Shop Now
                </span>
                <div class="absolute inset-0 bg-gradient-to-r from-orange-600 to-red-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </a>
            <a href="<?php echo BASE_URL; ?>/build-rate" class="group relative px-8 py-4 bg-white/10 backdrop-blur-sm border-2 border-white/30 text-white font-bold rounded-xl transition-all duration-300 transform hover:scale-105 hover:bg-white/20 shadow-xl">
                <span class="flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Build & Rate
                </span>
            </a>
        </div>
    </div>
</div>

<!-- Trusted Brands Section -->
<div class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12">
            <span class="text-sm font-bold uppercase tracking-wider text-gray-500">Trusted by the Best</span>
            <h2 class="text-3xl font-bold text-gray-900 mt-2">Our Premium Partners</h2>
        </div>
        <div class="relative overflow-hidden py-8">
            <div class="flex whitespace-nowrap animate-slide-brands">
                <?php
                $base = BASE_URL;
                $brands_with_images = [
                    ['name' => 'AMD', 'logo_url' => $base . '/assets/brands/amd.png'],
                    ['name' => 'NVIDIA', 'logo_url' => $base . '/assets/brands/nvidia.png'],
                    ['name' => 'Corsair', 'logo_url' => $base . '/assets/brands/corsair.png'],
                    ['name' => 'ASUS', 'logo_url' => $base . '/assets/brands/asus.png'],
                    ['name' => 'Samsung', 'logo_url' => $base . '/assets/brands/samsung.png'],
                    ['name' => 'NZXT', 'logo_url' => $base . '/assets/brands/nzxt.png'],
                    ['name' => 'Intel', 'logo_url' => $base . '/assets/brands/intel.png'],
                    ['name' => 'MSI', 'logo_url' => $base . '/assets/brands/msi.png'],
                    ['name' => 'G.Skill', 'logo_url' => $base . '/assets/brands/gskill.png'],
                    ['name' => 'Seasonic', 'logo_url' => $base . '/assets/brands/seasonic.png'],
                    ['name' => 'Noctua', 'logo_url' => $base . '/assets/brands/noctua.png'],
                    ['name' => 'Logitech', 'logo_url' => $base . '/assets/brands/logitech.png'],
                ];

                for ($i = 0; $i < 3; $i++) {
                    foreach ($brands_with_images as $brand) {
                        echo '<div class="inline-flex items-center justify-center w-48 h-24 mx-4 bg-gray-50 rounded-xl shadow-sm hover:shadow-md transition-shadow flex-shrink-0">';
                        echo '<img src="' . htmlspecialchars($brand['logo_url']) . '" alt="' . htmlspecialchars($brand['name']) . '" class="h-12 w-auto object-contain grayscale hover:grayscale-0 transition-all">';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Features Section - Modern Grid -->
<div class="bg-gradient-to-b from-gray-50 to-white py-24">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-semibold text-gray-900 mb-4">
                Why Choose <span class="text-[--color-primary-orange]">CraftWise</span>?
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Everything you need to build the perfect PC, all in one place
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-2xl hover:border-orange-200 transition-all duration-300 hover:-translate-y-2">
                <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-gray-100 to-gray-300 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Custom PC Builder</h3>
                <p class="text-gray-600 leading-relaxed">
                    Select components with real-time compatibility checking and performance ratings tailored to your needs.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-2xl hover:border-green-200 transition-all duration-300 hover:-translate-y-2">
                <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-gray-100 to-gray-300 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Premium Components</h3>
                <p class="text-gray-600 leading-relaxed">
                    Browse thousands of products from top brands with detailed specs and real-time stock updates.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-2xl hover:border-purple-200 transition-all duration-300 hover:-translate-y-2">
                <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-gray-100 to-gray-300 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">AI Assistant</h3>
                <p class="text-gray-600 leading-relaxed">
                    Get instant expert advice from Kraft-E, our AI chatbot trained on PC building knowledge.
                </p>
            </div>

            <!-- Feature 4 -->
            <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-2xl hover:border-blue-200 transition-all duration-300 hover:-translate-y-2">
                <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-gray-100 to-gray-300 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Easy to Use</h3>
                <p class="text-gray-600 leading-relaxed">
                    Intuitive interface designed for beginners and experts alike. Build with confidence.
                </p>
            </div>

            <!-- Feature 5 -->
            <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-2xl hover:border-yellow-200 transition-all duration-300 hover:-translate-y-2">
                <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-gray-100 to-gray-300 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Secure Checkout</h3>
                <p class="text-gray-600 leading-relaxed">
                    Shop with confidence using encrypted payments and secure payment gateways.
                </p>
            </div>

            <!-- Feature 6 -->
            <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-2xl hover:border-indigo-200 transition-all duration-300 hover:-translate-y-2">
                <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-gray-100 to-gray-300 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Live Stock Updates</h3>
                <p class="text-gray-600 leading-relaxed">
                    Always know what's available with real-time inventory tracking on all products.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Build Process Section -->
<div class="relative py-32 overflow-hidden bg-gray-900">
    <video class="absolute inset-0 w-full h-full object-cover opacity-20" autoplay loop muted playsinline>
        <source src="<?php echo BASE_URL; ?>/assets/videos/homevid.webm" type="video/webm">
        <source src="<?php echo BASE_URL; ?>/assets/videos/homevid.mp4" type="video/mp4">
    </video>
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-gray-900/50 to-gray-900"></div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-6">
        <div class="text-center mb-20">
            <span class="text-[--color-primary-orange] text-sm font-bold uppercase tracking-widest">The Crafting Process</span>
            <h2 class="text-5xl md:text-6xl font-semibold text-white mt-4 mb-6">
                Build Your Dream PC<br/>
                <span class="text-[--color-primary-orange]">In 3 Simple Steps</span>
            </h2>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Step 1 -->
            <div class="relative bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-8 hover:bg-white/15 transition-all duration-300 group">
                <div class="absolute -top-6 left-8 w-12 h-12 rounded-full bg-gradient-to-br from-[--color-primary-orange] to-orange-600 flex items-center justify-center text-white text-2xl font-bold shadow-xl">
                    1
                </div>
                <div class="mt-8">
                    <h3 class="text-2xl font-bold text-white mb-4">Select Components</h3>
                    <p class="text-gray-300 leading-relaxed">
                        Choose from thousands of CPUs, GPUs, motherboards, RAM, and more from our extensive catalog.
                    </p>
                </div>
                <div class="mt-6 w-16 h-1 bg-gradient-to-r from-[--color-primary-orange] to-transparent rounded-full group-hover:w-24 transition-all"></div>
            </div>

            <!-- Step 2 -->
            <div class="relative bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-8 hover:bg-white/15 transition-all duration-300 group">
                <div class="absolute -top-6 left-8 w-12 h-12 rounded-full bg-gradient-to-br from-[--color-primary-orange] to-orange-600 flex items-center justify-center text-white text-2xl font-bold shadow-xl">
                    2
                </div>
                <div class="mt-8">
                    <h3 class="text-2xl font-bold text-white mb-4">Check Compatibility</h3>
                    <p class="text-gray-300 leading-relaxed">
                        Our intelligent system instantly verifies compatibility and flags potential issues.
                    </p>
                </div>
                <div class="mt-6 w-16 h-1 bg-gradient-to-r from-[--color-primary-orange] to-transparent rounded-full group-hover:w-24 transition-all"></div>
            </div>

            <!-- Step 3 -->
            <div class="relative bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-8 hover:bg-white/15 transition-all duration-300 group">
                <div class="absolute -top-6 left-8 w-12 h-12 rounded-full bg-gradient-to-br from-[--color-primary-orange] to-orange-600 flex items-center justify-center text-white text-2xl font-bold shadow-xl">
                    3
                </div>
                <div class="mt-8">
                    <h3 class="text-2xl font-bold text-white mb-4">Order & Build</h3>
                    <p class="text-gray-300 leading-relaxed">
                        Finalize your build and order with confidence. We'll deliver everything you need.
                    </p>
                </div>
                <div class="mt-6 w-16 h-1 bg-gradient-to-r from-[--color-primary-orange] to-transparent rounded-full group-hover:w-24 transition-all"></div>
            </div>
        </div>

        <div class="text-center mt-16">
            <a href="<?php echo BASE_URL; ?>/build-rate" class="inline-block px-8 py-4 bg-gradient-to-r from-[--color-primary-orange] to-orange-600 text-white font-bold rounded-xl text-lg transition-all duration-300 transform hover:scale-105 shadow-2xl hover:shadow-orange-500/50">
                Start Building Now →
            </a>
        </div>
    </div>
</div>

<!-- FAQ Section -->
<div class="bg-white py-24">
    <div class="max-w-4xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-semibold text-gray-900 mb-4">
                <span class="text-[--color-primary-orange]">F</span>requently
                <span class="text-[--color-primary-orange]">A</span>sked
                <span class="text-[--color-primary-orange]">Q</span>uestions
            </h2>
            <p class="text-xl text-gray-600">Everything you need to know about building with CraftWise</p>
        </div>

        <div class="space-y-4">
            <?php
            $faqs = [
                [
                    'question' => 'How do I start building a PC on CraftWise?',
                    'answer' => 'Click "Build Your PC" on the homepage or navigation. You\'ll be guided step-by-step to select compatible components and see your build rating in real time.'
                ],
                [
                    'question' => 'Does CraftWise check component compatibility?',
                    'answer' => 'Yes! Our system automatically checks compatibility between your selected CPU, motherboard, RAM, GPU, and more, warning you of any issues before you order.'
                ],
                [
                    'question' => 'Can I get help choosing parts?',
                    'answer' => 'Absolutely! Use our Kraft-E AI chat assistant for instant advice, or browse our guides for tips on picking the best components for your needs.'
                ],
                [
                    'question' => 'Do you show real-time stock and prices?',
                    'answer' => 'Yes, all product listings display up-to-the-minute stock status and current prices, so you always know what\'s available.'
                ],
                [
                    'question' => 'Is my payment and data secure?',
                    'answer' => 'Definitely. We use secure payment gateways and industry-standard encryption to keep your information safe.'
                ]
            ];

            foreach ($faqs as $index => $faq):
            ?>
            <div class="faq-item bg-gray-50 rounded-xl border border-gray-200 overflow-hidden">
                <button type="button" class="faq-question w-full flex justify-between items-center p-6 text-left hover:bg-gray-100 transition-colors">
                    <span class="text-lg font-semibold text-gray-900"><?php echo htmlspecialchars($faq['question']); ?></span>
                    <span class="faq-toggle-icon text-3xl text-[--color-primary-orange] transition-transform">+</span>
                </button>
                <div class="faq-answer max-h-0 overflow-hidden transition-all duration-300">
                    <div class="p-6 pt-0 text-gray-700">
                        <?php echo htmlspecialchars($faq['answer']); ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<style>
@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-30px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes scaleIn {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}
@keyframes slideUp {
    from { opacity: 0; transform: translateY(40px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes gradient {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

.animate-fade-in-down {
    animation: fadeInDown 0.8s ease-out forwards;
}
.animate-fade-in-up {
    animation: fadeInUp 0.8s ease-out forwards 0.2s;
    opacity: 0;
}
.animate-scale-in {
    animation: scaleIn 0.8s ease-out forwards 0.4s;
    opacity: 0;
}
.animate-slide-up {
    animation: slideUp 0.8s ease-out forwards 0.6s;
    opacity: 0;
}
.animate-gradient {
    background-size: 200% 200%;
    animation: gradient 3s ease infinite;
}

@keyframes slide-brands {
    from { transform: translateX(0); }
    to { transform: translateX(-33.333%); }
}
.animate-slide-brands {
    animation: slide-brands 30s linear infinite;
}
.animate-slide-brands:hover {
    animation-play-state: paused;
}

.faq-toggle-icon.rotate-45 {
    transform: rotate(45deg);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // FAQ Accordion
    document.querySelectorAll('.faq-question').forEach(btn => {
        btn.addEventListener('click', function() {
            const answer = this.parentElement.querySelector('.faq-answer');
            const icon = this.querySelector('.faq-toggle-icon');
            const isOpen = answer.style.maxHeight && answer.style.maxHeight !== '0px';

            // Close all
            document.querySelectorAll('.faq-answer').forEach(a => a.style.maxHeight = '0px');
            document.querySelectorAll('.faq-toggle-icon').forEach(i => {
                i.textContent = '+';
                i.classList.remove('rotate-45');
            });

            // Open if not already open
            if (!isOpen) {
                answer.style.maxHeight = answer.scrollHeight + 'px';
                icon.textContent = '×';
                icon.classList.add('rotate-45');
            }
        });
    });
});
</script>
