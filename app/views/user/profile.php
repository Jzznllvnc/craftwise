<!-- Hero Header -->
<div class="relative bg-gradient-to-r from-gray-900 via-gray-800 to-black pt-32 pb-16 px-6">
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.03\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    
    <div class="relative z-10 max-w-7xl mx-auto text-center">
        <h1 class="text-5xl md:text-6xl font-semibold text-white mb-4">
            My Profile
        </h1>
        <p class="text-xl text-gray-300">
            Manage your <span class="text-[--color-primary-orange] font-semibold">account settings</span> and preferences
        </p>
    </div>
</div>

<!-- Main Content -->
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Profile Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 text-center hover:shadow-2xl transition-all duration-300">
                    <div class="relative inline-block mb-6">
                        <img src="<?php echo BASE_URL; ?>/assets/images/user.png"
                             alt="User Avatar"
                             class="w-32 h-32 rounded-full object-cover border-4 border-[--color-primary-orange] shadow-lg">
                        <div class="absolute bottom-0 right-0 w-8 h-8 bg-green-500 rounded-full border-4 border-white"></div>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2"><?php echo htmlspecialchars($user['username']); ?></h2>
                    <div class="flex items-center justify-center gap-2 text-gray-600 text-sm mb-6">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <?php echo htmlspecialchars($user['email']); ?>
                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="pt-6 border-t border-gray-100">
                        <div class="flex items-center justify-center gap-2 text-sm text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Member since <?php echo date('M Y', strtotime($user['created_at'] ?? 'now')); ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- General Information Card -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-2xl transition-all duration-300">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-100 to-gray-300 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">General Information</h3>
                    </div>
                    <form action="<?php echo BASE_URL; ?>/profile/update-general" method="POST" class="space-y-6">
                        <div>
                            <label for="username" class="block text-sm font-bold text-gray-700 mb-2">Username</label>
                            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[--color-primary-orange] transition-colors">
                        </div>
                        <div>
                            <button type="submit"
                                    class="px-8 py-3 bg-gradient-to-r from-[--color-primary-orange] to-orange-600 text-white font-bold rounded-xl hover:shadow-lg transition-all transform hover:scale-105">
                                Update Username
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Security Card -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-2xl transition-all duration-300">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-100 to-gray-300 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Security Settings</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                            <div class="px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl text-gray-900">
                                <?php echo htmlspecialchars($user['email']); ?>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">Email cannot be changed</p>
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label for="phone_number" class="block text-sm font-bold text-gray-700 mb-2">Phone Number</label>
                            <form action="<?php echo BASE_URL; ?>/profile/update-phone" method="POST" class="space-y-3">
                                <input type="text" id="phone_number" name="phone_number"
                                       value="<?php echo htmlspecialchars($user['phone_number'] ?? ''); ?>"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[--color-primary-orange] transition-colors"
                                       placeholder="e.g., 9123456789"
                                       maxlength="10" pattern="[0-9]{10}" title="Please enter exactly 10 digits">
                                <button type="submit"
                                        class="w-full px-6 py-2 bg-gradient-to-r from-[--color-primary-orange] to-orange-600 text-white font-bold rounded-xl hover:shadow-lg transition-all text-sm">
                                    <?php echo empty($user['phone_number']) ? 'Add Number' : 'Update Number'; ?>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Saved Addresses Card -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-2xl transition-all duration-300">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-100 to-gray-300 flex items-center justify-center">
                                <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">Saved Addresses</h3>
                        </div>
                        <button id="add-address-btn" class="px-6 py-3 bg-gradient-to-r from-[--color-primary-orange] to-orange-600 text-white font-bold rounded-xl hover:shadow-lg transition-all transform hover:scale-105 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Add New Address
                        </button>
                    </div>
                    
                    <div id="addresses-container" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php if (empty($addresses)): ?>
                            <div class="col-span-2 text-center py-12">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <p class="text-gray-500 text-lg font-medium">No saved addresses yet</p>
                                <p class="text-gray-400 text-sm mt-2">Add your first address to make checkout faster!</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($addresses as $address): ?>
                                <div class="border-2 border-gray-200 rounded-xl p-6 hover:border-[--color-primary-orange] transition-all">
                                    <div class="flex items-start gap-3 mb-4">
                                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-[--color-primary-orange]/20 to-orange-200 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-[--color-primary-orange]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between gap-2 mb-1">
                                                <h4 class="text-lg font-bold text-gray-900"><?php echo htmlspecialchars($address['label']); ?></h4>
                                                <?php if ($address['is_default']): ?>
                                                    <span class="px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full flex-shrink-0">Default</span>
                                                <?php endif; ?>
                                            </div>
                                            <p class="text-sm text-gray-700 font-semibold"><?php echo htmlspecialchars($address['first_name'] . ' ' . $address['last_name']); ?></p>
                                        </div>
                                    </div>
                                    <div class="space-y-2 text-sm text-gray-600 mb-4">
                                        <p><?php echo htmlspecialchars($address['address']); ?></p>
                                        <p><?php echo htmlspecialchars($address['city'] . ', ' . $address['state'] . ' ' . $address['zip_code']); ?></p>
                                        <p class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            <?php echo htmlspecialchars($address['country_code'] . ' ' . $address['mobile_number']); ?>
                                        </p>
                                    </div>
                                    <div class="flex gap-2 pt-4 border-t border-gray-100">
                                        <button class="edit-address-btn flex-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold rounded-lg transition-all text-sm"
                                                data-address-id="<?php echo $address['id']; ?>"
                                                data-address='<?php echo htmlspecialchars(json_encode($address), ENT_QUOTES, 'UTF-8'); ?>'>
                                            Edit
                                        </button>
                                        <button class="delete-address-btn flex-1 px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 font-semibold rounded-lg transition-all text-sm"
                                                data-address-id="<?php echo $address['id']; ?>">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Address Modal -->
