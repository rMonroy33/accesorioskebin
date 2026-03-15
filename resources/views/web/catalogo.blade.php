@extends('layouts.web')

@section('content')
<section class="border-b border-white/10 bg-[#121212]">
    <div class="mx-auto max-w-7xl px-4 py-10 lg:px-8">
        <p class="text-sm uppercase tracking-[0.25em] text-[#c9a86a]">Catálogo</p>
        <h2 class="mt-2 text-3xl font-bold text-white md:text-4xl">
            Explora nuestros productos
        </h2>
        <p class="mt-3 max-w-2xl text-white/70">
            Encuentra accesorios, artículos para hogar, auto, moto, dama, caballero y tecnología.
            Agrega tus favoritos y realiza tu pedido por WhatsApp.
        </p>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-10 lg:px-8" x-data="{ filtrosAbiertos: false }">
    <form id="filtros-form" method="GET" action="{{ route('catalogo') }}">
        <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="relative w-full lg:max-w-xl">
                <input
                    type="text"
                    name="q"
                    value="{{ $busqueda }}"
                    placeholder="Buscar productos..."
                    oninput="clearTimeout(window.kebinSearchTimer); window.kebinSearchTimer = setTimeout(() => this.form.submit(), 500)"
                    class="w-full rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm text-white placeholder:text-white/40 focus:border-[#c9a86a] focus:outline-none"
                >
                <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-white/40">⌕</span>
            </div>

            <div class="flex items-center gap-3">
                <button
                    type="button"
                    @click="filtrosAbiertos = !filtrosAbiertos"
                    class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm font-medium text-white lg:hidden"
                >
                    Filtros
                </button>

                <select
                    name="orden"
                    onchange="this.form.submit()"
                    class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white focus:border-[#c9a86a] focus:outline-none"
                >
                    <option value="" class="bg-[#111]">Ordenar por</option>
                    <option value="nuevos" class="bg-[#111]" @selected($orden === 'nuevos')>Nuevos</option>
                    <option value="menor_precio" class="bg-[#111]" @selected($orden === 'menor_precio')>Menor precio</option>
                    <option value="mayor_precio" class="bg-[#111]" @selected($orden === 'mayor_precio')>Mayor precio</option>
                    <option value="ofertas" class="bg-[#111]" @selected($orden === 'ofertas')>Ofertas</option>
                </select>
            </div>
        </div>

        <div class="mb-6 flex flex-wrap gap-3">
            @if($categoriaSeleccionada)
                <a
                    href="{{ route('catalogo', request()->except('categoria', 'subcategoria', 'page')) }}"
                    class="inline-flex items-center gap-2 rounded-full border border-[#c9a86a]/40 bg-[#c9a86a]/10 px-4 py-2 text-sm text-[#e6c78f] transition hover:bg-[#c9a86a]/20"
                >
                    <span>Categoría: {{ $categoriaSeleccionada->name }}</span>
                    <span class="font-bold">×</span>
                </a>
            @endif

            @if($subcategoriaSeleccionada)
                <a
                    href="{{ route('catalogo', request()->except('subcategoria', 'page')) }}"
                    class="inline-flex items-center gap-2 rounded-full border border-[#c9a86a]/40 bg-[#c9a86a]/10 px-4 py-2 text-sm text-[#e6c78f] transition hover:bg-[#c9a86a]/20"
                >
                    <span>Subcategoría: {{ $subcategoriaSeleccionada->name }}</span>
                    <span class="font-bold">×</span>
                </a>
            @endif

            @if($estado)
                <a
                    href="{{ route('catalogo', request()->except('estado', 'page')) }}"
                    class="inline-flex items-center gap-2 rounded-full border border-[#c9a86a]/40 bg-[#c9a86a]/10 px-4 py-2 text-sm text-[#e6c78f] transition hover:bg-[#c9a86a]/20"
                >
                    <span>Estado: {{ $estado === 'disponibles' ? 'Disponibles' : 'Agotados' }}</span>
                    <span class="font-bold">×</span>
                </a>
            @endif

            @if($busqueda)
                <a
                    href="{{ route('catalogo', request()->except('q', 'page')) }}"
                    class="inline-flex items-center gap-2 rounded-full border border-[#c9a86a]/40 bg-[#c9a86a]/10 px-4 py-2 text-sm text-[#e6c78f] transition hover:bg-[#c9a86a]/20"
                >
                    <span>Búsqueda: {{ $busqueda }}</span>
                    <span class="font-bold">×</span>
                </a>
            @endif

            @if($min !== null && $min !== '')
                <a
                    href="{{ route('catalogo', request()->except('min', 'page')) }}"
                    class="inline-flex items-center gap-2 rounded-full border border-[#c9a86a]/40 bg-[#c9a86a]/10 px-4 py-2 text-sm text-[#e6c78f] transition hover:bg-[#c9a86a]/20"
                >
                    <span>Mín: ${{ $min }}</span>
                    <span class="font-bold">×</span>
                </a>
            @endif

            @if($max !== null && $max !== '')
                <a
                    href="{{ route('catalogo', request()->except('max', 'page')) }}"
                    class="inline-flex items-center gap-2 rounded-full border border-[#c9a86a]/40 bg-[#c9a86a]/10 px-4 py-2 text-sm text-[#e6c78f] transition hover:bg-[#c9a86a]/20"
                >
                    <span>Máx: ${{ $max }}</span>
                    <span class="font-bold">×</span>
                </a>
            @endif

            @if($orden)
                <a
                    href="{{ route('catalogo', request()->except('orden', 'page')) }}"
                    class="inline-flex items-center gap-2 rounded-full border border-[#c9a86a]/40 bg-[#c9a86a]/10 px-4 py-2 text-sm text-[#e6c78f] transition hover:bg-[#c9a86a]/20"
                >
                    <span>Orden: {{ str_replace('_', ' ', $orden) }}</span>
                    <span class="font-bold">×</span>
                </a>
            @endif
        </div>

        <div class="grid gap-8 lg:grid-cols-[280px_minmax(0,1fr)]">
            <aside
                class="space-y-6 rounded-3xl border border-white/10 bg-[#151515] p-6 lg:block"
                :class="{ 'block': filtrosAbiertos, 'hidden': !filtrosAbiertos }"
            >
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-[0.2em] text-[#c9a86a]">
                        Categorías
                    </h3>

                    <div class="mt-4 space-y-2">
                        <a
                            href="{{ route('catalogo', request()->except(['categoria', 'subcategoria', 'page'])) }}"
                            class="block rounded-xl px-3 py-2 text-sm text-white/75 transition hover:bg-white/5"
                        >
                            Todas
                        </a>

                        @foreach ($categorias as $categoria)
                            <a
                                href="{{ route('catalogo', array_merge(request()->except(['page', 'subcategoria']), ['categoria' => $categoria->slug])) }}"
                                class="block rounded-xl px-3 py-2 text-sm transition {{ $categoriaSeleccionada?->id === $categoria->id ? 'bg-[#c9a86a] text-black font-semibold' : 'text-white/75 hover:bg-white/5' }}"
                                >
                                    {{ $categoria->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                @if ($subcategoriasVisibles->count() > 0)
                    <div class="border-t border-white/10 pt-6">
                        <h3 class="text-sm font-semibold uppercase tracking-[0.2em] text-[#c9a86a]">
                            Subcategorías
                        </h3>

                        <div class="mt-4 space-y-2">
                            @if (!$categoriaSeleccionada)
                                <a
                                    href="{{ route('catalogo', request()->except(['subcategoria', 'page'])) }}"
                                    class="block rounded-xl px-3 py-2 text-sm text-white/75 transition hover:bg-white/5"
                                >
                                    Todas
                                </a>
                            @endif

                            @foreach ($subcategoriasVisibles as $subcategoria)
                                <a
                                    href="{{ route('catalogo', array_merge(request()->except('page'), ['subcategoria' => $subcategoria->slug, 'categoria' => request('categoria')])) }}"
                                    class="block rounded-xl px-3 py-2 text-sm transition {{ $subcategoriaSeleccionada?->id === $subcategoria->id ? 'bg-[#c9a86a] text-black font-semibold' : 'text-white/75 hover:bg-white/5' }}"
                                >
                                    {{ $subcategoria->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="border-t border-white/10 pt-6">
                    <h3 class="text-sm font-semibold uppercase tracking-[0.2em] text-[#c9a86a]">
                        Estado
                    </h3>

                    <div class="mt-4 space-y-3">
                        <label class="flex items-center gap-3 text-sm text-white/75">
                            <input type="radio" name="estado" value="" onchange="this.form.submit()" {{ empty($estado) ? 'checked' : '' }}>
                            <span>Todos</span>
                        </label>

                        <label class="flex items-center gap-3 text-sm text-white/75">
                            <input type="radio" name="estado" value="disponibles" onchange="this.form.submit()" {{ $estado === 'disponibles' ? 'checked' : '' }}>
                            <span>Disponibles</span>
                        </label>

                        <label class="flex items-center gap-3 text-sm text-white/75">
                            <input type="radio" name="estado" value="agotados" onchange="this.form.submit()" {{ $estado === 'agotados' ? 'checked' : '' }}>
                            <span>Agotados</span>
                        </label>
                    </div>
                </div>

                <div class="border-t border-white/10 pt-6">
                    <h3 class="text-sm font-semibold uppercase tracking-[0.2em] text-[#c9a86a]">
                        Precio
                    </h3>

                    <div class="mt-4 grid grid-cols-2 gap-3">
                        <input
                            type="number"
                            name="min"
                            value="{{ $min }}"
                            placeholder="Min"
                            onchange="this.form.submit()"
                            class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white placeholder:text-white/40 focus:border-[#c9a86a] focus:outline-none"
                        >
                        <input
                            type="number"
                            name="max"
                            value="{{ $max }}"
                            placeholder="Max"
                            onchange="this.form.submit()"
                            class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white placeholder:text-white/40 focus:border-[#c9a86a] focus:outline-none"
                        >
                    </div>
                </div>

                <div class="pt-2">
                    <a
                        href="{{ route('catalogo') }}"
                        class="block w-full rounded-2xl border border-white/10 px-4 py-3 text-center text-sm font-semibold text-white transition hover:border-red-400 hover:text-red-400"
                    >
                        Limpiar filtros
                    </a>
                </div>
            </aside>

            <div>
                <div class="mb-6 flex items-center justify-between">
                    <p class="text-sm text-white/60">
                        Mostrando <span class="font-semibold text-white">{{ $productos->count() }}</span> de <span class="font-semibold text-white">{{ $productos->total() }}</span> productos
                    </p>
                </div>

                @if ($productos->count() === 0)
                    <div class="rounded-3xl border border-dashed border-white/15 bg-[#151515] p-10 text-center">
                        <h3 class="text-xl font-semibold text-white">No encontramos productos</h3>
                        <p class="mt-3 text-white/60">
                            Intenta ajustar la búsqueda o los filtros del catálogo.
                        </p>
                        <a
                            href="{{ route('catalogo') }}"
                            class="mt-6 inline-block rounded-2xl bg-[#c9a86a] px-5 py-3 text-sm font-semibold text-black"
                        >
                            Ver todo el catálogo
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-2 gap-3 sm:gap-5 xl:grid-cols-3">
                        @foreach ($productos as $producto)
                            <article class="group overflow-hidden rounded-3xl border border-white/10 bg-[#151515] transition hover:-translate-y-1 hover:border-[#c9a86a]/50" x-data="{ agregado: false }">
                                <div class="relative">
                                    <a href="{{ route('producto.detalle', $producto->slug) }}" class="block">
                                        <div class="relative aspect-[4/5] sm:aspect-[3/4] overflow-hidden bg-[#111111]">
                                            @if($producto->main_image)
                                                <img src="{{ asset('storage/' . $producto->main_image) }}"
                                                     alt="{{ $producto->name }}"
                                                     class="absolute inset-0 h-full w-full object-cover transition duration-300 group-hover:scale-105">
                                            @else
                                                <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-[#c9a86a]/30 via-[#202020] to-[#111111] text-sm text-white/40">
                                                    Sin imagen
                                                </div>
                                            @endif
                                        </div>
                                    </a>

                                    <div class="absolute left-4 top-4 flex flex-wrap gap-2">
                                        @if ($producto->is_new)
                                            <span class="rounded-full bg-[#c9a86a] px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide text-black sm:px-3 sm:text-[11px]">
                                                Nuevo
                                            </span>
                                        @endif

                                        @if ($producto->sale_price)
                                            <span class="rounded-full bg-red-500/90 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide text-white sm:px-3 sm:text-[11px]">
                                                Oferta
                                            </span>
                                        @endif

                                        @if ($producto->is_sold_out)
                                            <span class="rounded-full bg-white/90 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide text-black sm:px-3 sm:text-[11px]">
                                                Agotado
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="p-4 sm:p-5">
                                    <p class="text-xs uppercase tracking-[0.2em] text-[#c9a86a]">
                                        <a
                                            href="{{ route('catalogo', array_merge(request()->except('page'), ['categoria' => $producto->category?->slug])) }}"
                                            class="hover:text-white"
                                        >
                                            {{ $producto->category?->name }}
                                        </a>
                                    </p>

                                    <p class="mt-1 text-xs text-white/45">
                                        <a
                                            href="{{ route('catalogo', array_merge(request()->except('page'), [
                                                'categoria' => $producto->category?->slug,
                                                'subcategoria' => $producto->subcategory?->slug,
                                            ])) }}"
                                            class="hover:text-[#c9a86a]"
                                        >
                                            {{ $producto->subcategory?->name }}
                                        </a>
                                    </p>

                                    <h3 class="mt-2 min-h-[48px] text-base font-semibold text-white sm:min-h-[56px] sm:text-lg">
                                        <a href="{{ route('producto.detalle', $producto->slug) }}" class="transition hover:text-[#c9a86a]">
                                            {{ $producto->name }}
                                        </a>
                                    </h3>

                                    <div class="mt-4 flex items-end gap-3">
                                        @if ($producto->sale_price)
                                            <span class="text-xl font-bold text-white sm:text-2xl">
                                                ${{ number_format($producto->sale_price, 2) }}
                                            </span>
                                            <span class="text-xs text-white/40 line-through sm:text-sm">
                                                ${{ number_format($producto->price, 2) }}
                                            </span>
                                        @else
                                            <span class="text-xl font-bold text-white sm:text-2xl">
                                                ${{ number_format($producto->price, 2) }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="mt-5 flex flex-col gap-2.5 sm:flex-row sm:gap-3">
                                        @if ($producto->is_sold_out)
                                            <a
                                                href="#"
                                                class="flex h-11 w-full items-center justify-center rounded-lg border border-white/15 px-3 text-sm font-semibold text-white transition hover:border-[#c9a86a] hover:text-[#c9a86a] sm:h-12 sm:flex-1 sm:px-4"
                                            >
                                                Consultar
                                            </a>
                                        @else
                                            <button
                                                type="button"
                                                :disabled="agregado"
                                                @click="
                                                    if (agregado) return;
                                                    $dispatch('agregar-al-carrito', {
                                                        id: '{{ $producto->id }}',
                                                        nombre: '{{ $producto->name }}',
                                                        categoria: '{{ $producto->category?->name }}',
                                                        precio: {{ (float) ($producto->sale_price ?? $producto->price) }}
                                                    });
                                                    agregado = true;
                                                    setTimeout(() => agregado = false, 1600);
                                                "
                                                class="flex h-11 w-full items-center justify-center rounded-lg bg-[#c9a86a] px-3 text-sm font-semibold text-black transition hover:opacity-90 sm:h-12 sm:flex-1 sm:px-4"
                                                :class="{ 'opacity-60 cursor-not-allowed': agregado }"
                                            >
                                                <span x-show="!agregado">Agregar</span>
                                                <span x-show="agregado" x-cloak>Agregado</span>
                                            </button>
                                        @endif

                                        <a
                                            href="https://wa.me/523120000000?text=Hola,%20me%20interesa%20el%20producto%20{{ urlencode($producto->name) }}"
                                            class="flex h-11 w-full items-center justify-center rounded-lg border border-white/15 px-3 text-sm font-semibold text-white transition hover:border-[#c9a86a] hover:text-[#c9a86a] sm:h-12 sm:flex-1 sm:px-4"
                                        >
                                            WhatsApp
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    @if ($productos->hasPages())
                        <div class="mt-10 flex flex-wrap items-center justify-center gap-3">
                            <div class="mt-10">
                                {{ $productos->links() }}
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </form>
</section>
@endsection