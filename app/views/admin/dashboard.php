<!-- Hero Header -->
<div class="relative bg-gradient-to-r from-gray-900 via-gray-800 to-black pt-32 pb-16 px-6">
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.03\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    
    <div class="relative z-10 max-w-7xl mx-auto text-center">
        <h1 class="text-5xl md:text-6xl font-semibold text-white mb-4">
            Admin Dashboard
        </h1>
        <p class="text-xl text-gray-300">
            Manage your <span class="text-[--color-primary-orange] font-semibold">store operations</span> and monitor performance
        </p>
    </div>
</div>

<!-- Main Content -->
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-6">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Stat Card 1 -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-sm font-semibold text-gray-600 mb-1">New Orders</h3>
                <p class="text-3xl font-bold text-gray-900 mb-2"><?php echo htmlspecialchars($newOrders); ?></p>
                <div class="flex items-center text-sm text-green-600">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                    <span class="font-semibold">+2.00% (30 days)</span>
                </div>
            </div>

            <!-- Stat Card 2 -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center">
                        <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-sm font-semibold text-gray-600 mb-1">Total Income</h3>
                <p class="text-3xl font-bold text-gray-900 mb-2">$<?php echo number_format($totalIncome, 2); ?></p>
                <div class="flex items-center text-sm text-green-600">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                    <span class="font-semibold">+5.45% Increased</span>
                </div>
            </div>

            <!-- Stat Card 3 -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-red-100 to-red-200 flex items-center justify-center">
                        <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9H7a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2zM7 9V5a2 2 0 012-2h6a2 2 0 012 2v4m-5 4h.01M12 16h.01" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-sm font-semibold text-gray-600 mb-1">Total Expense</h3>
                <p class="text-3xl font-bold text-gray-900 mb-2">$<?php echo number_format($totalExpense, 2); ?></p>
                <div class="flex items-center text-sm text-red-600">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                    </svg>
                    <span class="font-semibold">-2.00% Expense</span>
                </div>
            </div>

            <!-- Stat Card 4 -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-orange-100 to-orange-200 flex items-center justify-center">
                        <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-sm font-semibold text-gray-600 mb-1">New Users</h3>
                <p class="text-3xl font-bold text-gray-900 mb-2"><?php echo htmlspecialchars($newUser); ?></p>
                <div class="flex items-center text-sm text-orange-600">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                    </svg>
                    <span class="font-semibold">-25.00% (30 days)</span>
                </div>
            </div>
    </div>

        <!-- Chart and Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Revenue Chart -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-2xl transition-all duration-300">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Yearly Revenue</h2>
                        <p class="text-3xl font-bold text-[--color-primary-orange] mt-2">$<?php echo number_format($yearlyStatsTotal, 2); ?></p>
                    </div>
                    <div class="px-4 py-2 bg-gray-100 rounded-xl">
                        <select class="bg-transparent border-none focus:outline-none text-sm font-semibold text-gray-700">
                            <option>Yearly</option>
                        </select>
                    </div>
                </div>
                <div class="h-64 flex items-center justify-center">
                    <canvas id="yearlyStatsChart"></canvas>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-2 gap-4">
                <a href="<?php echo BASE_URL; ?>/admin/products" class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-2xl hover:border-orange-200 transition-all duration-300 hover:-translate-y-1 flex flex-col items-center justify-center text-center group">
                    <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-gray-100 to-gray-300 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Manage Products</h3>
                    <p class="text-sm text-gray-600">Add, edit, or delete</p>
                </a>
                
                <a href="<?php echo BASE_URL; ?>/admin/users" class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-2xl hover:border-orange-200 transition-all duration-300 hover:-translate-y-1 flex flex-col items-center justify-center text-center group">
                    <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-gray-100 to-gray-300 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Manage Users</h3>
                    <p class="text-sm text-gray-600">View and manage</p>
                </a>

                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 flex flex-col items-center justify-center text-center opacity-60">
                    <div class="w-16 h-16 rounded-xl bg-gray-100 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m0 0H6" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-700 mb-1">New Feature</h3>
                    <p class="text-sm text-gray-500">Coming soon</p>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 flex flex-col items-center justify-center text-center opacity-60">
                    <div class="w-16 h-16 rounded-xl bg-gray-100 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m0 0H6" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-700 mb-1">Another Feature</h3>
                    <p class="text-sm text-gray-500">Coming soon</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data from PHP for charts
        const monthlyLabels = <?php echo $monthlyLabels; ?>;
        const monthlyDataValues = <?php echo $monthlyDataValues; ?>;

        // --- Yearly Stats (Line Chart) ---
        const yearlyStatsCtx = document.getElementById('yearlyStatsChart').getContext('2d');
        new Chart(yearlyStatsCtx, {
            type: 'line',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'Total Revenue',
                    data: monthlyDataValues,
                    backgroundColor: 'rgba(74, 144, 226, 0.2)',
                    borderColor: '#4A90E2',
                    borderWidth: 2,
                    pointRadius: 3,
                    pointBackgroundColor: '#4A90E2',
                    pointBorderColor: '#fff',
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: '#4A90E2',
                    pointHoverBorderColor: '#fff',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#4A90E2',
                        borderWidth: 1,
                        cornerRadius: 4,
                        callbacks: {
                            label: function(context) {
                                return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(context.parsed.y);
                            },
                            title: function(context) {
                                return context[0].label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: true,
                            drawBorder: false,
                            color: 'rgba(200, 200, 200, 0.2)'
                        },
                        ticks: {
                            color: '#666',
                            font: {
                                size: 10
                            },
                             callback: function(value) {
                                return '$' + (value / 1000).toFixed(0) + 'k';
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: '#666',
                            font: {
                                size: 10
                            }
                        }
                    }
                }
            }
        });
    });
</script>