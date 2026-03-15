<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categoriasDestacadas = Category::where('status', true)
            ->orderBy('sort_order')
            ->take(4)
            ->get();

        return view('web.home', compact('categoriasDestacadas'));
    }

    public function catalogo(Request $request)
    {
        $categorias = Category::with(['subcategories' => function ($query) {
                $query->where('status', true)->orderBy('sort_order');
            }])
            ->where('status', true)
            ->orderBy('sort_order')
            ->get();

        $busqueda = trim((string) $request->get('q', ''));
        $categoriaSlug = $request->get('categoria');
        $subcategoriaSlug = $request->get('subcategoria');
        $estado = $request->get('estado');
        $min = $request->get('min');
        $max = $request->get('max');
        $orden = $request->get('orden');

        $categoriaSeleccionada = $categoriaSlug
            ? $categorias->firstWhere('slug', $categoriaSlug)
            : null;

        $subcategoriaSeleccionada = $subcategoriaSlug
            ? $categorias
                ->flatMap(fn ($categoria) => $categoria->subcategories)
                ->firstWhere('slug', $subcategoriaSlug)
            : null;

        $productos = Product::with(['category', 'subcategory'])
            ->where('status', true);

        if ($busqueda !== '') {
            $productos->where(function ($query) use ($busqueda) {
                $query->where('name', 'like', "%{$busqueda}%")
                    ->orWhere('short_description', 'like', "%{$busqueda}%")
                    ->orWhere('description', 'like', "%{$busqueda}%");
            });
        }

        if ($categoriaSeleccionada) {
            $productos->whereHas('category', function ($query) use ($categoriaSeleccionada) {
                $query->where('slug', $categoriaSeleccionada->slug);
            });
        }

        if ($subcategoriaSeleccionada) {
            $productos->whereHas('subcategory', function ($query) use ($subcategoriaSeleccionada) {
                $query->where('slug', $subcategoriaSeleccionada->slug);
            });
        }

        if ($estado === 'disponibles') {
            $productos->where('stock', '>', 0);
        }

        if ($estado === 'agotados') {
            $productos->where('stock', '<=', 0);
        }

        if ($min !== null && $min !== '') {
            $productos->whereRaw('COALESCE(sale_price, price) >= ?', [(float) $min]);
        }

        if ($max !== null && $max !== '') {
            $productos->whereRaw('COALESCE(sale_price, price) <= ?', [(float) $max]);
        }

        switch ($orden) {
            case 'nuevos':
                $productos->orderByDesc('is_new')->orderByDesc('id');
                break;
            case 'menor_precio':
                $productos->orderByRaw('COALESCE(sale_price, price) ASC');
                break;
            case 'mayor_precio':
                $productos->orderByRaw('COALESCE(sale_price, price) DESC');
                break;
            case 'ofertas':
                $productos->orderByDesc('is_on_sale')->orderByDesc('id');
                break;
            default:
                $productos->latest();
                break;
        }

        $productos = $productos->paginate(9)->withQueryString();

        $subcategoriasVisibles = $this->obtenerSubcategoriasVisibles($categorias, $categoriaSlug);

        return view('web.catalogo', compact(
            'categorias',
            'productos',
            'busqueda',
            'categoriaSeleccionada',
            'subcategoriaSeleccionada',
            'subcategoriasVisibles',
            'estado',
            'min',
            'max',
            'orden'
        ));
    }

    public function detalleProducto(string $slug)
    {
        $producto = Product::with(['category', 'subcategory', 'images'])
            ->where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        $relacionados = Product::with(['category', 'subcategory', 'images'])
            ->where('status', true)
            ->where('category_id', $producto->category_id)
            ->where('id', '!=', $producto->id)
            ->take(3)
            ->get();

        return view('web.producto-detalle', compact('producto', 'relacionados'));
    }

    public function comoComprar()
    {
        return view('web.como-comprar');
    }

    public function metodosPago()
    {
        return view('web.metodos-pago');
    }

    public function contacto()
    {
        return view('web.contacto');
    }

    private function obtenerSubcategoriasVisibles($categorias, $categoriaSlug)
    {
        if (!$categoriaSlug) {
            return collect();
        }

        $categoria = $categorias->firstWhere('slug', $categoriaSlug);

        if ($categoria) {
            return $categoria->subcategories;
        }

        return collect();
    }
}