<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Subcategory;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request): JsonResponse
    {
        $categoryId = $request->input('id');

        $category = Category::with(['subcategories.products.mainImage', 'subcategories.products.colors'])->find($categoryId);

        if ($category) {
            $products = $category->subcategories->flatMap(function ($subcategory) {
                return $subcategory->products->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'description' => $product->description,
                        'price' => $product->price,
                        'main_image' => $product->mainImage ? $product->mainImage->image_path : null,
                        'colors' => $product->colors->pluck('color'),
                    ];
                });
            });

            return response()->json([
                'message' => 'Products retrieved successfully',
                'category' => $category->name,
                'products' => $products
            ], 200);
        }

        return response()->json([
            'message' => 'Category not found'
        ], 404);
    }
    public function showSubcategoryProducts(Request $request): JsonResponse
    {
        $subcategoryId = $request->input('id');

        $subcategory = Subcategory::with(['products.mainImage', 'products.colors'])->find($subcategoryId);

        if ($subcategory) {
            $products = $subcategory->products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'main_image' => $product->mainImage ? $product->mainImage->image_path : null,
                    'colors' => $product->colors->pluck('color'),
                ];
            });

            return response()->json([
                'message' => 'Products retrieved successfully',
                'subcategory' => $subcategory->name,
                'products' => $products
            ], 200);
        }

        return response()->json([
            'message' => 'Subcategory not found'
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
