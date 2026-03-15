<div class="grid gap-6 md:grid-cols-2">
    <div class="md:col-span-2">
        <label class="mb-2 block text-sm font-medium text-white/80">Nombre</label>
        <input type="text"
               name="name"
               value="{{ old('name', $product->name ?? '') }}"
               class="w-full rounded-2xl border border-white/10 bg-[#111111] px-4 py-3 text-white focus:border-[#c9a86a] focus:outline-none">
    </div>

    @php
        $selectedCategory = (string) old('category_id', $product->category_id ?? '');
        $selectedSubcategory = (string) old('subcategory_id', $product->subcategory_id ?? '');
    @endphp

    <div
        x-data='{
            categoryId: @json($selectedCategory),
            subcategoryId: @json($selectedSubcategory),
            subcategories: @json($subcategories),
            get filteredSubcategories() {
                if (!this.categoryId) return [];
                return this.subcategories.filter(sub => String(sub.category_id) === String(this.categoryId));
            }
        }'
        class="contents"
    >
        <div>
            <label class="mb-2 block text-sm font-medium text-white/80">Categoría</label>
            <select
                name="category_id"
                x-model="categoryId"
                @change="subcategoryId = ''"
                class="w-full rounded-2xl border border-white/10 bg-[#111111] px-4 py-3 text-white focus:border-[#c9a86a] focus:outline-none"
            >
                <option value="">Selecciona una categoría</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-white/80">Subcategoría</label>
            <select
                name="subcategory_id"
                x-model="subcategoryId"
                :disabled="!categoryId"
                class="w-full rounded-2xl border border-white/10 bg-[#111111] px-4 py-3 text-white focus:border-[#c9a86a] focus:outline-none disabled:cursor-not-allowed disabled:opacity-50"
            >
                <option value="">Selecciona una subcategoría</option>

                <template x-for="subcategory in filteredSubcategories" :key="subcategory.id">
                    <option :value="subcategory.id" x-text="subcategory.name"></option>
                </template>
            </select>

            <p class="mt-2 text-xs text-white/45">
                Primero selecciona una categoría para ver sus subcategorías.
            </p>
        </div>
    </div>

    <div>
        <label class="mb-2 block text-sm font-medium text-white/80">SKU</label>
        <input type="text"
               name="sku"
               value="{{ old('sku', $product->sku ?? '') }}"
               class="w-full rounded-2xl border border-white/10 bg-[#111111] px-4 py-3 text-white focus:border-[#c9a86a] focus:outline-none">
    </div>

    <div
        x-data="{
            preview: @js(!empty($product?->main_image) ? asset('storage/' . $product->main_image) : null),
            updatePreview(event) {
                const file = event.target.files[0];

                if (!file) {
                    return;
                }

                this.preview = URL.createObjectURL(file);
            }
        }"
    >
        <label class="mb-2 block text-sm font-medium text-white/80">Imagen principal</label>

        <input
            type="file"
            name="main_image"
            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
            @change="updatePreview"
            class="w-full rounded-2xl border border-white/10 bg-[#111111] px-4 py-3 text-white file:mr-4 file:rounded-xl file:border-0 file:bg-[#c9a86a] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-black"
        >

        <p class="mt-2 text-xs text-white/45">
            Formatos permitidos: JPG, JPEG, PNG, WEBP. Máximo 2 MB.
        </p>

        <div class="mt-4">
            <p class="mb-2 text-xs uppercase tracking-[0.2em] text-white/45">Vista previa</p>

            <template x-if="preview">
                <img
                    :src="preview"
                    alt="Vista previa"
                    class="h-32 w-32 rounded-2xl border border-white/10 object-cover"
                >
            </template>

            <template x-if="!preview">
                <div class="flex h-32 w-32 items-center justify-center rounded-2xl border border-dashed border-white/10 bg-[#111111] text-xs text-white/35">
                    Sin imagen
                </div>
            </template>
        </div>

        @if(!empty($product?->main_image))
            <div class="mt-4">
                <p class="mb-2 text-xs uppercase tracking-[0.2em] text-white/45">Imagen actual</p>

                <div class="flex items-start gap-4">
                    <img src="{{ asset('storage/' . $product->main_image) }}"
                         alt="{{ $product->name }}"
                         class="h-32 w-32 rounded-2xl border border-white/10 object-cover">

                    @if(!empty($product?->id))
                        <button
                            type="button"
                            class="rounded-2xl border border-red-500/20 px-4 py-2 text-sm font-semibold text-red-300 transition hover:bg-red-500/10"
                            @click="if (confirm('¿Eliminar la imagen principal?')) { fetch('{{ route('admin.products.main-image.destroy', $product) }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'text/html' }, body: new URLSearchParams({ '_method': 'DELETE' }) }).then(() => window.location.reload()); }"
                        >
                            Eliminar imagen principal
                        </button>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <div
        x-data="{
            previews: [],
            updateGalleryPreview(event) {
                this.previews = [];

                const files = Array.from(event.target.files || []);

                files.forEach(file => {
                    this.previews.push(URL.createObjectURL(file));
                });
            }
        }"
    >
        <label class="mb-2 block text-sm font-medium text-white/80">Imágenes extra (opcional)</label>

        <input
            type="file"
            name="gallery_images[]"
            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
            multiple
            @change="updateGalleryPreview"
            class="w-full rounded-2xl border border-white/10 bg-[#111111] px-4 py-3 text-white file:mr-4 file:rounded-xl file:border-0 file:bg-[#c9a86a] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-black"
        >

        <p class="mt-2 text-xs text-white/45">
            Puedes subir ninguna, una o varias imágenes adicionales.
        </p>

        <div class="mt-4">
            <p class="mb-2 text-xs uppercase tracking-[0.2em] text-white/45">Vista previa de nuevas imágenes</p>

            <div class="grid grid-cols-2 gap-3 md:grid-cols-4" x-show="previews.length > 0">
                <template x-for="(preview, index) in previews" :key="index">
                    <img :src="preview" alt="Vista previa galería" class="h-24 w-full rounded-2xl border border-white/10 object-cover">
                </template>
            </div>
        </div>

        @if(!empty($product?->images) && $product->images->count())
            <div class="mt-6">
                <p class="mb-3 text-xs uppercase tracking-[0.2em] text-white/45">Galería actual</p>

                <div class="grid grid-cols-2 gap-3 md:grid-cols-4">
                    @foreach($product->images as $image)
                        <div class="group relative">
                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                alt="Imagen extra"
                                class="h-24 w-full rounded-2xl border border-white/10 object-cover">

                            <button
                                type="button"
                                class="absolute right-2 top-2 rounded-full bg-black/70 px-2 py-1 text-[10px] font-semibold text-white transition hover:bg-red-500"
                                @click="if (confirm('¿Eliminar esta imagen?')) { fetch('{{ route('admin.products.images.destroy', $image) }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'text/html' }, body: new URLSearchParams({ '_method': 'DELETE' }) }).then(() => window.location.reload()); }"
                            >
                                ✕
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <div class="md:col-span-2">
        <label class="mb-2 block text-sm font-medium text-white/80">Descripción corta</label>
        <input type="text"
               name="short_description"
               value="{{ old('short_description', $product->short_description ?? '') }}"
               class="w-full rounded-2xl border border-white/10 bg-[#111111] px-4 py-3 text-white focus:border-[#c9a86a] focus:outline-none">
    </div>

    <div class="md:col-span-2">
        <label class="mb-2 block text-sm font-medium text-white/80">Descripción</label>
        <textarea name="description"
                  rows="5"
                  class="w-full rounded-2xl border border-white/10 bg-[#111111] px-4 py-3 text-white focus:border-[#c9a86a] focus:outline-none">{{ old('description', $product->description ?? '') }}</textarea>
    </div>

    <div>
        <label class="mb-2 block text-sm font-medium text-white/80">Precio</label>
        <input type="number"
               step="0.01"
               min="0"
               name="price"
               value="{{ old('price', $product->price ?? '') }}"
               class="w-full rounded-2xl border border-white/10 bg-[#111111] px-4 py-3 text-white focus:border-[#c9a86a] focus:outline-none">
    </div>

    <div>
        <label class="mb-2 block text-sm font-medium text-white/80">Precio oferta</label>
        <input type="number"
               step="0.01"
               min="0"
               name="sale_price"
               value="{{ old('sale_price', $product->sale_price ?? '') }}"
               class="w-full rounded-2xl border border-white/10 bg-[#111111] px-4 py-3 text-white focus:border-[#c9a86a] focus:outline-none">
    </div>

    <div>
        <label class="mb-2 block text-sm font-medium text-white/80">Stock</label>
        <input type="number"
               min="0"
               name="stock"
               value="{{ old('stock', $product->stock ?? 0) }}"
               class="w-full rounded-2xl border border-white/10 bg-[#111111] px-4 py-3 text-white focus:border-[#c9a86a] focus:outline-none">
    </div>

    <div>
        <label class="mb-2 block text-sm font-medium text-white/80">Stock mínimo</label>
        <input type="number"
               min="0"
               name="min_stock"
               value="{{ old('min_stock', $product->min_stock ?? 0) }}"
               class="w-full rounded-2xl border border-white/10 bg-[#111111] px-4 py-3 text-white focus:border-[#c9a86a] focus:outline-none">
    </div>
