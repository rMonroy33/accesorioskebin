@extends('layouts.admin')

@section('title', 'Productos')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h3 class="text-2xl font-bold text-white">Productos</h3>
        <p class="mt-1 text-sm text-white/60">Administra los productos del catálogo.</p>
    </div>

    <a href="{{ route('admin.products.create') }}"
       class="rounded-2xl bg-[#c9a86a] px-5 py-3 text-sm font-semibold text-black transition hover:opacity-90">
        Nuevo producto
    </a>
</div>

<form method="GET" action="{{ route('admin.products.index') }}"
      class="mb-6 rounded-3xl border border-white/10 bg-[#151515] p-5">
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
        <div class="xl:col-span-2">
            <label class="mb-2 block text-sm font-medium text-white/80">Buscar</label>
            <input
                type="text"
                name="q"
                value="{{ $busqueda }}"
                placeholder="Nombre o SKU..."
                class="w-full rounded-2xl border border-white/10 bg-[#111111] px-4 py-3 text-sm text-white focus:border-[#c9a86a] focus:outline-none"
            >
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-white/80">Categoría</label>
            <select
                name="category"
                class="w-full rounded-2xl border border-white/10 bg-[#111111] px-4 py-3 text-sm text-white focus:border-[#c9a86a] focus:outline-none"
            >
                <option value="">Todas</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ (string) $categoria === (string) $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-white/80">Estado</label>
            <select
                name="status"
                class="w-full rounded-2xl border border-white/10 bg-[#111111] px-4 py-3 text-sm text-white focus:border-[#c9a86a] focus:outline-none"
            >
                <option value="">Todos</option>
                <option value="1" {{ (string) $estado === '1' ? 'selected' : '' }}>Activos</option>
                <option value="0" {{ (string) $estado === '0' ? 'selected' : '' }}>Inactivos</option>
            </select>
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-white/80">Stock</label>
            <select
                name="stock"
                class="w-full rounded-2xl border border-white/10 bg-[#111111] px-4 py-3 text-sm text-white focus:border-[#c9a86a] focus:outline-none"
            >
                <option value="">Todos</option>
                <option value="disponibles" {{ $stock === 'disponibles' ? 'selected' : '' }}>Disponibles</option>
                <option value="agotados" {{ $stock === 'agotados' ? 'selected' : '' }}>Agotados</option>
                <option value="minimo" {{ $stock === 'minimo' ? 'selected' : '' }}>Stock mínimo</option>
            </select>
        </div>
    </div>

    <div class="mt-4 flex flex-wrap gap-3">
        <button type="submit"
                class="rounded-2xl bg-[#c9a86a] px-5 py-3 text-sm font-semibold text-black transition hover:opacity-90">
            Aplicar filtros
        </button>

        <a href="{{ route('admin.products.index') }}"
           class="rounded-2xl border border-white/10 px-5 py-3 text-sm font-semibold text-white transition hover:border-red-400 hover:text-red-400">
            Limpiar
        </a>
    </div>
</form>

<div class="mb-4 flex flex-wrap gap-3">
    @if($busqueda)
        <span class="rounded-full border border-[#c9a86a]/40 bg-[#c9a86a]/10 px-4 py-2 text-sm text-[#e6c78f]">
            Búsqueda: {{ $busqueda }}
        </span>
    @endif

    @if($categoria)
        @php($categoriaNombre = $categories->firstWhere('id', (int) $categoria)?->name)
        @if($categoriaNombre)
            <span class="rounded-full border border-[#c9a86a]/40 bg-[#c9a86a]/10 px-4 py-2 text-sm text-[#e6c78f]">
                Categoría: {{ $categoriaNombre }}
            </span>
        @endif
    @endif

    @if($estado !== null && $estado !== '')
        <span class="rounded-full border border-[#c9a86a]/40 bg-[#c9a86a]/10 px-4 py-2 text-sm text-[#e6c78f]">
            Estado: {{ $estado == '1' ? 'Activos' : 'Inactivos' }}
        </span>
    @endif

    @if($stock)
        <span class="rounded-full border border-[#c9a86a]/40 bg-[#c9a86a]/10 px-4 py-2 text-sm text-[#e6c78f]">
            Stock: {{ $stock }}
        </span>
    @endif
</div>

<div class="overflow-hidden rounded-3xl border border-white/10 bg-[#151515]">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="border-b border-white/10 bg-white/5 text-left text-white/60">
                <tr>
                    <th class="px-5 py-4">Producto</th>
                    <th class="px-5 py-4">Categoría</th>
                    <th class="px-5 py-4">Subcategoría</th>
                    <th class="px-5 py-4">SKU</th>
                    <th class="px-5 py-4">Precio</th>
                    <th class="px-5 py-4">Stock</th>
                    <th class="px-5 py-4">Estado</th>
                    <th class="px-5 py-4 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr class="border-b border-white/5">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-4">
                                <div class="h-14 w-14 overflow-hidden rounded-2xl border border-white/10 bg-[#111111]">
                                    @if($product->main_image)
                                        <img src="{{ asset('storage/' . $product->main_image) }}"
                                             alt="{{ $product->name }}"
                                             class="h-full w-full object-cover">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center text-xs text-white/30">
                                            Sin imagen
                                        </div>
                                    @endif
                                </div>

                                <div>
                                    <p class="font-medium text-white">{{ $product->name }}</p>
                                    <div class="mt-1 flex flex-wrap gap-2">
                                        @if($product->is_featured)
                                            <span class="rounded-full bg-blue-500/15 px-2 py-1 text-[10px] font-semibold text-blue-300">Destacado</span>
                                        @endif
                                        @if($product->is_new)
                                            <span class="rounded-full bg-[#c9a86a]/15 px-2 py-1 text-[10px] font-semibold text-[#e6c78f]">Nuevo</span>
                                        @endif
                                        @if($product->is_on_sale)
                                            <span class="rounded-full bg-red-500/15 px-2 py-1 text-[10px] font-semibold text-red-300">Oferta</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-white/60">{{ $product->category?->name }}</td>
                        <td class="px-5 py-4 text-white/60">{{ $product->subcategory?->name ?? '—' }}</td>
                        <td class="px-5 py-4 text-white/60">{{ $product->sku }}</td>
                        <td class="px-5 py-4 text-white/60">
                            @if($product->sale_price)
                                <span class="text-white">${{ number_format($product->sale_price, 2) }}</span>
                                <span class="ml-2 text-xs line-through">${{ number_format($product->price, 2) }}</span>
                            @else
                                ${{ number_format($product->price, 2) }}
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            <span class="{{ $product->stock <= 0 ? 'text-red-300' : ($product->stock <= $product->min_stock && $product->stock > 0 ? 'text-yellow-300' : 'text-white/60') }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $product->status ? 'bg-green-500/15 text-green-300' : 'bg-red-500/15 text-red-300' }}">
                                {{ $product->status ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="rounded-xl border border-white/10 px-3 py-2 text-xs text-white hover:border-[#c9a86a] hover:text-[#c9a86a]">
                                    Editar
                                </a>

                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('¿Eliminar este producto?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="rounded-xl border border-red-500/20 px-3 py-2 text-xs text-red-300 hover:bg-red-500/10">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-5 py-8 text-center text-white/50">
                            No hay productos registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="border-t border-white/10 px-5 py-4">
        {{ $products->links() }}
    </div>
</div>
@endsection