<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#0f0f0f] text-white">
    <div class="grid min-h-screen lg:grid-cols-[260px_1fr]">
        <aside class="border-r border-white/10 bg-[#121212] p-6">
            <a href="{{ route('admin.dashboard') }}" class="block">
                <p class="text-xs uppercase tracking-[0.35em] text-[#c9a86a]">Panel</p>
                <h1 class="mt-2 text-lg font-bold text-white">ACCESORIOS KEBIN</h1>
            </a>

            <nav class="mt-8 space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                   class="block rounded-xl px-4 py-3 text-sm transition hover:bg-white/5 {{ request()->routeIs('admin.dashboard') ? 'bg-white/5 text-[#c9a86a]' : 'text-white' }}">
                    Dashboard
                </a>

                <a href="{{ route('admin.categories.index') }}"
                   class="block rounded-xl px-4 py-3 text-sm transition hover:bg-white/5 {{ request()->routeIs('admin.categories.*') ? 'bg-white/5 text-[#c9a86a]' : 'text-white' }}">
                    Categorías
                </a>

                <a href="{{ route('admin.subcategories.index') }}"
                    class="block rounded-xl px-4 py-3 text-sm transition hover:bg-white/5 {{ request()->routeIs('admin.subcategories.*') ? 'bg-white/5 text-[#c9a86a]' : 'text-white' }}">
                    Subcategorías
                </a>

                <a href="{{ route('admin.products.index') }}"
                class="block rounded-xl px-4 py-3 text-sm transition hover:bg-white/5 {{ request()->routeIs('admin.products.*') ? 'bg-white/5 text-[#c9a86a]' : 'text-white' }}">
                    Productos
                </a>
            </nav>
        </aside>

        <div class="flex min-h-screen flex-col">
            <header class="border-b border-white/10 bg-[#111111] px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-white">@yield('title', 'Panel')</h2>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="text-sm text-white/60">{{ auth()->user()->name ?? 'Administrador' }}</span>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button
                                type="submit"
                                class="rounded-xl border border-white/10 px-4 py-2 text-sm font-medium text-white transition hover:border-red-400 hover:text-red-400"
                            >
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="flex-1 px-6 py-6">
                @if(session('success'))
                    <div class="mb-6 rounded-2xl border border-green-500/20 bg-green-500/10 px-4 py-3 text-sm text-green-300">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 rounded-2xl border border-red-500/20 bg-red-500/10 px-4 py-3 text-sm text-red-300">
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>