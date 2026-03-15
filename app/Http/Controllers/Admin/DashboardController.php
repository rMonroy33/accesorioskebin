<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCategorias = Category::count();
        $totalSubcategorias = Subcategory::count();
        $totalProductos = Product::count();

        $agotados = Product::where('stock', '<=', 0)->count();
        $activos = Product::where('status', true)->count();
        $inactivos = Product::where('status', false)->count();
        $enOferta = Product::where('is_on_sale', true)->count();
        $destacados = Product::where('is_featured', true)->count();
        $stockMinimo = Product::whereColumn('stock', '<=', 'min_stock')
            ->where('stock', '>', 0)
            ->count();

        $ultimosProductos = Product::with(['category:id,name', 'subcategory:id,name'])
            ->latest()
            ->take(8)
            ->get([
                'id',
                'name',
                'category_id',
                'subcategory_id',
                'price',
                'stock',
                'status',
                'is_on_sale',
                'is_featured',
                'slug',
                'created_at',
            ]);

        return view('admin.dashboard', compact(
            'totalCategorias',
            'totalSubcategorias',
            'totalProductos',
            'agotados',
            'activos',
            'inactivos',
            'enOferta',
            'destacados',
            'stockMinimo',
            'ultimosProductos'
        ));
    }
}