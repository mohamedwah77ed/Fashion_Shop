<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Size;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Display the home page data.
     */

    public function index(): JsonResponse
    {
        $products = Cache::remember('products_page_' . request('page', 1), 60, function () {
            return Product::with(['mainImage', 'colors', 'sizes', 'subcategory'])
                ->select('id', 'name', 'description', 'price')
                ->paginate(1);
        });

        return response()->json([
            'message' => 'Products retrieved successfully',
            'products' => $products,
        ], 200);
    }

    public function show(Request $request): JsonResponse
    {
        $productId = $request->input('id');

        $product = Product::with(['images', 'colors', 'sizes'])->find($productId);

        if ($product) {
            return response()->json([
                'message' => 'Product retrieved successfully',
                'product' => $product,
            ], 200);
        }

        return response()->json([
            'message' => 'Product not found',
        ], 404);
    }
}
