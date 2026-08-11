<x-admin-layout>
    <x-slot name="title">Create Product</x-slot>

    <!-- Enhanced Header with Progress -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Create New Product</h1>
                <p class="text-gray-600 mt-1">Add a new product to your catalog</p>
            </div>
            <a href="{{ route('admin.products.index') }}"
               class="inline-flex items-center text-gray-600 hover:text-gray-900 mt-2 sm:mt-0 transition-colors">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                Back to Products
            </a>
        </div>

        <!-- Progress Steps -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-semibold">
                    1
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">Basic Info</p>
                    <p class="text-xs text-gray-500">Name & Category</p>
                </div>
            </div>
            <div class="flex-1 mx-4">
                <div class="h-1 bg-gray-200 rounded"></div>
            </div>
            <div class="flex items-center">
                <div class="w-8 h-8 bg-gray-300 text-white rounded-full flex items-center justify-center text-sm font-semibold">
                    2
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Details</p>
                    <p class="text-xs text-gray-400">Description & Images</p>
                </div>
            </div>
            <div class="flex-1 mx-4">
                <div class="h-1 bg-gray-200 rounded"></div>
            </div>
            <div class="flex items-center">
                <div class="w-8 h-8 bg-gray-300 text-white rounded-full flex items-center justify-center text-sm font-semibold">
                    3
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Review</p>
                    <p class="text-xs text-gray-400">Confirm & Save</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Form Container -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Form Header -->
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-green-100">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-green-600 rounded-xl flex items-center justify-center mr-3">
                    <i data-lucide="package-plus" class="w-5 h-5 text-white"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Product Information</h2>
                    <p class="text-sm text-gray-600">Fill in the details for your new product</p>
                </div>
            </div>
        </div>

        <!-- Form Content -->
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm" class="p-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Left Column - Basic Information -->
                <div class="space-y-6">
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center">
                            <i data-lucide="info" class="w-4 h-4 mr-2 text-green-600"></i>
                            Basic Information
                        </h3>

                        <!-- Product Name Field -->
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Product Name <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text"
                                       id="name"
                                       name="name"
                                       value="{{ old('name') }}"
                                       class="modern-input w-full px-4 py-3 pr-10 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 @error('name') border-red-500 bg-red-50 @enderror"
                                       placeholder="Enter product name"
                                       required>
                                <i data-lucide="tag" class="w-5 h-5 absolute right-3 top-3.5 text-gray-400"></i>
                            </div>
                            @error('name')
                                <div class="mt-2 flex items-start">
                                    <i data-lucide="alert-circle" class="w-4 h-4 text-red-500 mr-1 mt-0.5"></i>
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                </div>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500">Give your product a clear, descriptive name</p>
                        </div>

                        <!-- Category Field -->
                        <div class="mb-6">
                            <label for="product_category_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select id="product_category_id"
                                        name="product_category_id"
                                        class="modern-select w-full px-4 py-3 pr-10 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 appearance-none @error('product_category_id') border-red-500 bg-red-50 @enderror"
                                        required>
                                    <option value="">Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('product_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <i data-lucide="folder-open" class="w-5 h-5 absolute right-3 top-3.5 text-gray-400 pointer-events-none"></i>
                            </div>
                            @error('product_category_id')
                                <div class="mt-2 flex items-start">
                                    <i data-lucide="alert-circle" class="w-4 h-4 text-red-500 mr-1 mt-0.5"></i>
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>

                        <!-- Description Field -->
                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                Description <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <textarea id="description"
                                          name="description"
                                          rows="4"
                                          class="modern-textarea w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 resize-none @error('description') border-red-500 bg-red-50 @enderror"
                                          placeholder="Describe your product..."
                                          required>{{ old('description') }}</textarea>
                                <div class="absolute bottom-3 right-3 text-xs text-gray-500">
                                    <span id="descriptionCount">{{ old('description') ? strlen(old('description')) : 0 }}</span>/500
                                </div>
                            </div>
                            @error('description')
                                <div class="mt-2 flex items-start">
                                    <i data-lucide="alert-circle" class="w-4 h-4 text-red-500 mr-1 mt-0.5"></i>
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Right Column - Additional Details -->
                <div class="space-y-6">
                    <!-- Pricing and Stock -->
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center">
                            <i data-lucide="dollar-sign" class="w-4 h-4 mr-2 text-green-600"></i>
                            Pricing & Stock
                        </h3>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Price (IDR)
                                </label>
                                <div class="relative">
                                    <input type="number"
                                           id="price"
                                           name="price"
                                           value="{{ old('price') }}"
                                           step="0.01"
                                           min="0"
                                           class="modern-input w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                           placeholder="0">
                                    <span class="absolute right-3 top-3.5 text-gray-500 text-sm">Rp</span>
                                </div>
                            </div>

                            <div>
                                <label for="stock_quantity" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Stock Quantity
                                </label>
                                <div class="relative">
                                    <input type="number"
                                           id="stock_quantity"
                                           name="stock_quantity"
                                           value="{{ old('stock_quantity', 0) }}"
                                           min="0"
                                           class="modern-input w-full px-4 py-3 pr-10 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                           placeholder="0">
                                    <i data-lucide="package" class="w-5 h-5 absolute right-3 top-3.5 text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Certifications -->
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center">
                            <i data-lucide="shield-check" class="w-4 h-4 mr-2 text-green-600"></i>
                            Certifications
                        </h3>

                        <div class="space-y-3">
                            <label class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:border-green-300 transition-colors cursor-pointer">
                                <input type="checkbox"
                                       name="is_halal_certified"
                                       value="1"
                                       {{ old('is_halal_certified') ? 'checked' : '' }}
                                       class="modern-checkbox rounded border-gray-300 text-green-600 focus:ring-green-500 focus:ring-2">
                                <div class="ml-3">
                                    <span class="text-sm font-medium text-gray-900">Halal MUI Certified</span>
                                    <p class="text-xs text-gray-500">Certified halal by MUI</p>
                                </div>
                            </label>

                            <label class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:border-green-300 transition-colors cursor-pointer">
                                <input type="checkbox"
                                       name="is_bpom_certified"
                                       value="1"
                                       {{ old('is_bpom_certified') ? 'checked' : '' }}
                                       class="modern-checkbox rounded border-gray-300 text-green-600 focus:ring-green-500 focus:ring-2">
                                <div class="ml-3">
                                    <span class="text-sm font-medium text-gray-900">BPOM Approved</span>
                                    <p class="text-xs text-gray-500">Registered with BPOM</p>
                                </div>
                            </label>

                            <label class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:border-green-300 transition-colors cursor-pointer">
                                <input type="checkbox"
                                       name="is_natural"
                                       value="1"
                                       {{ old('is_natural') ? 'checked' : '' }}
                                       class="modern-checkbox rounded border-gray-300 text-green-600 focus:ring-green-500 focus:ring-2">
                                <div class="ml-3">
                                    <span class="text-sm font-medium text-gray-900">100% Natural</span>
                                    <p class="text-xs text-gray-500">Made from natural ingredients</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Status Options -->
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center">
                            <i data-lucide="settings" class="w-4 h-4 mr-2 text-green-600"></i>
                            Product Status
                        </h3>

                        <div class="space-y-3">
                            <label class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:border-green-300 transition-colors cursor-pointer">
                                <input type="checkbox"
                                       name="is_featured"
                                       value="1"
                                       {{ old('is_featured') ? 'checked' : '' }}
                                       class="modern-checkbox rounded border-gray-300 text-green-600 focus:ring-green-500 focus:ring-2">
                                <div class="ml-3">
                                    <span class="text-sm font-medium text-gray-900">Featured Product</span>
                                    <p class="text-xs text-gray-500">Show on homepage</p>
                                </div>
                            </label>

                            <label class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:border-green-300 transition-colors cursor-pointer">
                                <input type="checkbox"
                                       name="is_active"
                                       value="1"
                                       {{ old('is_active', true) ? 'checked' : '' }}
                                       class="modern-checkbox rounded border-gray-300 text-green-600 focus:ring-green-500 focus:ring-2">
                                <div class="ml-3">
                                    <span class="text-sm font-medium text-gray-900">Active</span>
                                    <p class="text-xs text-gray-500">Visible to customers</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Images Section -->
            <div class="mt-8 bg-gray-50 p-6 rounded-xl border border-gray-200">
                <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center">
                    <i data-lucide="image" class="w-4 h-4 mr-2 text-green-600"></i>
                    Product Images
                </h3>

                <!-- Drag & Drop Upload Area -->
                <div id="dropZone" class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-green-400 transition-colors cursor-pointer bg-white">
                    <i data-lucide="upload-cloud" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                    <p class="text-sm font-medium text-gray-700 mb-2">Drag & drop images here</p>
                    <p class="text-xs text-gray-500 mb-4">or click to browse</p>
                    <input type="file"
                           id="images"
                           name="images[]"
                           multiple
                           accept="image/*"
                           class="hidden">
                    <button type="button"
                            onclick="document.getElementById('images').click()"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm">
                        Choose Images
                    </button>
                </div>

                <!-- Image Preview Area -->
                <div id="imagePreview" class="mt-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 hidden">
                    <!-- Preview images will be added here dynamically -->
                </div>

                <p class="mt-4 text-xs text-gray-500">
                    <i data-lucide="info" class="w-3 h-3 inline mr-1"></i>
                    You can upload multiple images. Maximum file size: 2MB per image.
                </p>

                @error('images.*')
                    <div class="mt-4 flex items-start bg-red-50 p-3 rounded-lg border border-red-200">
                        <i data-lucide="alert-circle" class="w-4 h-4 text-red-500 mr-2 mt-0.5"></i>
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    </div>
                @enderror
            </div>

            <!-- Additional Text Areas -->
            <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label for="benefits" class="block text-sm font-semibold text-gray-700 mb-2">
                        Benefits
                    </label>
                    <textarea id="benefits"
                              name="benefits"
                              rows="4"
                              class="modern-textarea w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 resize-none"
                              placeholder="List the benefits of this product...">{{ old('benefits') }}</textarea>
                </div>

                <div>
                    <label for="usage_instructions" class="block text-sm font-semibold text-gray-700 mb-2">
                        Usage Instructions
                    </label>
                    <textarea id="usage_instructions"
                              name="usage_instructions"
                              rows="4"
                              class="modern-textarea w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 resize-none"
                              placeholder="How to use this product...">{{ old('usage_instructions') }}</textarea>
                </div>
            </div>

            <!-- Enhanced Submit Buttons -->
            <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-end bg-gray-50 p-6 rounded-xl border border-gray-200">
                <a href="{{ route('admin.products.index') }}"
                   class="inline-flex items-center justify-center px-6 py-3 bg-white border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors font-medium">
                    <i data-lucide="x" class="w-4 h-4 mr-2"></i>
                    Cancel
                </a>
                <button type="button"
                        onclick="saveAsDraft()"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition-colors font-medium">
                    <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                    Save as Draft
                </button>
                <button type="submit"
                        id="submitBtn"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-200 font-medium shadow-lg hover:shadow-xl transform hover:scale-105">
                    <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i>
                    <span id="submitText">Create Product</span>
                </button>
            </div>
        </form>
    </div>

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Character counter for description
        const descriptionField = document.getElementById('description');
        const descriptionCount = document.getElementById('descriptionCount');

        descriptionField.addEventListener('input', function() {
            const count = this.value.length;
            descriptionCount.textContent = count;

            if (count > 500) {
                descriptionCount.classList.add('text-red-500');
                this.value = this.value.substring(0, 500);
            } else {
                descriptionCount.classList.remove('text-red-500');
            }
        });

        // Drag & Drop functionality
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('images');
        const imagePreview = document.getElementById('imagePreview');

        dropZone.addEventListener('click', () => fileInput.click());

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('border-green-400', 'bg-green-50');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('border-green-400', 'bg-green-50');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-green-400', 'bg-green-50');

            const files = Array.from(e.dataTransfer.files);
            handleFiles(files);
        });

        fileInput.addEventListener('change', (e) => {
            const files = Array.from(e.target.files);
            handleFiles(files);
        });

        function handleFiles(files) {
            const imageFiles = files.filter(file => file.type.startsWith('image/'));

            if (imageFiles.length > 0) {
                imagePreview.classList.remove('hidden');
                imagePreview.innerHTML = '';

                imageFiles.forEach((file, index) => {
                    if (file.size > 2 * 1024 * 1024) {
                        alert(`File ${file.name} is too large. Maximum size is 2MB.`);
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const previewItem = document.createElement('div');
                        previewItem.className = 'relative group';
                        previewItem.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg border-2 border-gray-200">
                            <button type="button" onclick="removeImage(${index})" class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <i data-lucide="x" class="w-3 h-3"></i>
                            </button>
                            <div class="mt-1 text-xs text-gray-500 truncate">${file.name}</div>
                        `;
                        imagePreview.appendChild(previewItem);
                        lucide.createIcons();
                    };
                    reader.readAsDataURL(file);
                });
            }
        }

        function removeImage(index) {
            const fileInput = document.getElementById('images');
            const dt = new DataTransfer();
            const files = Array.from(fileInput.files);

            files.splice(index, 1);
            files.forEach(file => dt.items.add(file));
            fileInput.files = dt.files;

            // Re-render preview
            handleFiles(dt.files);
        }

        // Form submission with loading state
        const form = document.getElementById('productForm');
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');

        form.addEventListener('submit', function(e) {
            submitBtn.disabled = true;
            submitText.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 mr-2 animate-spin"></i> Creating...';
            lucide.createIcons();
        });

        function saveAsDraft() {
            // Implementation for saving as draft
            const statusCheckbox = document.querySelector('input[name="is_active"]');
            statusCheckbox.checked = false;
            form.submit();
        }

        // Real-time validation
        document.getElementById('name').addEventListener('blur', function() {
            if (this.value.length < 3) {
                this.classList.add('border-red-500', 'bg-red-50');
                this.classList.remove('border-green-500');
            } else {
                this.classList.add('border-green-500');
                this.classList.remove('border-red-500', 'bg-red-50');
            }
        });

        // Re-initialize icons periodically
        setInterval(() => lucide.createIcons(), 1000);
    </script>
</x-admin-layout>

