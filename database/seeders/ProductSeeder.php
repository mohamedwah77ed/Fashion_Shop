<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Size;
use App\Models\ProductImage;
use App\Models\ProductVariant;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manPantsId = Subcategory::where('id', 2)
            ->whereHas('category', function ($q) {
                $q->where('id', 1);
            })->value('id');

        $womanPantsId = Subcategory::where('id', 5)
            ->whereHas('category', function ($q) {
                $q->where('id', 2);
            })->value('id');

        $sizes = Size::whereIn('name', ['S', 'M', 'L'])->get();

        $manProduct = Product::create([
            'name' => 'Man Pants',
            'description' => 'sleam jeans',
            'price' => 200.00,
            'user_id' => 1,
            'subcategory_id' => $manPantsId,
        ]);

        $manProduct->images()->createMany([
            ['image_path' => 'images/mens_pants1.jpg', 'is_main' => true],
            ['image_path' => 'images/mens_pants2.jpg'],
            ['image_path' => 'images/mens_pants3.jpg'],
        ]);

        $selectedSizeIds = [2];
        $sizes = Size::whereIn('id', $selectedSizeIds)->get();
        $colors = ['white', 'black', 'blue'];

        foreach ($sizes as $size) {
            foreach ($colors as $color) {
                $manProduct->variants()->create([
                    'size_id' => $size->id,
                    'color' => $color,
                    'stock' => rand(5, 15),
                    'price' => 200.00,
                ]);
            }
        }

        $womanProduct = Product::create([
            'name' => 'Women Pants',
            'description' => 'A stylish pair of pants for women',
            'price' => 400.00,
            'user_id' => 1,
            'subcategory_id' => $womanPantsId,
        ]);

        $womanProduct->images()->createMany([
            ['image_path' => 'images/womens_pants1.jpg', 'is_main' => true],
            ['image_path' => 'images/womens_pants2.jpg'],
            ['image_path' => 'images/womens_pants3.jpg'],
        ]);

        foreach ($sizes as $size) {
            $womanProduct->variants()->create([
                'size_id' => $size->id,
                'color' => 'black',
                'stock' => rand(5, 15),
                'price' => 400.00,
            ]);
        }
    }
}