<div id="address-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b border-gray-200 px-8 py-6 flex items-center justify-between">
            <h3 id="modal-title" class="text-2xl font-bold text-gray-900">Add New Address</h3>
            <button id="close-modal" class="w-10 h-10 rounded-full hover:bg-gray-100 flex items-center justify-center transition-colors">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form id="address-form" class="p-8 space-y-6">
            <input type="hidden" id="address-id" name="address_id">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Address Label<span class="text-red-500">*</span></label>
                <input type="text" id="address-label" name="label" placeholder="e.g., Home, Office, Work" required
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[--color-primary-orange] transition-colors">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">First Name<span class="text-red-500">*</span></label>
                    <input type="text" id="address-first-name" name="first_name" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[--color-primary-orange] transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Last Name<span class="text-red-500">*</span></label>
                    <input type="text" id="address-last-name" name="last_name" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[--color-primary-orange] transition-colors">
                </div>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                <input type="email" id="address-email" name="email"
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[--color-primary-orange] transition-colors">
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div class="col-span-1">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Code</label>
                    <select id="address-country-code" name="country_code" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[--color-primary-orange] transition-colors">
                        <option value="+63">+63</option>
                        <option value="+1">+1</option>
                        <option value="+44">+44</option>
                        <option value="+61">+61</option>
                    </select>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Mobile Number<span class="text-red-500">*</span></label>
                    <input type="tel" id="address-mobile" name="mobile_number" placeholder="9123456789" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[--color-primary-orange] transition-colors">
                </div>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Street Address<span class="text-red-500">*</span></label>
                <input type="text" id="address-street" name="address" required
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[--color-primary-orange] transition-colors">
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">City<span class="text-red-500">*</span></label>
                    <input type="text" id="address-city" name="city" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[--color-primary-orange] transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">State<span class="text-red-500">*</span></label>
                    <input type="text" id="address-state" name="state" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[--color-primary-orange] transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Zip Code<span class="text-red-500">*</span></label>
                    <input type="text" id="address-zip" name="zip_code" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[--color-primary-orange] transition-colors">
                </div>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" id="address-default" name="is_default" class="w-4 h-4 text-[--color-primary-orange] border-gray-300 rounded focus:ring-[--color-primary-orange]">
                <label for="address-default" class="text-sm font-medium text-gray-700">Set as default address</label>
            </div>
            <div class="flex gap-4 pt-4">
                <button type="button" id="cancel-modal" class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold rounded-xl transition-colors">
                    Cancel
                </button>
                <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-[--color-primary-orange] to-orange-600 text-white font-bold rounded-xl hover:shadow-lg transition-all">
                    Save Address
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const successMsg = urlParams.get('success_msg');
        const errorMsg = urlParams.get('error_msg');

        if (successMsg) {
            alertMessage('success', decodeURIComponent(successMsg));
        } else if (errorMsg) {
            alertMessage('error', decodeURIComponent(errorMsg));
        }
        if (successMsg || errorMsg) {
            urlParams.delete('success_msg');
            urlParams.delete('error_msg');
            const newUrl = window.location.pathname + (urlParams.toString() ? '?' + urlParams.toString() : '');
            window.history.replaceState({}, document.title, newUrl);
        }

        // Address Management
        const modal = document.getElementById('address-modal');
        const addAddressBtn = document.getElementById('add-address-btn');
        const closeModal = document.getElementById('close-modal');
        const cancelModal = document.getElementById('cancel-modal');
        const addressForm = document.getElementById('address-form');
        const modalTitle = document.getElementById('modal-title');
        let editingAddressId = null;

        // Open modal for new address
        addAddressBtn.addEventListener('click', () => {
            editingAddressId = null;
            modalTitle.textContent = 'Add New Address';
            addressForm.reset();
            document.getElementById('address-id').value = '';
            modal.classList.remove('hidden');
        });

        // Close modal
        closeModal.addEventListener('click', () => modal.classList.add('hidden'));
        cancelModal.addEventListener('click', () => modal.classList.add('hidden'));

        // Close modal on outside click
        modal.addEventListener('click', (e) => {
            if (e.target === modal) modal.classList.add('hidden');
        });

        // Edit address
        document.querySelectorAll('.edit-address-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const addressData = JSON.parse(this.dataset.address);
                editingAddressId = addressData.id;
                modalTitle.textContent = 'Edit Address';
                
                document.getElementById('address-id').value = addressData.id;
                document.getElementById('address-label').value = addressData.label;
                document.getElementById('address-first-name').value = addressData.first_name;
                document.getElementById('address-last-name').value = addressData.last_name;
                document.getElementById('address-email').value = addressData.email || '';
                document.getElementById('address-country-code').value = addressData.country_code;
                document.getElementById('address-mobile').value = addressData.mobile_number;
                document.getElementById('address-street').value = addressData.address;
                document.getElementById('address-city').value = addressData.city;
                document.getElementById('address-state').value = addressData.state;
                document.getElementById('address-zip').value = addressData.zip_code;
                document.getElementById('address-default').checked = addressData.is_default == 1;
                
                modal.classList.remove('hidden');
            });
        });

        // Delete address
        document.querySelectorAll('.delete-address-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const addressId = this.dataset.addressId;
                if (confirm('Are you sure you want to delete this address?')) {
                    const formData = new FormData();
                    formData.append('address_id', addressId);
                    
                    fetch(BASE_URL + '/user/addresses/delete', {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alertMessage('success', data.message);
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            alertMessage('error', data.error);
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alertMessage('error', 'Failed to delete address');
                    });
                }
            });
        });

        // Handle form submission
        addressForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const url = editingAddressId 
                ? BASE_URL + '/user/addresses/update' 
                : BASE_URL + '/user/addresses/create';
            
            fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alertMessage('success', data.message);
                    modal.classList.add('hidden');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    alertMessage('error', data.error);
                }
            })
            .catch(err => {
                console.error(err);
                alertMessage('error', 'Failed to save address');
            });
        });
    });
</script>
