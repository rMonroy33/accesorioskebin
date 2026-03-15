@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-2">
        <h3 class="text-2xl font-bold text-white">Panel de control</h3>
        <p class="text-sm text-white/60">Visión rápida del negocio y accesos directos.</p>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-3xl border border-white/10 bg-[#151515] p-5">
            <p class="text-sm text-white/60">Categorías</p>
            <h3 class="mt-2 text-3xl font-bold text-white">{{ $totalCategorias }}</h3>
            <p class="mt-1 text-xs text-white/45">Total de categorías activas e inactivas.</p>
        </div>

        <div class="rounded-3xl border border-white/10 bg-[#151515] p-5">
            <p class="text-sm text-white/60">Subcategorías</p>
            <h3 class="mt-2 text-3xl font-bold text-white">{{ $totalSubcategorias }}</h3>
            <p class="mt-1 text-xs text-white/45">Organización detallada del catálogo.</p>
        </div>

        <div class="rounded-3xl border border-white/10 bg-[#151515] p-5">
            <p class="text-sm text-white/60">Productos</p>
            <h3 class="mt-2 text-3xl font-bold text-white">{{ $totalProductos }}</h3>
            <p class="mt-1 text-xs text-white/45">Inventario total registrado.</p>
        </div>

        <div class="rounded-3xl border border-red-500/20 bg-[#151515] p-5">
            <p class="text-sm text-white/60">Agotados</p>
            <div class="mt-2 flex items-center gap-2">
                <h3 class="text-3xl font-bold text-white">{{ $agotados }}</h3>
                <span class="rounded-full bg-red-500/15 px-3 py-1 text-xs font-semibold text-red-200">Reponer</span>
            </div>
            <p class="mt-1 text-xs text-white/45">Stock en cero que requiere reposición.</p>
        </div>

        <div class="rounded-3xl border border-green-500/20 bg-[#151515] p-5">
            <p class="text-sm text-white/60">Productos activos</p>
            <h3 class="mt-2 text-3xl font-bold text-white">{{ $activos }}</h3>
            <p class="mt-1 text-xs text-white/45">Publicados y visibles en catálogo.</p>
        </div>

        <div class="rounded-3xl border border-white/10 bg-[#151515] p-5">
            <p class="text-sm text-white/60">Productos inactivos</p>
            <h3 class="mt-2 text-3xl font-bold text-white">{{ $inactivos }}</h3>
            <p class="mt-1 text-xs text-white/45">No visibles en la tienda.</p>
        </div>

        <div class="rounded-3xl border border-amber-500/20 bg-[#151515] p-5">
            <p class="text-sm text-white/60">Productos en oferta</p>
            <h3 class="mt-2 text-3xl font-bold text-white">{{ $enOferta }}</h3>
            <p class="mt-1 text-xs text-white/45">Con precios promocionales activos.</p>
        </div>

        <div class="rounded-3xl border border-[#c9a86a]/30 bg-[#151515] p-5">
            <p class="text-sm text-white/60">Productos destacados</p>
            <h3 class="mt-2 text-3xl font-bold text-white">{{ $destacados }}</h3>
            <p class="mt-1 text-xs text-white/45">Resaltados en el sitio.</p>
        </div>
    </div>

    <div class="grid gap-4 lg:grid-cols-3">
        <div class="rounded-3xl border border-white/10 bg-[#151515] p-5 lg:col-span-2">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h4 class="text-lg font-semibold text-white">Últimos productos</h4>
                    <p class="text-sm text-white/55">Lo más reciente en el catálogo (máx. 8).</p>
                </div>
                <a href="{{ route('admin.products.index') }}" class="text-sm font-semibold text-[#c9a86a] hover:text-white">Ver todos</a>
            </div>

            <div class="mt-4 overflow-hidden rounded-2xl border border-white/5">
                <div class="grid grid-cols-7 bg-white/5 px-4 py-3 text-xs font-semibold uppercase tracking-[0.2em] text-white/60">
                    <span>Nombre</span>
                    <span>Categoría</span>
                    <span>Subcategoría</span>
                    <span class="text-right">Precio</span>
                    <span class="text-right">Stock</span>
                    <span class="text-center">Estado</span>
                    <span class="text-center">Acciones</span>
                </div>

                <div class="divide-y divide-white/5">
                    @forelse($ultimosProductos as $producto)
                        <div class="grid grid-cols-7 items-center px-4 py-3 text-sm text-white/80">
                            <span class="truncate font-semibold text-white">{{ $producto->name }}</span>
                            <span class="truncate">{{ $producto->category->name ?? '—' }}</span>
                            <span class="truncate">{{ $producto->subcategory->name ?? '—' }}</span>
                            <span class="text-right">${{ number_format($producto->price, 2) }}</span>
                            <span class="text-right {{ $producto->stock <= 0 ? 'text-red-300' : '' }}">{{ $producto->stock }}</span>
                            <span class="flex items-center justify-center">
                                @if($producto->status)
                                    <span class="rounded-full bg-green-500/20 px-3 py-1 text-xs font-semibold text-green-200">Activo</span>
                                @else
                                    <span class="rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-white/70">Inactivo</span>
                                @endif
                            </span>
                            <div class="flex items-center justify-center">
                                <a href="{{ route('admin.products.edit', $producto) }}" class="text-sm font-semibold text-[#c9a86a] transition hover:text-white">Editar</a>
                            </div>
                        </div>
                    @empty
                        <div class="px-4 py-6 text-center text-sm text-white/60">
                            No hay productos registrados aún.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="rounded-3xl border border-white/10 bg-[#151515] p-5">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-lg font-semibold text-white">Resumen operativo</h4>
                    <p class="text-sm text-white/55">Acciones prioritarias.</p>
                </div>
                <span class="rounded-full bg-[#c9a86a]/15 px-3 py-1 text-xs font-semibold text-[#c9a86a]">Inventario</span>
            </div>

            <div class="mt-4 space-y-3">
                <div class="flex items-center justify-between rounded-2xl border border-red-500/20 bg-red-500/5 px-4 py-3">
                    <div>
                        <p class="text-sm font-semibold text-white">Productos agotados</p>
                        <p class="text-xs text-white/55">Reponer stock cuanto antes.</p>
                    </div>
                    <span class="rounded-full bg-red-500/15 px-3 py-1 text-sm font-bold text-red-200">{{ $agotados }}</span>
                </div>

                <div class="flex items-center justify-between rounded-2xl border border-amber-500/20 bg-amber-500/5 px-4 py-3">
                    <div>
                        <p class="text-sm font-semibold text-white">Stock mínimo</p>
                        <p class="text-xs text-white/55">Cerca del límite establecido.</p>
                    </div>
                    <span class="rounded-full bg-amber-500/15 px-3 py-1 text-sm font-bold text-amber-100">{{ $stockMinimo }}</span>
                </div>

                <div class="flex items-center justify-between rounded-2xl border border-amber-500/20 bg-amber-500/5 px-4 py-3">
                    <div>
                        <p class="text-sm font-semibold text-white">Productos en oferta</p>
                        <p class="text-xs text-white/55">Revisar precios y fechas.</p>
                    </div>
                    <span class="rounded-full bg-amber-500/15 px-3 py-1 text-sm font-bold text-amber-100">{{ $enOferta }}</span>
                </div>

                <div class="flex items-center justify-between rounded-2xl border border-[#c9a86a]/30 bg-[#c9a86a]/10 px-4 py-3">
                    <div>
                        <p class="text-sm font-semibold text-white">Productos destacados</p>
                        <p class="text-xs text-white/55">Optimiza su visibilidad.</p>
                    </div>
                    <span class="rounded-full bg-[#c9a86a]/20 px-3 py-1 text-sm font-bold text-[#f1e3c5]">{{ $destacados }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="rounded-3xl border border-white/10 bg-[#151515] p-5">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h4 class="text-lg font-semibold text-white">Accesos rápidos</h4>
                <p class="text-sm text-white/55">Acciones frecuentes del panel.</p>
            </div>
        </div>

        <div class="mt-4 grid gap-3 md:grid-cols-2 xl:grid-cols-3">
            <a href="{{ route('admin.categories.create') }}" class="group flex items-center justify-between rounded-2xl border border-white/10 bg-white/5 px-4 py-3 transition hover:border-[#c9a86a]/40 hover:bg-white/10">
                <div>
                    <p class="text-sm font-semibold text-white">Nueva categoría</p>
                    <p class="text-xs text-white/55">Organiza el catálogo.</p>
                </div>
                <span class="rounded-full bg-[#c9a86a]/20 px-3 py-1 text-xs font-bold text-[#c9a86a]">Crear</span>
            </a>

            <a href="{{ route('admin.subcategories.create') }}" class="group flex items-center justify-between rounded-2xl border border-white/10 bg-white/5 px-4 py-3 transition hover:border-[#c9a86a]/40 hover:bg-white/10">
                <div>
                    <p class="text-sm font-semibold text-white">Nueva subcategoría</p>
                    <p class="text-xs text-white/55">Mayor detalle de productos.</p>
                </div>
                <span class="rounded-full bg-[#c9a86a]/20 px-3 py-1 text-xs font-bold text-[#c9a86a]">Crear</span>
            </a>

            <a href="{{ route('admin.products.create') }}" class="group flex items-center justify-between rounded-2xl border border-white/10 bg-white/5 px-4 py-3 transition hover:border-[#c9a86a]/40 hover:bg-white/10">
                <div>
                    <p class="text-sm font-semibold text-white">Nuevo producto</p>
                    <p class="text-xs text-white/55">Publica un artículo.</p>
                </div>
                <span class="rounded-full bg-[#c9a86a]/20 px-3 py-1 text-xs font-bold text-[#c9a86a]">Crear</span>
            </a>

            <a href="{{ route('admin.products.index') }}" class="group flex items-center justify-between rounded-2xl border border-white/10 bg-white/5 px-4 py-3 transition hover:border-[#c9a86a]/40 hover:bg-white/10">
                <div>
                    <p class="text-sm font-semibold text-white">Ver productos</p>
                    <p class="text-xs text-white/55">Gestiona inventario.</p>
                </div>
                <span class="rounded-full bg-white/10 px-3 py-1 text-xs font-bold text-white/80">Ir</span>
            </a>

            <a href="{{ route('admin.categories.index') }}" class="group flex items-center justify-between rounded-2xl border border-white/10 bg-white/5 px-4 py-3 transition hover:border-[#c9a86a]/40 hover:bg-white/10">
                <div>
                    <p class="text-sm font-semibold text-white">Ver categorías</p>
                    <p class="text-xs text-white/55">Listado completo.</p>
                </div>
                <span class="rounded-full bg-white/10 px-3 py-1 text-xs font-bold text-white/80">Ir</span>
            </a>

            <a href="{{ route('admin.subcategories.index') }}" class="group flex items-center justify-between rounded-2xl border border-white/10 bg-white/5 px-4 py-3 transition hover:border-[#c9a86a]/40 hover:bg-white/10">
                <div>
                    <p class="text-sm font-semibold text-white">Ver subcategorías</p>
                    <p class="text-xs text-white/55">Gestión detallada.</p>
                </div>
                <span class="rounded-full bg-white/10 px-3 py-1 text-xs font-bold text-white/80">Ir</span>
            </a>
        </div>
    </div>
</div>
@endsection