<x-admin-layout>
    <x-slot name="title">Products Management</x-slot>

    <!-- Enhanced Header with Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-4 sm:space-y-0">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Products</h1>
            <p class="text-gray-600 mt-1">Manage your product inventory and catalog</p>
        </div>
        @can('create products')
            <a href="{{ route('admin.products.create') }}"
               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                <i data-lucide="plus-circle" class="w-5 h-5 mr-2"></i>
                Add Product
            </a>
        @endcan
    </div>

    <!-- Enhanced Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-br from-white to-blue-50 p-4 rounded-xl shadow-lg border border-blue-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Products</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $products->total() ?? 0 }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-xl">
                    <i data-lucide="package" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-green-50 p-4 rounded-xl shadow-lg border border-green-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Active</p>
                    <p class="text-2xl font-bold text-green-600">{{ $products->where('is_active', true)->count() ?? 0 }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-xl">
                    <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-yellow-50 p-4 rounded-xl shadow-lg border border-yellow-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Categories</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ \App\Models\ProductCategory::count() ?? 0 }}</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-xl">
                    <i data-lucide="folder" class="w-6 h-6 text-yellow-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-purple-50 p-4 rounded-xl shadow-lg border border-purple-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Avg Price</p>
                    <p class="text-2xl font-bold text-purple-600">Rp {{ number_format($products->avg('price') ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-xl">
                    <i data-lucide="trending-up" class="w-6 h-6 text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Table with Search and Filters -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Table Header with Search and Actions -->
        <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <h2 class="text-lg font-semibold text-gray-900">Product Catalog</h2>

                <div class="flex flex-col sm:flex-row gap-3">
                    <!-- Search Bar -->
                    <div class="relative">
                        <input type="text"
                               id="searchInput"
                               placeholder="Search products..."
                               class="w-full sm:w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm">
                        <i data-lucide="search" class="w-4 h-4 absolute left-3 top-2.5 text-gray-400"></i>
                    </div>

                    <!-- Filters Dropdown -->
                    <div class="flex gap-2">
                        <select id="categoryFilter" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm">
                            <option value="">All Categories</option>
                            @foreach(\App\Models\ProductCategory::all() as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>

                        <select id="statusFilter" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm">
                            <option value="">All Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>

                        <!-- Export Buttons -->
                        <button onclick="exportToCSV()" class="px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm">
                            <i data-lucide="download" class="w-4 h-4 inline mr-1"></i>
                            CSV
                        </button>

                        <button onclick="exportToPDF()" class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm">
                            <i data-lucide="file-text" class="w-4 h-4 inline mr-1"></i>
                            PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modern Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200" id="productsTable">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left">
                            <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider cursor-pointer hover:bg-gray-100" onclick="sortTable('name')">
                            Product <i data-lucide="arrow-up-down" class="w-3 h-3 inline ml-1"></i>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider cursor-pointer hover:bg-gray-100" onclick="sortTable('category')">
                            Category <i data-lucide="arrow-up-down" class="w-3 h-3 inline ml-1"></i>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider cursor-pointer hover:bg-gray-100" onclick="sortTable('price')">
                            Price <i data-lucide="arrow-up-down" class="w-3 h-3 inline ml-1"></i>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50 transition-colors product-row" data-name="{{ strtolower($product->name) }}" data-category="{{ $product->category->id ?? '' }}" data-status="{{ $product->is_active }}">
                        <td class="px-6 py-4">
                            <input type="checkbox" class="product-checkbox rounded border-gray-300 text-green-600 focus:ring-green-500" value="{{ $product->id }}">
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($product->getFirstMediaUrl('images'))
                                    <img class="h-12 w-12 rounded-xl object-cover shadow-sm" src="{{ $product->getFirstMediaUrl('images') }}" alt="{{ $product->name }}">
                                @else
                                    <div class="h-12 w-12 rounded-xl bg-gray-100 flex items-center justify-center border-2 border-gray-200">
                                        <i data-lucide="image" class="w-6 h-6 text-gray-400"></i>
                                    </div>
                                @endif
                                <div class="ml-4">
                                    <div class="text-sm font-semibold text-gray-900">{{ $product->name }}</div>
                                    <div class="text-sm text-gray-500">{{ \Illuminate\Support\Str::limit(strip_tags($product->description), 60) }}</div>
                                    <div class="flex items-center mt-1 text-xs text-gray-400">
                                        <i data-lucide="calendar" class="w-3 h-3 mr-1"></i>
                                        {{ $product->created_at->format('M d, Y') }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $product->category->name ?? 'No Category' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-semibold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <span class="w-2 h-2 rounded-full mr-2 {{ $product->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.products.show', $product) }}"
                                   class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors"
                                   title="View">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                @can('edit products')
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                       class="p-2 text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 rounded-lg transition-colors"
                                       title="Edit">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </a>
                                @endcan
                                @can('delete products')
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors"
                                                title="Delete">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i data-lucide="package-x" class="w-12 h-12 text-gray-300 mb-4"></i>
                                <p class="text-gray-500 text-lg font-medium mb-2">No products found</p>
                                <p class="text-gray-400 text-sm mb-4">Get started by creating your first product</p>
                                @can('create products')
                                    <a href="{{ route('admin.products.create') }}"
                                       class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                        <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                                        Create Product
                                    </a>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Enhanced Pagination -->
        @if($products->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
            <div class="text-sm text-gray-700">
                Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results
            </div>
            <div class="flex items-center space-x-2">
                <button onclick="previousPage()" class="px-3 py-1 text-sm border border-gray-300 rounded-md hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </button>
                {{ $products->links() }}
                <button onclick="nextPage()" class="px-3 py-1 text-sm border border-gray-300 rounded-md hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
        @endif
    </div>

    <!-- Bulk Actions (Hidden by default) -->
    <div id="bulkActions" class="hidden fixed bottom-6 left-1/2 transform -translate-x-1/2 bg-white rounded-xl shadow-2xl border border-gray-200 p-4 z-50">
        <div class="flex items-center space-x-4">
            <span class="text-sm text-gray-600">
                <span id="selectedCount">0</span> items selected
            </span>
            <button onclick="bulkDelete()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm">
                <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i>
                Delete Selected
            </button>
            <button onclick="bulkExport()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm">
                <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                Export Selected
            </button>
            <button onclick="clearSelection()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors text-sm">
                Cancel
            </button>
        </div>
    </div>

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.product-row');

            rows.forEach(row => {
                const name = row.dataset.name;
                const description = row.querySelector('.text-gray-500').textContent.toLowerCase();

                if (name.includes(searchTerm) || description.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Filter functionality
        document.getElementById('categoryFilter').addEventListener('change', filterProducts);
        document.getElementById('statusFilter').addEventListener('change', filterProducts);

        function filterProducts() {
            const categoryFilter = document.getElementById('categoryFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;
            const rows = document.querySelectorAll('.product-row');

            rows.forEach(row => {
                const category = row.dataset.category;
                const status = row.dataset.status;

                const categoryMatch = !categoryFilter || category === categoryFilter;
                const statusMatch = !statusFilter || status === statusFilter;

                row.style.display = categoryMatch && statusMatch ? '' : 'none';
            });
        }

        // Select all functionality
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.product-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActions();
        });

        // Individual checkbox functionality
        document.querySelectorAll('.product-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkActions);
        });

        function updateBulkActions() {
            const checkboxes = document.querySelectorAll('.product-checkbox:checked');
            const bulkActions = document.getElementById('bulkActions');
            const selectedCount = document.getElementById('selectedCount');

            if (checkboxes.length > 0) {
                bulkActions.classList.remove('hidden');
                selectedCount.textContent = checkboxes.length;
            } else {
                bulkActions.classList.add('hidden');
            }
        }

        function clearSelection() {
            document.querySelectorAll('.product-checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });
            document.getElementById('selectAll').checked = false;
            updateBulkActions();
        }

        // Export functions
        function exportToCSV() {
            window.location.href = '{{ route("admin.products.export") }}?format=csv';
        }

        function exportToPDF() {
            window.location.href = '{{ route("admin.products.export") }}?format=pdf';
        }

        function bulkExport() {
            const selectedIds = Array.from(document.querySelectorAll('.product-checkbox:checked')).map(cb => cb.value);
            window.location.href = '{{ route("admin.products.export") }}?ids=' + selectedIds.join(',');
        }

        // Re-initialize icons periodically
        setInterval(() => lucide.createIcons(), 1000);
    </script>
</x-admin-layout>