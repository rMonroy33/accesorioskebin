<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    public function index(Request $request)
    {
        $busqueda = trim((string) $request->get('q', ''));
        $estado = $request->get('status');
        $categoria = $request->get('category');

        $subcategories = Subcategory::with('category')
            ->when($busqueda !== '', function ($query) use ($busqueda) {
                $query->where(function ($q) use ($busqueda) {
                    $q->where('name', 'like', "%{$busqueda}%")
                        ->orWhere('slug', 'like', "%{$busqueda}%");
                });
            })
            ->when($estado !== null && $estado !== '', function ($query) use ($estado) {
                $query->where('status', (bool) $estado);
            })
            ->when($categoria, function ($query) use ($categoria) {
                $query->where('category_id', $categoria);
            })
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        $categories = Category::where('status', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('admin.subcategories.index', compact('subcategories', 'categories', 'busqueda', 'estado', 'categoria'));
    }

    public function create()
    {
        $categories = Category::where('status', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.subcategories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer'],
            'status' => ['nullable', 'boolean'],
        ]);

        Subcategory::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'status' => $request->boolean('status'),
        ]);

        return redirect()
            ->route('admin.subcategories.index')
            ->with('success', 'Subcategoría creada correctamente.');
    }

    public function show(Subcategory $subcategory)
    {
        return redirect()->route('admin.subcategories.edit', $subcategory);
    }

    public function edit(Subcategory $subcategory)
    {
        $categories = Category::where('status', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer'],
            'status' => ['nullable', 'boolean'],
        ]);

        $subcategory->update([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'status' => $request->boolean('status'),
        ]);

        return redirect()
            ->route('admin.subcategories.index')
            ->with('success', 'Subcategoría actualizada correctamente.');
    }

    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();

        return redirect()
            ->route('admin.subcategories.index')
            ->with('success', 'Subcategoría eliminada correctamente.');
    }
}