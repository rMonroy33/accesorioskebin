<x-guest-layout>
    <div class="min-h-screen bg-[#0f0f0f] text-white">
        <div class="mx-auto flex min-h-screen max-w-5xl items-center justify-center px-4 py-10">
            <div class="w-full max-w-md rounded-3xl border border-white/10 bg-[#151515] p-8 shadow-2xl">
                <div class="mb-6 text-center">
                    <p class="text-xs uppercase tracking-[0.35em] text-[#c9a86a]">Panel</p>
                    <h1 class="mt-2 text-2xl font-bold text-white">ACCESORIOS KEBIN</h1>
                    <p class="mt-2 text-sm text-white/60">Inicia sesión para administrar el catálogo.</p>
                </div>

                @if(session('status'))
                    <div class="mb-4 rounded-2xl border border-green-500/20 bg-green-500/10 px-4 py-3 text-sm text-green-300">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 rounded-2xl border border-red-500/20 bg-red-500/10 px-4 py-3 text-sm text-red-300">
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-white/80">Correo electrónico</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            class="w-full rounded-2xl border border-white/10 bg-[#111111] px-4 py-3 text-white focus:border-[#c9a86a] focus:outline-none"
                            placeholder="admin@kebin.com"
                        >
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-medium text-white/80">Contraseña</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            class="w-full rounded-2xl border border-white/10 bg-[#111111] px-4 py-3 text-white focus:border-[#c9a86a] focus:outline-none"
                            placeholder="••••••••"
                        >
                    </div>

                    <div class="flex items-center justify-between text-sm text-white/70">
                        <label class="inline-flex items-center gap-2">
                            <input id="remember_me" type="checkbox" name="remember" class="h-4 w-4 rounded border-white/20 bg-[#111111] text-[#c9a86a] focus:ring-[#c9a86a]">
                            <span>Recuérdame</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-[#c9a86a] transition hover:text-white" href="{{ route('password.request') }}">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>

                    <div class="pt-2">
                        <button
                            type="submit"
                            class="w-full rounded-2xl bg-[#c9a86a] px-5 py-3 text-sm font-semibold text-black transition hover:opacity-90"
                        >
                            Iniciar sesión
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
