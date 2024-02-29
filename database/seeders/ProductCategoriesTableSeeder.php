<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [   'name' => 'Soup'],
            [   'name' => 'Peppersoup'],
            [
                'name' => 'Breakfast Combo',
            ],
            [
                'name' => 'Extra',
                'children' => [
                    ['name' => 'Swallow'],
                    ['name' => 'Others'],
                ],
            ],
            [
                'name' => 'Proteins',
            ],
            [
                'name' => 'Drinks',
                'children' => [
                    ['name' => 'Alcoholic'],
                    ['name' => 'Non-Alcoholic'],
                ],
            ],
            [
                'name' => 'Rice/Pasta/Porridge',
            ],
        ];

        foreach ($categories as $category) {
            $parentCategory = ProductCategory::create(['name' => $category['name']]);
            
            if (isset($category['children'])) {
                foreach ($category['children'] as $child) {
                    ProductCategory::create([
                        'name' => $child['name'],
                        'parent_id' => $parentCategory->id,
                    ]);
                }
            }
        }
    }
}
