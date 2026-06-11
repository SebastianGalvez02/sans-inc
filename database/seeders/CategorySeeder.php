<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['categoryName' => 'Business Technology',       'categoryDescription' => 'Professional technology products for modern business operations'],
            ['categoryName' => 'Office Solutions',          'categoryDescription' => 'Essential office products and workplace productivity solutions'],
            ['categoryName' => 'Consulting Services',       'categoryDescription' => 'Strategic services for process improvement and business growth'],
            ['categoryName' => 'Managed Support',           'categoryDescription' => 'Ongoing support services for reliable daily operations'],
            ['categoryName' => 'Training and Development',  'categoryDescription' => 'Professional training programs for teams and organizations'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
