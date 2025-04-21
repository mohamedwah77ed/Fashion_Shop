<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Subcategory;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $man = Category::where('name', 'man')->first();
        $woman = Category::where('name', 'woman')->first();
        $children = Category::where('name', 'children')->first();

        Subcategory::create(['name' => 'shirts', 'category_id' => $man->id]);
        Subcategory::create(['name' => 'pants', 'category_id' => $man->id]);
        Subcategory::create(['name' => 'shoses', 'category_id' => $man->id]);

        Subcategory::create(['name' => 'dress', 'category_id' => $woman->id]);
        Subcategory::create(['name' => 'pants', 'category_id' => $woman->id]);
        Subcategory::create(['name' => 'shoses', 'category_id' => $woman->id]);

        Subcategory::create(['name' => 'shirts', 'category_id' => $children->id]);
        Subcategory::create(['name' => 'pants', 'category_id' => $children->id]);
        Subcategory::create(['name' => 'shoses', 'category_id' => $children->id]);
    }
}
