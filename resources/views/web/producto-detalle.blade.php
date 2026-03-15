@extends('layouts.web')

@section('content')
<section class="border-b border-white/10 bg-[#121212]">
    <div class="mx-auto max-w-7xl px-4 py-8 lg:px-8">
        <p class="text-sm text-white/50">
            <a href="{{ route('home') }}" class="hover:text-[#c9a86a]">Inicio</a>
            <span class="mx-2">/</span>
            <a href="{{ route('catalogo') }}" class="hover:text-[#c9a86a]">Catálogo</a>
            <span class="mx-2">/</span>
            <span>{{ $producto->name }}</span>
        </p>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-10 lg:px-8" x-data="{ cantidad: 1, imagenActiva: 0 }">
    <div class="grid gap-10 lg:grid-cols-2">
        @php
            $galeria = collect([]);

            if ($producto->main_image) {
                $galeria->push(asset('storage/' . $producto->main_image));
            }

            foreach ($producto->images as $image) {
                $galeria->push(asset('storage/' . $image->image_path));
            }
        @endphp

        <div
            x-data='{
                imagenes: @json($galeria->values()),
                activa: 0
            }'
        >
            <div class="overflow-hidden rounded-3xl border border-white/10 bg-[#151515]">
                <div class="h-[420px] bg-[#111111]">
                    <template x-if="imagenes.length > 0">
                        <img
                            :src="imagenes[activa]"
                            alt="{{ $producto->name }}"
                            class="h-full w-full object-cover"
                        >
                    </template>

                    <template x-if="imagenes.length === 0">
                        <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-[#c9a86a]/35 via-[#1c1c1c] to-[#101010] text-white/40">
                            Sin imagen
                        </div>
                    </template>
                </div>
            </div>

            <div class="mt-4 grid grid-cols-4 gap-3" x-show="imagenes.length > 0">
                <template x-for="(imagen, index) in imagenes" :key="index">
                    <button
                        type="button"
                        @click="activa = index"
                        class="overflow-hidden rounded-2xl border bg-[#151515] transition"
                        :class="activa === index ? 'border-[#c9a86a]' : 'border-white/10 hover:border-[#c9a86a]'"
                    >
                        <img
                            :src="imagen"
                            alt="Miniatura"
                            class="block h-24 w-full object-cover"
                        >
                    </button>
                </template>
            </div>
        </div>

        <div class="flex flex-col justify-center">
            <div class="mb-4 flex flex-wrap gap-2">
                @if ($producto->is_new)
                    <span class="rounded-full bg-[#c9a86a] px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-black">
                        Nuevo
                    </span>
                @endif

                @if ($producto->sale_price)
                    <span class="rounded-full bg-red-500/90 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-white">
                        Oferta
                    </span>
                @endif

                @if ($producto->is_sold_out)
                    <span class="rounded-full bg-white/90 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-black">
                        Agotado
                    </span>
                @endif
            </div>

            <p class="text-sm uppercase tracking-[0.25em] text-[#c9a86a]">
                {{ $producto->category?->name }}
            </p>

            <h1 class="mt-3 text-3xl font-bold text-white md:text-4xl">
                {{ $producto->name }}
            </h1>

            <p class="mt-5 text-base leading-7 text-white/70">
                {{ $producto->description }}
            </p>

            <div class="mt-6 flex items-end gap-3">
                @if ($producto->sale_price)
                    <span class="text-3xl font-bold text-white">
                        ${{ number_format($producto->sale_price, 2) }}
                    </span>
                    <span class="text-lg text-white/40 line-through">
                        ${{ number_format($producto->price, 2) }}
                    </span>
                @else
                    <span class="text-3xl font-bold text-white">
                        ${{ number_format($producto->price, 2) }}
                    </span>
                @endif
            </div>

            <div class="mt-8 flex flex-wrap items-center gap-4">
                <div class="flex items-center rounded-2xl border border-white/10 bg-white/5">
                    <button
                        type="button"
                        @click="if (cantidad > 1) cantidad--"
                        class="px-4 py-3 text-white/80"
                    >
                        -
                    </button>
                    <span class="min-w-12 text-center text-sm font-semibold text-white" x-text="cantidad"></span>
                    <button
                        type="button"
                        @click="cantidad++"
                        class="px-4 py-3 text-white/80"
                    >
                        +
                    </button>
                </div>

                @if ($producto->is_sold_out)
                    <a
                        href="https://wa.me/523120000000?text=Hola,%20me%20interesa%20consultar%20disponibilidad%20del%20producto%20{{ urlencode($producto->name) }}"
                        target="_blank"
                        class="rounded-2xl border border-white/15 px-6 py-3 text-sm font-semibold text-white transition hover:border-[#c9a86a] hover:text-[#c9a86a]"
                    >
                        Consultar disponibilidad
                    </a>
                @else
                    <button
                        type="button"
                        @click="$dispatch('agregar-al-carrito', {
                            id: '{{ $producto->id }}',
                            nombre: '{{ $producto->name }}',
                            categoria: '{{ $producto->category?->name }}',
                            precio: {{ (float) ($producto->sale_price ?? $producto->price) }},
                            cantidad: cantidad
                        })"
                        class="rounded-2xl bg-[#c9a86a] px-6 py-3 text-sm font-semibold text-black transition hover:opacity-90"
                    >
                        Agregar al carrito
                    </button>
                @endif

                <a
                    href="https://wa.me/523120000000?text=Hola,%20me%20interesa%20el%20producto%20{{ urlencode($producto->name) }}"
                    target="_blank"
                    class="rounded-2xl border border-white/15 px-6 py-3 text-sm font-semibold text-white transition hover:border-[#c9a86a] hover:text-[#c9a86a]"
                >
                    Pedir por WhatsApp
                </a>
            </div>

            <div class="mt-8 rounded-3xl border border-white/10 bg-[#151515] p-5">
                <h3 class="text-sm font-semibold uppercase tracking-[0.2em] text-[#c9a86a]">
                    Información rápida
                </h3>

                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-white/45">Categoría</p>
                        <p class="mt-1 text-sm text-white">{{ $producto->category?->name }}</p>
                    </div>

                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-white/45">Disponibilidad</p>
                        <p class="mt-1 text-sm text-white">
                            {{ $producto->is_sold_out ? 'Agotado' : 'Disponible' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-white/45">Pedido</p>
                        <p class="mt-1 text-sm text-white">Por WhatsApp</p>
                    </div>

                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-white/45">Pago</p>
                        <p class="mt-1 text-sm text-white">Transferencia bancaria</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if ($relacionados->count())
<section class="mx-auto max-w-7xl px-4 pb-16 lg:px-8">
    <div class="mb-8">
        <p class="text-sm uppercase tracking-[0.25em] text-[#c9a86a]">Sugerencias</p>
        <h2 class="mt-2 text-2xl font-bold text-white">Productos relacionados</h2>
    </div>

    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
        @foreach ($relacionados as $relacionado)
            <article class="group overflow-hidden rounded-3xl border border-white/10 bg-[#151515] transition hover:-translate-y-1 hover:border-[#c9a86a]/50">
                <a href="{{ route('producto.detalle', $relacionado->slug) }}" class="block">
                    <div class="h-60 overflow-hidden bg-[#111111]">
                        @if($relacionado->main_image)
                            <img src="{{ asset('storage/' . $relacionado->main_image) }}"
                                 alt="{{ $relacionado->name }}"
                                 class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                        @else
                            <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-[#c9a86a]/30 via-[#202020] to-[#111111] text-sm text-white/40">
                                Sin imagen
                            </div>
                        @endif
                    </div>
                </a>

                <div class="p-5">
                    <p class="text-xs uppercase tracking-[0.2em] text-[#c9a86a]">
                        {{ $relacionado->category?->name }}
                    </p>

                    <h3 class="mt-2 text-lg font-semibold text-white">
                        <a href="{{ route('producto.detalle', $relacionado->slug) }}" class="transition hover:text-[#c9a86a]">
                            {{ $relacionado->name }}
                        </a>
                    </h3>

                    <div class="mt-4 flex items-end gap-3">
                        @if ($relacionado->sale_price)
                            <span class="text-2xl font-bold text-white">
                                ${{ number_format($relacionado->sale_price, 2) }}
                            </span>
                            <span class="text-sm text-white/40 line-through">
                                ${{ number_format($relacionado->price, 2) }}
                            </span>
                        @else
                            <span class="text-2xl font-bold text-white">
                                ${{ number_format($relacionado->price, 2) }}
                            </span>
                        @endif
                    </div>
                </div>
            </article>
        @endforeach
    </div>
</section>
@endif
@endsection