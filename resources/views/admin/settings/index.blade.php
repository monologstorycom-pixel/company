<x-admin-layout>
    <x-slot name="title">System Settings</x-slot>

    <!-- Enhanced Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-4 sm:space-y-0">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">System Settings</h1>
            <p class="text-gray-600 mt-1">Configure your company information and system preferences</p>
        </div>
        <div class="flex items-center space-x-3">
            <span class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-700 rounded-lg text-sm font-medium">
                <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i>
                Auto-save enabled
            </span>
        </div>
    </div>

    <!-- Settings Tabs -->
    <div x-data="{ activeTab: 'company' }" class="space-y-6">
        <!-- Tab Navigation -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-2">
            <nav class="flex flex-wrap gap-2">
                <button @click="activeTab = 'company'"
                        :class="activeTab === 'company' ? 'bg-green-600 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100'"
                        class="flex items-center px-4 py-2.5 rounded-lg font-medium transition-all duration-200">
                    <i data-lucide="building-2" class="w-4 h-4 mr-2"></i>
                    Company
                </button>
                <button @click="activeTab = 'seo'"
                        :class="activeTab === 'seo' ? 'bg-green-600 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100'"
                        class="flex items-center px-4 py-2.5 rounded-lg font-medium transition-all duration-200">
                    <i data-lucide="search" class="w-4 h-4 mr-2"></i>
                    SEO
                </button>
                <button @click="activeTab = 'social'"
                        :class="activeTab === 'social' ? 'bg-green-600 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100'"
                        class="flex items-center px-4 py-2.5 rounded-lg font-medium transition-all duration-200">
                    <i data-lucide="share-2" class="w-4 h-4 mr-2"></i>
                    Social Media
                </button>
                <button @click="activeTab = 'maps'"
                        :class="activeTab === 'maps' ? 'bg-green-600 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100'"
                        class="flex items-center px-4 py-2.5 rounded-lg font-medium transition-all duration-200">
                    <i data-lucide="map-pin" class="w-4 h-4 mr-2"></i>
                    Maps
                </button>
            </nav>
        </div>

        <!-- Settings Form -->
        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Company Information Tab -->
            <div x-show="activeTab === 'company'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-green-50 to-emerald-50">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-600 rounded-xl flex items-center justify-center mr-3">
                                <i data-lucide="building-2" class="w-5 h-5 text-white"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Company Information</h2>
                                <p class="text-sm text-gray-600">Basic information about your company</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Company Name</label>
                                <div class="relative">
                                    <input type="text" name="settings[company_name]"
                                           value="{{ \App\Models\Setting::get('company_name', 'PT Lestari Jaya Bangsa') }}"
                                           class="w-full px-4 py-3 pr-10 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                                    <i data-lucide="building" class="w-5 h-5 absolute right-3 top-3.5 text-gray-400"></i>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Established Year</label>
                                <div class="relative">
                                    <input type="text" name="settings[company_established]"
                                           value="{{ \App\Models\Setting::get('company_established', '1992') }}"
                                           class="w-full px-4 py-3 pr-10 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                                    <i data-lucide="calendar" class="w-5 h-5 absolute right-3 top-3.5 text-gray-400"></i>
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Tagline</label>
                                <div class="relative">
                                    <input type="text" name="settings[company_tagline]"
                                           value="{{ \App\Models\Setting::get('company_tagline', 'Food & Herbal — Health and Flavour, United in One Choice') }}"
                                           class="w-full px-4 py-3 pr-10 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                                    <i data-lucide="quote" class="w-5 h-5 absolute right-3 top-3.5 text-gray-400"></i>
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Address</label>
                                <textarea name="settings[company_address]" rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 resize-none">{{ \App\Models\Setting::get('company_address', 'Jl. Raya Buntu - Sampang, Utara Pasar, Kali Minyak, Bangsa, Kec. Kebasen, Kabupaten Banyumas, Jawa Tengah 53282') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                                <div class="relative">
                                    <input type="text" name="settings[company_phone]"
                                           value="{{ \App\Models\Setting::get('company_phone', '(+62) 821-9698-146') }}"
                                           class="w-full px-4 py-3 pr-10 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                                    <i data-lucide="phone" class="w-5 h-5 absolute right-3 top-3.5 text-gray-400"></i>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                                <div class="relative">
                                    <input type="email" name="settings[company_email]"
                                           value="{{ \App\Models\Setting::get('company_email', '') }}"
                                           placeholder="info@company.com"
                                           class="w-full px-4 py-3 pr-10 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                                    <i data-lucide="mail" class="w-5 h-5 absolute right-3 top-3.5 text-gray-400"></i>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Working Hours</label>
                                <div class="relative">
                                    <input type="text" name="settings[working_hours]"
                                           value="{{ \App\Models\Setting::get('working_hours', '07:00 - 16:00') }}"
                                           class="w-full px-4 py-3 pr-10 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                                    <i data-lucide="clock" class="w-5 h-5 absolute right-3 top-3.5 text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO Settings Tab -->
            <div x-show="activeTab === 'seo'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center mr-3">
                                <i data-lucide="search" class="w-5 h-5 text-white"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">SEO Settings</h2>
                                <p class="text-sm text-gray-600">Optimize your site for search engines</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Default Meta Title</label>
                                <input type="text" name="settings[seo_title]"
                                       value="{{ \App\Models\Setting::get('seo_title', 'PT Lestari Jaya Bangsa - Food & Herbal Products') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                <p class="mt-1 text-xs text-gray-500">Recommended: 50-60 characters</p>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Default Keywords</label>
                                <input type="text" name="settings[seo_keywords]"
                                       value="{{ \App\Models\Setting::get('seo_keywords', 'herbal, food, natural products, halal, BPOM') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                <p class="mt-1 text-xs text-gray-500">Separate keywords with commas</p>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Default Meta Description</label>
                                <textarea name="settings[seo_description]" rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-none">{{ \App\Models\Setting::get('seo_description', 'PT Lestari Jaya Bangsa provides high-quality herbal and processed food products, committed to prioritising both health and taste.') }}</textarea>
                                <p class="mt-1 text-xs text-gray-500">Recommended: 150-160 characters</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media Tab -->
            <div x-show="activeTab === 'social'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-pink-50">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-purple-600 rounded-xl flex items-center justify-center mr-3">
                                <i data-lucide="share-2" class="w-5 h-5 text-white"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Social Media Links</h2>
                                <p class="text-sm text-gray-600">Connect your social media accounts</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i data-lucide="facebook" class="w-4 h-4 inline mr-1 text-blue-600"></i>
                                    Facebook URL
                                </label>
                                <input type="url" name="settings[social_facebook]"
                                       value="{{ \App\Models\Setting::get('social_facebook', '') }}"
                                       placeholder="https://facebook.com/yourpage"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i data-lucide="instagram" class="w-4 h-4 inline mr-1 text-pink-600"></i>
                                    Instagram URL
                                </label>
                                <input type="url" name="settings[social_instagram]"
                                       value="{{ \App\Models\Setting::get('social_instagram', '') }}"
                                       placeholder="https://instagram.com/yourprofile"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i data-lucide="twitter" class="w-4 h-4 inline mr-1 text-sky-500"></i>
                                    Twitter/X URL
                                </label>
                                <input type="url" name="settings[social_twitter]"
                                       value="{{ \App\Models\Setting::get('social_twitter', '') }}"
                                       placeholder="https://twitter.com/yourhandle"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i data-lucide="linkedin" class="w-4 h-4 inline mr-1 text-blue-700"></i>
                                    LinkedIn URL
                                </label>
                                <input type="url" name="settings[social_linkedin]"
                                       value="{{ \App\Models\Setting::get('social_linkedin', '') }}"
                                       placeholder="https://linkedin.com/company/yourcompany"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Maps Tab -->
            <div x-show="activeTab === 'maps'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-orange-50 to-amber-50">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-orange-600 rounded-xl flex items-center justify-center mr-3">
                                <i data-lucide="map-pin" class="w-5 h-5 text-white"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Google Maps Integration</h2>
                                <p class="text-sm text-gray-600">Configure map settings for your contact page</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Google Maps API Key</label>
                            <div class="relative">
                                <input type="text" name="settings[google_maps_api_key]"
                                       value="{{ \App\Models\Setting::get('google_maps_api_key', '') }}"
                                       placeholder="Enter your Google Maps API key"
                                       class="w-full px-4 py-3 pr-10 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200">
                                <i data-lucide="key" class="w-5 h-5 absolute right-3 top-3.5 text-gray-400"></i>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">
                                <i data-lucide="info" class="w-4 h-4 inline mr-1"></i>
                                Get your API key from <a href="https://console.cloud.google.com/google/maps-apis" target="_blank" class="text-orange-600 hover:underline">Google Cloud Console</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="flex justify-end">
                <button type="submit"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-200 font-medium shadow-lg hover:shadow-xl transform hover:scale-105">
                    <i data-lucide="save" class="w-5 h-5 mr-2"></i>
                    Save All Settings
                </button>
            </div>
        </form>
    </div>

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        lucide.createIcons();
        setInterval(() => lucide.createIcons(), 1000);
    </script>
</x-admin-layout>
