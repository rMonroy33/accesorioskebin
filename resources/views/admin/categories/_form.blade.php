<div class="grid gap-6">
    <div>
        <label class="mb-2 block text-sm font-medium text-white/80">Nombre</label>
        <input type="text"
               name="name"
               value="{{ old('name', $category->name ?? '') }}"
               class="w-full rounded-2xl border border-white/10 bg-[#111111] px-4 py-3 text-white focus:border-[#c9a86a] focus:outline-none">
    </div>

    <div>
        <label class="mb-2 block text-sm font-medium text-white/80">Descripción</label>
        <textarea name="description"
                  rows="4"
                  class="w-full rounded-2xl border border-white/10 bg-[#111111] px-4 py-3 text-white focus:border-[#c9a86a] focus:outline-none">{{ old('description', $category->description ?? '') }}</textarea>
    </div>

    <div>
        <label class="mb-2 block text-sm font-medium text-white/80">Orden</label>
        <input type="number"
               name="sort_order"
               value="{{ old('sort_order', $category->sort_order ?? 0) }}"
               class="w-full rounded-2xl border border-white/10 bg-[#111111] px-4 py-3 text-white focus:border-[#c9a86a] focus:outline-none">
    </div>

    <div class="flex items-center gap-3">
        <input type="checkbox"
               name="status"
               value="1"
               {{ old('status', $category->status ?? true) ? 'checked' : '' }}
               class="h-4 w-4 rounded border-white/20 bg-[#111111] text-[#c9a86a] focus:ring-[#c9a86a]">
        <label class="text-sm text-white/80">Activa</label>
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button type="submit"
            class="rounded-2xl bg-[#c9a86a] px-5 py-3 text-sm font-semibold text-black transition hover:opacity-90">
        Guardar
    </button>

    <a href="{{ route('admin.categories.index') }}"
       class="rounded-2xl border border-white/10 px-5 py-3 text-sm font-semibold text-white transition hover:border-white/30">
        Cancelar
    </a>
</div>