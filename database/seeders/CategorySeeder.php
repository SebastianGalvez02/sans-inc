<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['categoryName' => 'Limpieza', 'categoryDescription' => 'Productos destinados a la limpieza del hogar y superficies'],
            ['categoryName' => 'Uso_Personal', 'categoryDescription' => 'Productos de higiene y cuidado personal'],
            ['categoryName' => 'Irritante', 'categoryDescription' => 'Productos que pueden causar irritación en piel o mucosas'],
            ['categoryName' => 'Inflamable', 'categoryDescription' => 'Productos con componentes inflamables que requieren precaución'],
            ['categoryName' => 'Variedades', 'categoryDescription' => 'Productos disponibles en packs, promociones o múltiples presentaciones'],
            ['categoryName' => 'Aroma', 'categoryDescription' => 'Productos con fragancia o aroma especial'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
