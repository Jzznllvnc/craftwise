<!-- Hero Section -->
<div class="relative bg-gradient-to-r from-gray-900 via-gray-800 to-black pt-32 pb-20 px-6">
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.03\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    
    <div class="relative z-10 max-w-7xl mx-auto text-center">
        <h1 class="text-5xl md:text-6xl font-semibold text-white mb-6">
            <?php echo htmlspecialchars($title); ?>
        </h1>
        <p class="text-xl text-gray-300 max-w-3xl mx-auto">
            Build your dream PC with our intelligent component selector and get instant <span class="text-[--color-primary-orange] font-semibold">compatibility ratings!</span>
        </p>
    </div>
</div>

<!-- Main Content -->
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-6">
    <form id="build-form">
        <?php
        $componentIcons = [
                'CPU' => '<svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="2" /><rect x="9" y="9" width="6" height="6" /><path d="M15 2v2m-6 0V2m0 20v-2m6 0v2M2 9h2m20 0h-2M2 15h2m20 0h-2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>',
                'GPU' => '<svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5.45 5.11L2 12v6a2 2 0 002 2h16a2 2 0 002-2v-6l-3.45-6.89A2 2 0 0016.76 4H7.24a2 2 0 00-1.79 1.11z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><line x1="6" y1="16" x2="6.01" y2="16" stroke-width="2" stroke-linecap="round" /><line x1="10" y1="16" x2="10.01" y2="16" stroke-width="2" stroke-linecap="round" /></svg>',
                'Motherboard' => '<svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polygon points="12 2 2 7 12 12 22 7 12 2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><polyline points="2 17 12 22 22 17" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><polyline points="2 12 12 17 22 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>',
                'RAM' => '<svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="8" rx="2" stroke-width="2" /><rect x="2" y="14" width="20" height="8" rx="2" stroke-width="2" /><line x1="6" y1="6" x2="6.01" y2="6" stroke-width="2" stroke-linecap="round" /><line x1="6" y1="18" x2="6.01" y2="18" stroke-width="2" stroke-linecap="round" /></svg>',
                'Storage' => '<svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><ellipse cx="12" cy="5" rx="9" ry="3" stroke-width="2" /><path d="M2 12A9 3 0 0 0 11 15V20A9 3 0 0 1 2 17Z" stroke-width="2" /><path d="M22 12A9 3 0 0 1 13 15V20A9 3 0 0 0 22 17Z" stroke-width="2" /></svg>',
                'PSU' => '<svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>',
                'Case' => '<svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><polyline points="3.27 6.96 12 12.01 20.73 6.96" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><line x1="12" y1="22.08" x2="12" y2="12" stroke-width="2" stroke-linecap="round" /></svg>',
            ];
            
            $colors = [
                'CPU' => 'from-gray-100 to-gray-300',
                'GPU' => 'from-gray-100 to-gray-300',
                'Motherboard' => 'from-gray-100 to-gray-300',
                'RAM' => 'from-gray-100 to-gray-300',
                'Storage' => 'from-gray-100 to-gray-300',
                'PSU' => 'from-gray-100 to-gray-300',
                'Case' => 'from-gray-100 to-gray-300',
            ];
            ?>
            
            <!-- Component Selection Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            <?php foreach ($components as $category => $products): ?>
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-14 h-14 rounded-xl bg-gradient-to-br <?php echo $colors[$category]; ?> flex items-center justify-center text-white flex-shrink-0">
                                <?php echo $componentIcons[$category]; ?>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900"><?php echo htmlspecialchars($category); ?></h3>
                        </div>
                        
                        <select id="<?php echo strtolower($category); ?>" name="<?php echo strtolower($category); ?>"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[--color-primary-orange] transition-colors appearance-none bg-white cursor-pointer"
                                onchange="updateBuildSummary()">
                            <option value="">-- Select --</option>
                            <?php foreach ($products as $product): ?>
                                <option value="<?php echo htmlspecialchars($product['id']); ?>"
                                        data-price="<?php echo htmlspecialchars($product['price']); ?>"
                                        data-name="<?php echo htmlspecialchars($product['name'], ENT_QUOTES); ?>">
                                    <?php echo htmlspecialchars($product['name']); ?> - $<?php echo number_format($product['price'], 2); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        
                        <div id="<?php echo strtolower($category); ?>-summary" class="mt-3 text-sm text-gray-600 min-h-[20px]"></div>
                </div>
            <?php endforeach; ?>
        </div>

            <!-- Total Price & Actions -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="text-center md:text-left">
                        <p class="text-gray-600 text-sm font-semibold mb-1">Estimated Total</p>
                        <p class="text-4xl font-semibold text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-orange-600">
                            $<span id="estimated-total-price">0.00</span>
                        </p>
            </div>

                    <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
                <button type="button" onclick="clearBuildSelections()"
                                class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold rounded-xl transition-colors">
                    Clear Build
                </button>
                <button type="submit"
                                class="px-8 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold rounded-xl hover:shadow-lg transition-all transform hover:scale-105 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                    Get Build Rating
                </button>
                    </div>
            </div>
        </div>
    </form>

        <!-- Build Rating Results -->
        <div id="build-rating-results" class="mt-8 hidden">
            <div class="bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl shadow-2xl p-8 text-white relative overflow-hidden">
                <div class="absolute inset-0 bg-white/10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                
                <div class="relative z-10 text-center">
                    <h2 class="text-3xl font-semibold mb-4">Your Build Rating</h2>
                    <div class="flex items-center justify-center gap-4 mb-6">
                        <div class="w-32 h-32 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center border-4 border-white/30">
                            <span id="rating-score" class="text-5xl font-semibold">--</span>
                        </div>
                        <div class="text-left">
                            <p id="qualitative-rating" class="text-2xl font-bold"></p>
                            <p class="text-white/80">Performance Rating</p>
                        </div>
                    </div>
                    
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-left">
                        <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Analysis & Recommendations
                        </h3>
                        <p id="rating-comments" class="text-white/90 leading-relaxed"></p>
                    </div>
                    
                    <p class="text-white/60 text-sm mt-6">
                        This rating is a general guide. Always verify component specifications for detailed compatibility.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const selectedBuildComponents = {};

    function updateBuildSummary() {
        let total = 0;
        document.querySelectorAll('#build-form select').forEach(selectElement => {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const price = parseFloat(selectedOption.dataset.price || 0);
            const name = selectedOption.dataset.name || '';
            const category = selectElement.id;

            const summaryDiv = document.getElementById(`${category}-summary`);
            if (selectedOption.value) {
                total += price;
            summaryDiv.innerHTML = `<span class="text-green-600 font-semibold">✓ Selected</span>`;
                selectedBuildComponents[category] = selectedOption.value;
            } else {
                summaryDiv.textContent = '';
                delete selectedBuildComponents[category];
            }
        });
        document.getElementById('estimated-total-price').textContent = total.toFixed(2);
    }

    function clearBuildSelections() {
        document.querySelectorAll('#build-form select').forEach(selectElement => {
            selectElement.value = '';
        });

        for (const key in selectedBuildComponents) {
            delete selectedBuildComponents[key];
        }
        updateBuildSummary();
        document.getElementById('build-rating-results').classList.add('hidden');
        alertMessage('success', 'Build selections cleared!');
    }

    document.getElementById('build-form').addEventListener('submit', async (e) => {
        e.preventDefault();

        const sendButton = e.submitter;
        sendButton.disabled = true;
    sendButton.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg> Getting Rating...';
        sendButton.classList.add('opacity-50', 'cursor-not-allowed');

        const ratingResultsDiv = document.getElementById('build-rating-results');
        const ratingScoreSpan = document.getElementById('rating-score');
        const qualitativeRatingP = document.getElementById('qualitative-rating');
    const ratingCommentsP = document.getElementById('rating-comments');

        ratingResultsDiv.classList.add('hidden');
    ratingCommentsP.innerHTML = '';
        ratingScoreSpan.textContent = '--';
        qualitativeRatingP.textContent = '';

        if (Object.keys(selectedBuildComponents).length === 0) {
            alertMessage('error', 'Please select at least one component to get a rating.');
            sendButton.disabled = false;
        sendButton.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg> Get Build Rating';
            sendButton.classList.remove('opacity-50', 'cursor-not-allowed');
            return;
        }

        const formData = new FormData();
        Object.values(selectedBuildComponents).forEach(id => {
            formData.append('components[]', id);
        });

        try {
        const response = await fetch('<?php echo BASE_URL; ?>/build-rate/get', {
                method: 'POST',
                body: formData,
            });

            const data = await response.json();

        if (data.success) {
            ratingScoreSpan.textContent = data.rating + '%';
            qualitativeRatingP.textContent = data.qualitative_rating || '';
            ratingCommentsP.textContent = data.comments || 'No additional comments.';
                ratingResultsDiv.classList.remove('hidden');
            ratingResultsDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else {
            alertMessage('error', data.error || 'Failed to get build rating.');
            }
        } catch (error) {
        console.error('Error fetching build rating:', error);
        alertMessage('error', 'An error occurred while fetching the build rating.');
        } finally {
            sendButton.disabled = false;
        sendButton.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg> Get Build Rating';
            sendButton.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    });
</script>
