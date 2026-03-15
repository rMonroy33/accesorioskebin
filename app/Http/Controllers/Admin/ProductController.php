<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $busqueda = trim((string) $request->get('q', ''));
        $categoria = $request->get('category');
        $estado = $request->get('status');
        $stock = $request->get('stock');

        $categories = Category::where('status', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $products = Product::with(['category', 'subcategory'])
            ->when($busqueda !== '', function ($query) use ($busqueda) {
                $query->where(function ($q) use ($busqueda) {
                    $q->where('name', 'like', "%{$busqueda}%")
                        ->orWhere('sku', 'like', "%{$busqueda}%")
                        ->orWhere('short_description', 'like', "%{$busqueda}%");
                });
            })
            ->when($categoria, function ($query) use ($categoria) {
                $query->where('category_id', $categoria);
            })
            ->when($estado !== null && $estado !== '', function ($query) use ($estado) {
                $query->where('status', (bool) $estado);
            })
            ->when($stock, function ($query) use ($stock) {
                if ($stock === 'agotados') {
                    $query->where('stock', '<=', 0);
                }

                if ($stock === 'disponibles') {
                    $query->where('stock', '>', 0);
                }

                if ($stock === 'minimo') {
                    $query->whereColumn('stock', '<=', 'min_stock')
                        ->where('stock', '>', 0);
                }
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.products.index', compact(
            'products',
            'busqueda',
            'categories',
            'categoria',
            'estado',
            'stock'
        ));
    }

    public function create()
    {
        $categories = Category::where('status', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $subcategories = Subcategory::where('status', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'category_id', 'name']);

        return view('admin.products.create', compact('categories', 'subcategories'));
    }

    public function store(Request $request)
    {
        if (!$request->filled('sku')) {
            $request->merge(['sku' => $this->generateSequentialSku()]);
        }

        $validated = $this->validateProduct($request);

        DB::transaction(function () use ($request, $validated) {
            $imagePath = null;

            if ($request->hasFile('main_image')) {
                $imagePath = $request->file('main_image')->store('products', 'public');
            }

            $product = Product::create([
                'category_id' => $validated['category_id'],
                'subcategory_id' => $validated['subcategory_id'] ?? null,
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'sku' => $validated['sku'],
                'short_description' => $validated['short_description'] ?? null,
                'description' => $validated['description'] ?? null,
                'price' => $validated['price'],
                'sale_price' => $validated['sale_price'] ?? null,
                'stock' => $validated['stock'] ?? 0,
                'min_stock' => $validated['min_stock'] ?? 0,
                'main_image' => $imagePath,
                'is_featured' => $request->boolean('is_featured'),
                'is_new' => $request->boolean('is_new'),
                'is_on_sale' => $request->boolean('is_on_sale'),
                'status' => $request->boolean('status'),
            ]);

            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $index => $file) {
                    $path = $file->store('products/gallery', 'public');

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'sort_order' => $index + 1,
                    ]);
                }
            }
        });

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Producto creado correctamente.');
    }

    public function show(Product $product)
    {
        return redirect()->route('admin.products.edit', $product);
    }

    public function edit(Product $product)
    {
        $product->load('images');

        $categories = Category::where('status', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $subcategories = Subcategory::where('status', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'category_id', 'name']);

        return view('admin.products.edit', compact('product', 'categories', 'subcategories'));
    }

    public function update(Request $request, Product $product)
    {
        if (!$request->filled('sku')) {
            $request->merge(['sku' => $this->generateSequentialSku()]);
        }

        $validated = $this->validateProduct($request, $product->id);

        DB::transaction(function () use ($request, $validated, $product) {
            $imagePath = $product->main_image;

            if ($request->hasFile('main_image')) {
                if ($product->main_image && Storage::disk('public')->exists($product->main_image)) {
                    Storage::disk('public')->delete($product->main_image);
                }

                $imagePath = $request->file('main_image')->store('products', 'public');
            }

            $product->update([
                'category_id' => $validated['category_id'],
                'subcategory_id' => $validated['subcategory_id'] ?? null,
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'sku' => $validated['sku'],
                'short_description' => $validated['short_description'] ?? null,
                'description' => $validated['description'] ?? null,
                'price' => $validated['price'],
                'sale_price' => $validated['sale_price'] ?? null,
                'stock' => $validated['stock'] ?? 0,
                'min_stock' => $validated['min_stock'] ?? 0,
                'main_image' => $imagePath,
                'is_featured' => $request->boolean('is_featured'),
                'is_new' => $request->boolean('is_new'),
                'is_on_sale' => $request->boolean('is_on_sale'),
                'status' => $request->boolean('status'),
            ]);

            if ($request->hasFile('gallery_images')) {
                $ultimoOrden = $product->images()->max('sort_order') ?? 0;

                foreach ($request->file('gallery_images') as $index => $file) {
                    $path = $file->store('products/gallery', 'public');

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'sort_order' => $ultimoOrden + $index + 1,
                    ]);
                }
            }
        });

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $product)
    {
        if ($product->main_image && Storage::disk('public')->exists($product->main_image)) {
            Storage::disk('public')->delete($product->main_image);
        }

        foreach ($product->images as $image) {
            if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Producto eliminado correctamente.');
    }

    private function validateProduct(Request $request, ?int $productId = null): array
    {
        return $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'subcategory_id' => ['nullable', 'exists:subcategories,id'],
            'name' => ['required', 'string', 'max:180'],
            'sku' => [
                'required',
                'string',
                'max:80',
                Rule::unique('products', 'sku')->ignore($productId),
            ],
            'short_description' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'min_stock' => ['nullable', 'integer', 'min:0'],
            'main_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
    }

    public function destroyMainImage(Product $product)
    {
        if ($product->main_image && Storage::disk('public')->exists($product->main_image)) {
            Storage::disk('public')->delete($product->main_image);
        }

        $product->update([
            'main_image' => null,
        ]);

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('success', 'Imagen principal eliminada correctamente.');
    }

    private function generateSequentialSku(): string
    {
        $prefix = 'KEB-';

        $lastSku = Product::where('sku', 'like', $prefix . '%')
            ->orderBy('sku', 'desc')
            ->value('sku');

        $next = 1;

        if ($lastSku) {
            $number = (int) substr($lastSku, strlen($prefix));
            $next = $number + 1;
        }

        for ($i = 0; $i < 5; $i++) {
            $candidate = $prefix . str_pad((string) $next, 4, '0', STR_PAD_LEFT);

            if (!Product::where('sku', $candidate)->exists()) {
                return $candidate;
            }

            $next++;
        }

        return $prefix . strtoupper(Str::random(6));
    }
}