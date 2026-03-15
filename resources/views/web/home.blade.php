@extends('layouts.web')

@section('content')
<section class="relative overflow-hidden">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-16 lg:grid-cols-2 lg:px-8 lg:py-24">
        <div class="flex flex-col justify-center">
            <span class="mb-4 inline-block w-fit rounded-full border border-[#c9a86a]/40 bg-[#c9a86a]/10 px-4 py-1 text-xs font-medium uppercase tracking-[0.25em] text-[#e6c78f]">
                Catálogo digital
            </span>

            <h2 class="max-w-xl text-4xl font-bold leading-tight text-white md:text-5xl">
                Accesorios, tecnología y novedades con estilo.
            </h2>

            <p class="mt-6 max-w-xl text-base leading-7 text-white/70">
                Descubre productos para hogar, auto, moto, dama, caballero y tecnología.
                Agrega tus artículos favoritos y realiza tu pedido por WhatsApp.
            </p>

            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ route('catalogo') }}"
                   class="rounded-full bg-[#c9a86a] px-6 py-3 text-sm font-semibold text-black transition hover:opacity-90">
                    Ver catálogo
                </a>

                <a href="{{ route('como-comprar') }}"
                   class="rounded-full border border-white/15 px-6 py-3 text-sm font-semibold text-white transition hover:border-[#c9a86a] hover:text-[#c9a86a]">
                    Cómo comprar
                </a>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            @php
                $heroCards = [
                    ['title' => 'Tecnología', 'desc' => 'Cables, audífonos, power banks y más.', 'bg' => 'from-[#c9a86a]/40 to-[#1a1a1a]', 'image' => 'images/home/categoria-tecnologia.png', 'position' => 'center 0%'],
                    ['title' => 'Hogar', 'desc' => 'Humidificadores, esencias y lámparas.', 'bg' => 'from-[#c9a86a]/20 to-[#2a2a2a]', 'image' => 'images/home/categoria-hogar.png', 'position' => null],
                    ['title' => 'Auto y moto', 'desc' => 'Soportes, aromatizantes y accesorios.', 'bg' => 'from-[#c9a86a]/30 to-[#202020]', 'image' => 'images/home/categoria-autoymoto.png', 'position' => 'center 15%'],
                    ['title' => 'Dama y caballero', 'desc' => 'Regalos, cuidado personal y más.', 'bg' => 'from-[#c9a86a]/25 to-[#1c1c1c]', 'image' => 'images/home/categoria-damaycaballero.png', 'position' => '75% center'],
                ];
            @endphp

            @foreach($heroCards as $card)
                <a href="{{ route('catalogo', ['categoria' => \Illuminate\Support\Str::slug($card['title'])]) }}"
                   class="group rounded-3xl border border-white/10 bg-white/5 p-6 shadow-xl transition hover:-translate-y-1 hover:border-[#c9a86a]/50">
                    <div class="relative overflow-hidden rounded-2xl transition group-hover:scale-[1.01]">
                        @if(!empty($card['image']))
                            <div class="aspect-[4/3] bg-[#111]">
                                <img src="{{ asset($card['image']) }}" alt="{{ $card['title'] }}" class="h-full w-full object-cover object-center" style="{{ $card['position'] ? 'object-position: '.$card['position'].';' : '' }}">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/55 via-black/25 to-transparent"></div>
                            </div>
                        @else
                            <div class="h-36 bg-gradient-to-br {{ $card['bg'] }}"></div>
                        @endif
                    </div>
                    <h3 class="mt-4 text-lg font-semibold text-white">{{ $card['title'] }}</h3>
                    <p class="mt-2 text-sm text-white/65">{{ $card['desc'] }}</p>
                    <span class="mt-3 inline-flex items-center gap-2 text-sm font-medium text-[#c9a86a]">
                        Ver categoría →
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 pb-16 lg:px-8">
    <div class="mb-8 flex items-end justify-between">
        <div>
            <p class="text-sm uppercase tracking-[0.25em] text-[#c9a86a]">Destacados</p>
            <h3 class="mt-2 text-2xl font-bold text-white">Categorías principales</h3>
        </div>
    </div>

    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
        @forelse ($categoriasDestacadas as $categoria)
            <a href="{{ route('catalogo', ['categoria' => $categoria->slug]) }}"
               class="rounded-3xl border border-white/10 bg-[#151515] p-6 transition hover:-translate-y-1 hover:border-[#c9a86a]/50">
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-[#c9a86a]/12 text-[#c9a86a]">
                    @switch($categoria->slug)
                        @case('tecnologia-y-accesorios')
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8">
                                <rect x="3" y="6" width="18" height="12" rx="2.5"/>
                                <path d="M9 18v2h6v-2"/>
                                <circle cx="12" cy="12" r="1.6"/>
                            </svg>
                            @break
                        @case('auto-y-moto')
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M4 14h16l-2-5.5A2 2 0 0 0 16.14 7H7.86A2 2 0 0 0 6 8.5Z"/>
                                <circle cx="7" cy="16.5" r="1.6"/>
                                <circle cx="17" cy="16.5" r="1.6"/>
                                <path d="M4 14v2.5M20 14v2.5"/>
                            </svg>
                            @break
                        @case('hogar')
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M4 11.5 12 5l8 6.5"/>
                                <path d="M6.5 11.5V19h11V11.5"/>
                                <path d="M10 19v-4h4v4"/>
                            </svg>
                            @break
                        @case('caballero')
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8">
                                <circle cx="12" cy="7" r="3"/>
                                <path d="M7 19c.5-3 2.5-5 5-5s4.5 2 5 5"/>
                                <path d="M9.5 11.5h5"/>
                            </svg>
                            @break
                        @case('dama')
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8">
                                <circle cx="12" cy="7" r="3"/>
                                <path d="M12 10v4"/>
                                <path d="M9 18h6"/>
                                <path d="M9.5 14.5h5"/>
                            </svg>
                            @break
                        @default
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M5 12h14"/>
                                <path d="M5 8h14"/>
                                <path d="M5 16h14"/>
                            </svg>
                    @endswitch
                </div>
                <h4 class="text-lg font-semibold text-white">{{ $categoria->name }}</h4>
                <p class="mt-2 text-sm text-white/65">
                    {{ $categoria->description ?? 'Explora productos seleccionados de esta categoría.' }}
                </p>
                <span class="mt-4 inline-flex items-center gap-2 text-sm font-medium text-[#c9a86a]">
                    Explorar →
                </span>
            </a>
        @empty
            <p class="text-white/70">No hay categorías destacadas disponibles.</p>
        @endforelse
    </div>
</section>
@endsection