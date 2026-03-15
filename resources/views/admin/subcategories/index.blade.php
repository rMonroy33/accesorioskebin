@extends('layouts.admin')

@section('title', 'Subcategorías')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h3 class="text-2xl font-bold text-white">Subcategorías</h3>
        <p class="mt-1 text-sm text-white/60">Administra las subcategorías del catálogo.</p>
    </div>

    <a href="{{ route('admin.subcategories.create') }}"
       class="rounded-2xl bg-[#c9a86a] px-5 py-3 text-sm font-semibold text-black transition hover:opacity-90">
        Nueva subcategoría
    </a>
</div>

<form method="GET" action="{{ route('admin.subcategories.index') }}"
      class="mb-6 rounded-3xl border border-white/10 bg-[#151515] p-5">
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="xl:col-span-2">
            <label class="mb-2 block text-sm font-medium text-white/80">Buscar</label>
            <input
                type="text"
                name="q"
                value="{{ $busqueda ?? '' }}"
                placeholder="Nombre o slug..."
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
                @foreach($categories ?? [] as $cat)
                    <option value="{{ $cat->id }}" {{ (string)($categoria ?? '') === (string) $cat->id ? 'selected' : '' }}>
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
                <option value="">Todas</option>
                <option value="1" {{ (string)($estado ?? '') === '1' ? 'selected' : '' }}>Activas</option>
                <option value="0" {{ (string)($estado ?? '') === '0' ? 'selected' : '' }}>Inactivas</option>
            </select>
        </div>
    </div>

    <div class="mt-4 flex flex-wrap gap-3">
        <button type="submit"
                class="rounded-2xl bg-[#c9a86a] px-5 py-3 text-sm font-semibold text-black transition hover:opacity-90">
            Aplicar filtros
        </button>

        <a href="{{ route('admin.subcategories.index') }}"
           class="rounded-2xl border border-white/10 px-5 py-3 text-sm font-semibold text-white transition hover:border-red-400 hover:text-red-400">
            Limpiar
        </a>
    </div>
</form>

<div class="mb-4 flex flex-wrap gap-3">
    @if(!empty($busqueda))
        <span class="rounded-full border border-[#c9a86a]/40 bg-[#c9a86a]/10 px-4 py-2 text-sm text-[#e6c78f]">
            Búsqueda: {{ $busqueda }}
        </span>
    @endif

    @if(!empty($categoria))
        @php($categoriaNombre = ($categories ?? collect())->firstWhere('id', (int) $categoria)?->name)
        @if($categoriaNombre)
            <span class="rounded-full border border-[#c9a86a]/40 bg-[#c9a86a]/10 px-4 py-2 text-sm text-[#e6c78f]">
                Categoría: {{ $categoriaNombre }}
            </span>
        @endif
    @endif

    @if(($estado ?? '') !== '')
        <span class="rounded-full border border-[#c9a86a]/40 bg-[#c9a86a]/10 px-4 py-2 text-sm text-[#e6c78f]">
            Estado: {{ ($estado ?? '') === '1' ? 'Activas' : 'Inactivas' }}
        </span>
    @endif
</div>

<div class="overflow-hidden rounded-3xl border border-white/10 bg-[#151515]">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="border-b border-white/10 bg-white/5 text-left text-white/60">
                <tr>
                    <th class="px-5 py-4">Nombre</th>
                    <th class="px-5 py-4">Categoría</th>
                    <th class="px-5 py-4">Slug</th>
                    <th class="px-5 py-4">Orden</th>
                    <th class="px-5 py-4">Estado</th>
                    <th class="px-5 py-4 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subcategories as $subcategory)
                    <tr class="border-b border-white/5">
                        <td class="px-5 py-4 font-medium text-white">{{ $subcategory->name }}</td>
                        <td class="px-5 py-4 text-white/60">{{ $subcategory->category?->name }}</td>
                        <td class="px-5 py-4 text-white/60">{{ $subcategory->slug }}</td>
                        <td class="px-5 py-4 text-white/60">{{ $subcategory->sort_order }}</td>
                        <td class="px-5 py-4">
                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $subcategory->status ? 'bg-green-500/15 text-green-300' : 'bg-red-500/15 text-red-300' }}">
                                {{ $subcategory->status ? 'Activa' : 'Inactiva' }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.subcategories.edit', $subcategory) }}"
                                   class="rounded-xl border border-white/10 px-3 py-2 text-xs text-white hover:border-[#c9a86a] hover:text-[#c9a86a]">
                                    Editar
                                </a>

                                <form action="{{ route('admin.subcategories.destroy', $subcategory) }}" method="POST" onsubmit="return confirm('¿Eliminar esta subcategoría?')">
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
                        <td colspan="6" class="px-5 py-8 text-center text-white/50">
                            No hay subcategorías registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="border-t border-white/10 px-5 py-4">
        {{ $subcategories->links() }}
    </div>
</div>
@endsection