<!DOCTYPE html>
<html lang="es" x-data="carritoApp()" x-init="init()">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accesorios Kebin</title>
    <link rel="icon" type="image/webp" sizes="64x64" href="{{ asset('images/home/logo2.webp') }}">
    <link rel="shortcut icon" type="image/webp" sizes="64x64" href="{{ asset('images/home/logo2.webp') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0f0f0f] text-white min-h-screen">

    <header class="sticky top-0 z-50 border-b border-white/10 bg-[#111111]/95 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/home/logo2.webp') }}" alt="Accesorios Kebin" class="h-16 w-auto">
                <div>
                    <p class="text-xs uppercase tracking-[0.35em] text-[#c9a86a]">Accesorios</p>
                    <h1 class="text-sm font-semibold tracking-[0.25em] text-white">KEBIN</h1>
                </div>
            </a>

            <nav class="hidden items-center gap-6 md:flex">
                <a href="{{ route('home') }}" class="text-sm text-white/80 transition hover:text-[#c9a86a]">Inicio</a>
                <a href="{{ route('catalogo') }}" class="text-sm text-white/80 transition hover:text-[#c9a86a]">Catálogo</a>
            </nav>

            <div class="hidden items-center gap-3 md:flex">
                <a href="https://wa.me/527531160065?text=Hola,%20me%20interesa%20hacer%20un%20pedido%20en%20ACCESORIOS%20KEBIN"
                   target="_blank"
                   class="rounded-full bg-[#c9a86a] px-5 py-2 text-sm font-semibold text-black transition hover:opacity-90">
                    Pedir por WhatsApp
                </a>

                <button
                    type="button"
                    @click="abrirCarrito = true"
                    class="relative rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm font-semibold text-white transition hover:border-[#c9a86a]"
                >
                    Carrito
                    <span
                        x-show="cantidadTotal() > 0"
                        x-text="cantidadTotal()"
                        class="absolute -right-2 -top-2 flex h-6 w-6 items-center justify-center rounded-full bg-[#c9a86a] text-xs font-bold text-black"
                    ></span>
                </button>
            </div>

            <div class="flex items-center gap-2 md:hidden">
                <button
                    type="button"
                    @click="abrirCarrito = true"
                    class="relative rounded-lg border border-white/10 p-2 text-white"
                >
                    🛒
                    <span
                        x-show="cantidadTotal() > 0"
                        x-text="cantidadTotal()"
                        class="absolute -right-2 -top-2 flex h-5 w-5 items-center justify-center rounded-full bg-[#c9a86a] text-[10px] font-bold text-black"
                    ></span>
                </button>

                <button
                    type="button"
                    x-data
                    @click.stop="$dispatch('toggle-menu')"
                    class="rounded-lg border border-white/10 p-2 text-white"
                >
                    ☰
                </button>
            </div>
        </div>

        <div
            x-data="{ open: false }"
            x-on:toggle-menu.window="open = !open"
            x-show="open"
            x-transition
            class="border-t border-white/10 bg-[#111111] md:hidden"
        >
            <div class="space-y-3 px-4 py-4">
                <a href="{{ route('home') }}" class="block text-sm text-white/80">Inicio</a>
                <a href="{{ route('catalogo') }}" class="block text-sm text-white/80">Catálogo</a>
                <a href="https://wa.me/527531160065?text=Hola,%20me%20interesa%20hacer%20un%20pedido%20en%20ACCESORIOS%20KEBIN"
                   target="_blank"
                   class="mt-2 block rounded-full bg-[#c9a86a] px-4 py-2 text-center text-sm font-semibold text-black">
                    Pedir por WhatsApp
                </a>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="border-t border-white/10 bg-[#0b0b0b]">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 lg:grid-cols-3 lg:px-8">
            <div>
                <h3 class="text-sm font-semibold uppercase tracking-[0.3em] text-[#c9a86a]">ACCESORIOS KEBIN</h3>
                <p class="mt-3 text-sm text-white/65">
                    Catálogo digital de accesorios, tecnología, hogar y artículos de tendencia.
                </p>
            </div>

            <div>
                <h4 class="text-sm font-semibold text-white">Enlaces</h4>
                <ul class="mt-3 space-y-2 text-sm text-white/65">
                    <li><a href="{{ route('catalogo') }}" class="hover:text-[#c9a86a]">Catálogo</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-semibold text-white">Atención</h4>
                <p class="mt-3 text-sm text-white/65">Pedidos y confirmación mediante WhatsApp.</p>
                <p class="mt-2 text-sm text-white/65">Pago por transferencia bancaria.</p>
            </div>
        </div>
    </footer>

    <div
        x-show="abrirCarrito"
        x-transition.opacity
        class="fixed inset-0 z-[60] bg-black/60"
        @click="abrirCarrito = false"
    ></div>

    <aside
        x-show="abrirCarrito"
        @click.stop
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed right-0 top-0 z-[70] flex h-full w-full max-w-md flex-col border-l border-white/10 bg-[#121212] shadow-2xl"
    >
        <div class="flex items-center justify-between border-b border-white/10 px-5 py-4">
            <div>
                <h3 class="text-lg font-semibold text-white">Tu pedido</h3>
                <p class="text-sm text-white/55">Productos seleccionados</p>
            </div>
            <button
                type="button"
                @click.stop="abrirCarrito = false"
                class="rounded-lg border border-white/10 p-2 text-white transition hover:border-[#c9a86a] hover:text-[#c9a86a]"
            >
                ✕
            </button>
        </div>

        <div class="flex-1 overflow-y-auto px-5 py-5">
            <template x-if="carrito.length === 0">
                <div class="rounded-3xl border border-dashed border-white/15 p-8 text-center">
                    <p class="text-lg font-semibold text-white">Tu carrito está vacío</p>
                    <p class="mt-2 text-sm text-white/60">Agrega productos desde el catálogo para armar tu pedido.</p>
                </div>
            </template>

            <div class="space-y-4" x-show="carrito.length > 0">
                <template x-for="(item, index) in carrito" :key="item.id">
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-xs uppercase tracking-[0.18em] text-[#c9a86a]" x-text="item.categoria"></p>
                                <h4 class="mt-1 text-sm font-semibold text-white" x-text="item.nombre"></h4>
                                <p class="mt-2 text-sm text-white/60">
                                    $<span x-text="Number(item.precio).toFixed(2)"></span>
                                </p>
                            </div>

                            <button type="button" @click="eliminarProducto(index)" class="text-sm text-white/50 transition hover:text-red-400">
                                Eliminar
                            </button>
                        </div>

                        <div class="mt-4 flex items-center justify-between">
                            <div class="flex items-center rounded-2xl border border-white/10">
                                <button type="button" @click="disminuirCantidad(index)" class="px-3 py-2 text-white/80">-</button>
                                <span class="min-w-10 text-center text-sm font-semibold text-white" x-text="item.cantidad"></span>
                                <button type="button" @click="aumentarCantidad(index)" class="px-3 py-2 text-white/80">+</button>
                            </div>

                            <p class="text-sm font-semibold text-white">
                                $<span x-text="(item.precio * item.cantidad).toFixed(2)"></span>
                            </p>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <div class="border-t border-white/10 px-5 py-5">
            <div class="mb-4 flex items-center justify-between">
                <span class="text-sm text-white/60">Total estimado</span>
                <span class="text-xl font-bold text-white">
                    $<span x-text="totalCarrito().toFixed(2)"></span>
                </span>
            </div>

            <button
                type="button"
                @click="enviarWhatsApp()"
                :disabled="carrito.length === 0"
                class="w-full rounded-2xl bg-[#c9a86a] px-5 py-3 text-sm font-semibold text-black transition hover:opacity-90 disabled:cursor-not-allowed disabled:opacity-40"
            >
                Enviar pedido por WhatsApp
            </button>

            <button
                type="button"
                @click="vaciarCarrito()"
                x-show="carrito.length > 0"
                class="mt-3 w-full rounded-2xl border border-white/10 px-5 py-3 text-sm font-semibold text-white transition hover:border-red-400 hover:text-red-400"
            >
                Vaciar carrito
            </button>
        </div>
    </aside>

    <script>
        function carritoApp() {
            return {
                abrirCarrito: false,
                carrito: [],

                init() {
                    const guardado = localStorage.getItem('carrito_kebin');
                    this.carrito = guardado ? JSON.parse(guardado) : [];

                    if (!window.kebinCartListenerAdded) {
                        window.addEventListener('agregar-al-carrito', (event) => {
                            this.agregarProducto(event.detail);
                        });

                        window.kebinCartListenerAdded = true;
                    }
                },

                guardarCarrito() {
                    localStorage.setItem('carrito_kebin', JSON.stringify(this.carrito));
                },

                agregarProducto(producto) {
                    const cantidadNueva = producto.cantidad ? Number(producto.cantidad) : 1;
                    const idProducto = String(producto.id);

                    const existente = this.carrito.find(item => String(item.id) === idProducto);

                    if (existente) {
                        existente.cantidad += cantidadNueva;
                    } else {
                        this.carrito.push({
                            ...producto,
                            id: idProducto,
                            cantidad: cantidadNueva
                        });
                    }

                    this.guardarCarrito();
                    this.abrirCarrito = true;
                },

                eliminarProducto(index) {
                    this.carrito.splice(index, 1);
                    this.guardarCarrito();
                },

                aumentarCantidad(index) {
                    this.carrito[index].cantidad++;
                    this.guardarCarrito();
                },

                disminuirCantidad(index) {
                    if (this.carrito[index].cantidad > 1) {
                        this.carrito[index].cantidad--;
                    } else {
                        this.carrito.splice(index, 1);
                    }
                    this.guardarCarrito();
                },

                vaciarCarrito() {
                    this.carrito = [];
                    this.guardarCarrito();
                },

                cantidadTotal() {
                    return this.carrito.reduce((acc, item) => acc + item.cantidad, 0);
                },

                totalCarrito() {
                    return this.carrito.reduce((acc, item) => acc + (item.precio * item.cantidad), 0);
                },

                enviarWhatsApp() {
                    if (this.carrito.length === 0) return;

                    let mensaje = 'Hola, me interesan los siguientes productos de ACCESORIOS KEBIN:%0A%0A';

                    this.carrito.forEach(item => {
                        mensaje += `- ${item.nombre} | Cantidad: ${item.cantidad} | Precio: $${Number(item.precio).toFixed(2)}%0A`;
                    });

                    mensaje += `%0ATotal estimado: $${this.totalCarrito().toFixed(2)}%0A`;
                    mensaje += '%0AMe compartes disponibilidad y datos para transferencia, por favor.';

                    const telefono = '527531160065';
                    const url = `https://wa.me/${telefono}?text=${mensaje}`;

                    window.open(url, '_blank');
                }
            }
        }
    </script>

</body>
</html>