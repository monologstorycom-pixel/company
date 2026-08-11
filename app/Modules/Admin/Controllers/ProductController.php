<?php

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}

    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        $this->authorize('view products');

        $filters = [
            'search' => $request->input('search'),
            'status' => $request->input('status'),
            'category' => $request->input('category'),
            'featured' => $request->input('featured'),
        ];

        $products = $this->productService->getPaginated($filters, 15);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $this->authorize('create products');

        $categories = ProductCategory::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $data = $request->validated();
            
            // Convert boolean fields
            $data['is_halal_certified'] = $request->boolean('is_halal_certified');
            $data['is_bpom_certified'] = $request->boolean('is_bpom_certified');
            $data['is_natural'] = $request->boolean('is_natural');
            $data['is_featured'] = $request->boolean('is_featured');
            $data['is_active'] = $request->boolean('is_active', true);
            $data['stock_quantity'] = $data['stock_quantity'] ?? 0;

            // Get images
            $images = $request->hasFile('images') ? $request->file('images') : null;

            $this->productService->create($data, $images);

            return redirect()->route('admin.products.index')
                ->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create product: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $this->authorize('view products');

        $product->load(['category', 'media']);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $this->authorize('edit products');

        $product->load('media');
        $categories = ProductCategory::where('is_active', true)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            $data = $request->validated();
            
            // Convert boolean fields
            $data['is_halal_certified'] = $request->boolean('is_halal_certified');
            $data['is_bpom_certified'] = $request->boolean('is_bpom_certified');
            $data['is_natural'] = $request->boolean('is_natural');
            $data['is_featured'] = $request->boolean('is_featured');
            $data['is_active'] = $request->boolean('is_active', true);
            $data['stock_quantity'] = $data['stock_quantity'] ?? 0;

            // Get images
            $images = $request->hasFile('images') ? $request->file('images') : null;

            $this->productService->update($product->id, $data, $images);

            return redirect()->route('admin.products.index')
                ->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update product: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete products');

        try {
            $this->productService->delete($product->id);

            return redirect()->route('admin.products.index')
                ->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }

    /**
     * Remove a specific image from the product.
     */
    public function removeImage(Product $product, $mediaId)
    {
        $this->authorize('edit products');

        try {
            $success = $this->productService->removeImage($product->id, $mediaId);

            if ($success) {
                return back()->with('success', 'Image removed successfully.');
            }

            return back()->with('error', 'Image not found.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to remove image: ' . $e->getMessage());
        }
    }

    /**
     * Export products to CSV or PDF.
     */
    public function export(Request $request)
    {
        $this->authorize('view products');

        try {
            $format = $request->get('format', 'csv');
            $productIds = $request->get('ids', []);

            $products = Product::with(['category'])
                ->when(!empty($productIds), function ($query) use ($productIds) {
                    $query->whereIn('id', $productIds);
                })
                ->orderBy('created_at', 'desc')
                ->get();

            if ($format === 'csv') {
                $filename = 'products_' . date('Y-m-d_His') . '.csv';
                $headers = [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                ];

                $callback = function () use ($products) {
                    $file = fopen('php://output', 'w');
                    fputcsv($file, ['Name', 'Category', 'Price', 'Stock', 'Status', 'Created At']);

                    foreach ($products as $product) {
                        fputcsv($file, [
                            $product->name,
                            $product->category->name ?? 'No Category',
                            $product->price,
                            $product->stock_quantity,
                            $product->is_active ? 'Active' : 'Inactive',
                            $product->created_at->format('Y-m-d H:i:s')
                        ]);
                    }

                    fclose($file);
                };

                return response()->stream($callback, 200, $headers);
            }

            return back()->with('error', 'Export format not supported.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to export products: ' . $e->getMessage());
        }
    }
}
