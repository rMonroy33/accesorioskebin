<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'name' => 'Audífonos inalámbricos Pro X1',
                'category' => 'Tecnología y accesorios',
                'subcategory' => 'Audífonos inalámbricos',
                'price' => 399.00,
                'sale_price' => 329.00,
                'stock' => 8,
                'is_new' => true,
                'description' => 'Audífonos inalámbricos con diseño moderno, estuche de carga y excelente comodidad para uso diario.',
            ],
            [
                'name' => 'Cable super carga Tipo C a iPhone',
                'category' => 'Tecnología y accesorios',
                'subcategory' => 'Cables de carga',
                'price' => 149.00,
                'sale_price' => null,
                'stock' => 20,
                'is_new' => false,
                'description' => 'Cable de carga rápida con excelente compatibilidad y resistencia para uso diario.',
            ],
            [
                'name' => 'Humidificador portátil LED',
                'category' => 'Hogar',
                'subcategory' => 'Humidificadores',
                'price' => 289.00,
                'sale_price' => 249.00,
                'stock' => 10,
                'is_new' => true,
                'description' => 'Humidificador compacto ideal para recámara, oficina o automóvil, con iluminación LED decorativa.',
            ],
            [
                'name' => 'Soporte de teléfono para carro',
                'category' => 'Auto y moto',
                'subcategory' => 'Soportes para carro',
                'price' => 179.00,
                'sale_price' => null,
                'stock' => 0,
                'is_new' => false,
                'description' => 'Soporte práctico y seguro para mantener tu teléfono estable durante trayectos en automóvil.',
            ],
            [
                'name' => 'Smartwatch Ultra T900',
                'category' => 'Caballero',
                'subcategory' => 'Smartwatchs',
                'price' => 699.00,
                'sale_price' => 599.00,
                'stock' => 6,
                'is_new' => true,
                'description' => 'Smartwatch con diseño elegante, múltiples funciones y estilo moderno para uso diario.',
            ],
            [
                'name' => 'Collar girasol eterno',
                'category' => 'Dama',
                'subcategory' => 'Collares',
                'price' => 249.00,
                'sale_price' => null,
                'stock' => 12,
                'is_new' => false,
                'description' => 'Collar con diseño delicado y presentación especial, ideal para regalo.',
            ],
            [
                'name' => 'Power Bank 10000mAh',
                'category' => 'Tecnología y accesorios',
                'subcategory' => 'Power banks',
                'price' => 459.00,
                'sale_price' => 399.00,
                'stock' => 9,
                'is_new' => false,
                'description' => 'Batería externa portátil con buena capacidad para cargar tus dispositivos en cualquier lugar.',
            ],
            [
                'name' => 'Lámpara solar para fachada',
                'category' => 'Hogar',
                'subcategory' => 'Lámpara solar',
                'price' => 319.00,
                'sale_price' => null,
                'stock' => 0,
                'is_new' => false,
                'description' => 'Lámpara solar funcional para exteriores, ideal para fachadas, patios o accesos.',
            ],
        ];

        foreach ($items as $index => $item) {
            $category = Category::where('name', $item['category'])->first();
            $subcategory = Subcategory::where('name', $item['subcategory'])
                ->where('category_id', $category?->id)
                ->first();

            if (!$category || !$subcategory) {
                continue;
            }

            Product::updateOrCreate(
                ['slug' => Str::slug($item['name'])],
                [
                    'category_id' => $category->id,
                    'subcategory_id' => $subcategory->id,
                    'name' => $item['name'],
                    'sku' => 'KEB-' . str_pad((string) ($index + 1), 4, '0', STR_PAD_LEFT),
                    'short_description' => $item['name'],
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'sale_price' => $item['sale_price'],
                    'stock' => $item['stock'],
                    'min_stock' => 0,
                    'main_image' => null,
                    'is_featured' => $index < 4,
                    'is_new' => $item['is_new'],
                    'is_on_sale' => !is_null($item['sale_price']),
                    'status' => true,
                ]
            );
        }
    }
}