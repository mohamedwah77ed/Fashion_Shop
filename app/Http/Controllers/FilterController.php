<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\subcategory;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class FilterController extends Controller
{
    public function filter(Request $request): JsonResponse
    {
        $query = Product::query();
        if ($request->has('subcategory_id')) {
            $query->where('subcategory_id', $request->input('subcategory_id'));
        }

        if ($request->has('category_id')) {
            $query->whereHas('subcategory', function ($q) use ($request) {
                $q->where('category_id', $request->input('category_id'));
            });
        }

        if ($request->has('price_min')) {
            $query->where('price', '>=', $request->input('price_min'));
        }

        if ($request->has('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }

        if ($request->has('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }

        if ($request->has('sort_price')) {
            $query->orderBy('price', $request->input('sort_price'));
        }

        $products = $query->paginate(10);

        if ($products->isEmpty()) {
            return response()->json([
                'message' => 'No products found matching the criteria.'
            ], 404);
        }

        return response()->json([
            'message' => 'Products retrieved successfully.',
            'products' => $products->items(),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ]
        ], 200);
    }
}
