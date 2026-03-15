<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Tecnología y accesorios' => [
                'Cables de carga',
                'Audífonos inalámbricos',
                'Power banks',
                'Mouse inalámbrico',
                'Bocinas',
                'Smartwatchs',
            ],
            'Auto y moto' => [
                'Soportes para carro',
                'Soportes para moto',
                'Aromatizantes',
                'Lámparas para bicicleta',
                'Guantes',
            ],
            'Hogar' => [
                'Humidificadores',
                'Esencias',
                'Lámparas recargables',
                'Lámpara solar',
                'Focos inteligentes',
                'Reloj despertador',
                'Soporte para mesa',
            ],
            'Caballero' => [
                'Recortadoras',
                'Afeitadora de nariz',
                'Carteras',
                'Tarjeteros',
                'Smartwatchs',
            ],
            'Dama' => [
                'Collares',
                'Espejo tulipanes',
                'Monederos',
                'Calcetas',
                'Sandalias',
                'Regalos',
                'Smartwatchs',
            ],
        ];

        $sort = 1;

        foreach ($data as $categoryName => $subcategories) {
            $category = Category::updateOrCreate(
                ['slug' => Str::slug($categoryName)],
                [
                    'name' => $categoryName,
                    'description' => $categoryName,
                    'status' => true,
                    'sort_order' => $sort++,
                ]
            );

            $subSort = 1;

            foreach ($subcategories as $subcategoryName) {
                Subcategory::updateOrCreate(
                    [
                        'category_id' => $category->id,
                        'slug' => Str::slug($subcategoryName),
                    ],
                    [
                        'name' => $subcategoryName,
                        'description' => $subcategoryName,
                        'status' => true,
                        'sort_order' => $subSort++,
                    ]
                );
            }
        }
    }
}