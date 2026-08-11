<x-admin-layout>
    <x-slot name="title">View Product</x-slot>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">{{ $product->name }}</h1>
        <div class="flex gap-2">
            @can('edit products')
            <a href="{{ route('admin.products.edit', $product) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                Edit Product
            </a>
            @endcan
            <a href="{{ route('admin.products.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                Back to Products
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Images -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Product Images</h2>
                @if($product->getMedia('images')->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @foreach($product->getMedia('images') as $media)
                        <div class="relative group">
                            <img src="{{ $media->getUrl() }}" alt="{{ $product->name }}" class="w-full h-32 object-cover rounded-lg">
                            <a href="{{ $media->getUrl() }}" target="_blank" class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all rounded-lg">
                                <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                </svg>
                            </a>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">No images uploaded</p>
                @endif
            </div>

            <!-- Description -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Description</h2>
                <div class="prose prose-gray max-w-none">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>

            @if($product->benefits)
            <div class="bg-green-50 rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Benefits</h2>
                <div class="prose prose-gray max-w-none">
                    {!! nl2br(e($product->benefits)) !!}
                </div>
            </div>
            @endif

            @if($product->usage_instructions)
            <div class="bg-blue-50 rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Usage Instructions</h2>
                <div class="prose prose-gray max-w-none">
                    {!! nl2br(e($product->usage_instructions)) !!}
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Product Info Card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Product Information</h2>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Category</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $product->category->name ?? 'No Category' }}</dd>
                    </div>

                    @if($product->price)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Price</dt>
                        <dd class="mt-1 text-sm font-semibold text-green-600">Rp {{ number_format($product->price, 0, ',', '.') }}</dd>
                    </div>
                    @endif

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Stock Quantity</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $product->stock_quantity ?? 0 }} units</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            @if($product->is_featured)
                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Featured
                            </span>
                            @endif
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Slug</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $product->slug }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Created</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $product->created_at->format('M d, Y') }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Certifications -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Certifications</h2>
                <div class="space-y-2">
                    @if($product->is_halal_certified)
                    <div class="flex items-center text-sm">
                        <span class="text-green-600 mr-2">✓</span>
                        <span>Halal MUI Certified</span>
                    </div>
                    @endif
                    @if($product->is_bpom_certified)
                    <div class="flex items-center text-sm">
                        <span class="text-green-600 mr-2">✓</span>
                        <span>BPOM Approved</span>
                    </div>
                    @endif
                    @if($product->is_natural)
                    <div class="flex items-center text-sm">
                        <span class="text-green-600 mr-2">✓</span>
                        <span>100% Natural</span>
                    </div>
                    @endif
                    @if(!$product->is_halal_certified && !$product->is_bpom_certified && !$product->is_natural)
                    <p class="text-gray-500 text-sm">No certifications added</p>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Actions</h2>
                <div class="space-y-2">
                    <a href="{{ route('products.show', $product->slug) }}" target="_blank" class="block w-full bg-blue-600 text-white text-center px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        View on Site
                    </a>
                    @can('delete products')
                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Are you sure you want to delete this product?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                            Delete Product
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

