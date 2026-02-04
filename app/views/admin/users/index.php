<!-- Hero Header -->
<div class="relative bg-gradient-to-r from-gray-900 via-gray-800 to-black pt-32 pb-16 px-6">
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.03\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    
    <div class="relative z-10 max-w-7xl mx-auto text-center">
        <h1 class="text-5xl md:text-6xl font-semibold text-white mb-4">
            Manage Users
        </h1>
        <p class="text-xl text-gray-300">
            View and manage <span class="text-[--color-primary-orange] font-semibold">user accounts</span> and permissions
        </p>
    </div>
</div>

<!-- Main Content -->
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-6">
        <?php if (isset($success) && $success): ?>
            <div class="bg-green-50 border-2 border-green-200 rounded-xl p-4 mb-6 flex items-start gap-3">
                <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="flex-1">
                    <h3 class="font-bold text-green-900">Success!</h3>
                    <p class="text-green-700 text-sm"><?php echo htmlspecialchars($success); ?></p>
                </div>
                <button type="button" class="js-dismiss-btn text-green-700 hover:text-green-900">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        <?php endif; ?>

        <?php if (isset($error) && $error): ?>
            <div class="bg-red-50 border-2 border-red-200 rounded-xl p-4 mb-6 flex items-start gap-3">
                <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="flex-1">
                    <h3 class="font-bold text-red-900">Error!</h3>
                    <p class="text-red-700 text-sm"><?php echo htmlspecialchars($error); ?></p>
                </div>
                <button type="button" class="js-dismiss-btn text-red-700 hover:text-red-900">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        <?php endif; ?>

        <!-- Action Bar -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
            <form action="<?php echo BASE_URL; ?>/admin/users" method="GET" class="flex-1 max-w-2xl w-full flex gap-3">
                <div class="relative flex-1">
                    <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" name="search" placeholder="Search by username or email..."
                           value="<?php echo htmlspecialchars($searchTerm ?? ''); ?>"
                           class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[--color-primary-orange] transition-colors">
                </div>
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-[--color-primary-orange] to-orange-600 text-white font-bold rounded-xl hover:shadow-lg transition-all">
                    Search
                </button>
                <?php if (!empty($searchTerm)): ?>
                    <a href="<?php echo BASE_URL; ?>/admin/users" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold rounded-xl transition-colors">
                        Clear
                    </a>
                <?php endif; ?>
            </form>
            <a href="<?php echo BASE_URL; ?>/admin" class="flex items-center gap-2 text-[--color-primary-orange] hover:text-orange-600 font-semibold transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Dashboard
            </a>
        </div>

        <!-- Users Table -->
        <?php if (empty($users)): ?>
            <div class="bg-white rounded-2xl shadow-lg p-16 text-center border border-gray-100">
                <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No users found</h3>
                <p class="text-gray-600">Try adjusting your search criteria</p>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-white border-b-2 border-gray-100">
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Username</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider hidden md:table-cell">Signup Date</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider hidden md:table-cell">Last Login</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Admin</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($users as $user): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-900 font-semibold">
                                    #<?php echo htmlspecialchars($user['id']); ?>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                    <?php echo htmlspecialchars($user['username']); ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    <?php echo htmlspecialchars($user['email']); ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 hidden md:table-cell">
                                    <?php echo date('M j, Y', strtotime($user['created_at'])); ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 hidden md:table-cell">
                                    <?php echo $user['last_login'] ? date('M j, Y', strtotime($user['last_login'])) : 'Never'; ?>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <?php if ($user['is_admin']): ?>
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full font-bold text-xs">
                                            Admin
                                        </span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full font-bold text-xs">
                                            User
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <?php if ($user['is_banned']): ?>
                                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full font-bold text-xs flex items-center gap-1 w-fit">
                                            <span class="inline-block w-2 h-2 bg-red-500 rounded-full"></span>
                                            Banned
                                        </span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full font-bold text-xs flex items-center gap-1 w-fit">
                                            <span class="inline-block w-2 h-2 bg-green-500 rounded-full"></span>
                                            Active
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <button type="button"
                                                class="js-toggle-ban-btn px-3 py-2 rounded-lg font-semibold text-xs transition-colors
                                                <?php echo $user['is_banned'] ? 'bg-yellow-100 hover:bg-yellow-200 text-yellow-800' : 'bg-red-100 hover:bg-red-200 text-red-800'; ?>"
                                                data-user-id="<?php echo htmlspecialchars($user['id']); ?>"
                                                data-username="<?php echo htmlspecialchars($user['username']); ?>"
                                                data-is-banned="<?php echo htmlspecialchars($user['is_banned']); ?>">
                                            <?php echo $user['is_banned'] ? 'Unban' : 'Ban'; ?>
                                        </button>
                                        
                                        <button type="button"
                                                class="js-delete-user-btn px-3 py-2 bg-gray-800 hover:bg-gray-900 text-white rounded-lg font-semibold text-xs transition-colors"
                                                data-user-id="<?php echo htmlspecialchars($user['id']); ?>"
                                                data-username="<?php echo htmlspecialchars($user['username']); ?>">
                                            Delete
                                        </button>
                                        
                                        <a href="<?php echo BASE_URL; ?>/admin/users/orders/<?php echo htmlspecialchars($user['id']); ?>"
                                           class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold text-xs transition-colors">
                                            Orders
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>