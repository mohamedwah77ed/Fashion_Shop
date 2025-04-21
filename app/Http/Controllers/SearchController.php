<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Http\JsonResponse;



class SearchController extends Controller
{

    public function search(Request $request): JsonResponse
    {
        // Validate the search query
        $request->validate([
            'query' => 'required|string|max:255',
        ]);

        // Get the search query from the request
        $query = $request->input('query');

        // Search in the 'products' table (replace 'Product' with your model)
        $results = Product::where('name', 'LIKE', '%' . $query . '%')->get();
        if ($results->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No products found.',
            ]);
        }

        // Return the results as JSON
        return response()->json([
            'success' => true,
            'data' => $results,
        ]);
    }
}