</div>

<div class="mt-6 grid gap-4 md:grid-cols-2">
    <label class="flex items-center gap-3">
        <input type="checkbox" name="is_featured" value="1"
               {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}
               class="h-4 w-4 rounded border-white/20 bg-[#111111] text-[#c9a86a] focus:ring-[#c9a86a]">
        <span class="text-sm text-white/80">Producto destacado</span>
    </label>

    <label class="flex items-center gap-3">
        <input type="checkbox" name="is_new" value="1"
               {{ old('is_new', $product->is_new ?? false) ? 'checked' : '' }}
               class="h-4 w-4 rounded border-white/20 bg-[#111111] text-[#c9a86a] focus:ring-[#c9a86a]">
        <span class="text-sm text-white/80">Producto nuevo</span>
    </label>

    <label class="flex items-center gap-3">
        <input type="checkbox" name="is_on_sale" value="1"
               {{ old('is_on_sale', $product->is_on_sale ?? false) ? 'checked' : '' }}
               class="h-4 w-4 rounded border-white/20 bg-[#111111] text-[#c9a86a] focus:ring-[#c9a86a]">
        <span class="text-sm text-white/80">En oferta</span>
    </label>

    <label class="flex items-center gap-3">
        <input type="checkbox" name="status" value="1"
               {{ old('status', $product->status ?? true) ? 'checked' : '' }}
               class="h-4 w-4 rounded border-white/20 bg-[#111111] text-[#c9a86a] focus:ring-[#c9a86a]">
        <span class="text-sm text-white/80">Activo</span>
    </label>
</div>

<div class="mt-6 flex gap-3">
    <button type="submit"
            class="rounded-2xl bg-[#c9a86a] px-5 py-3 text-sm font-semibold text-black transition hover:opacity-90">
        Guardar
    </button>

    <a href="{{ route('admin.products.index') }}"
       class="rounded-2xl border border-white/10 px-5 py-3 text-sm font-semibold text-white transition hover:border-white/30">
        Cancelar
    </a>
</div>