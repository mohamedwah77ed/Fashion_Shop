<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    public function getCart()
    {
        $cart = session()->get('cart', []);
        return response()->json($cart);
    }
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $product = Product::with('mainImage')->find($request->product_id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        if ($product->stock < ($request->quantity ?? 1)) {
            return response()->json(['message' => 'The requested quantity is not available'], 400);
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity ?? 1;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'quantity' => $request->quantity ?? 1,
                'price' => $product->price,
                'image' => $product->mainImage ? $product->mainImage->image_path : null
            ];
        }

        session()->put('cart', $cart);
        return response()->json(['message' => 'Added to cart', 'cart' => $cart]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::find($request->product_id);
        if (!$product) {
            return response()->json(['message' => 'المنتج غير موجود'], 404);
        }

        $cart = session()->get('cart', []);
        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] = $request->quantity;
            $cart[$request->product_id]['price'] = $product->price; // تحديث السعر
            session()->put('cart', $cart);
            return response()->json(['message' => 'تم تحديث الكمية', 'cart' => $cart]);
        }
        return response()->json(['message' => 'المنتج غير موجود في السلة'], 404);
    }
    public function remove(Request $request)
    {
        $request->validate(['product_id' => 'required']);

        $cart = session()->get('cart', []);
        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);
            return response()->json(['message' => 'تم حذف المنتج', 'cart' => $cart]);
        }

        return response()->json(['message' => 'المنتج غير موجود'], 404);
    }

    public function total(): JsonResponse
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return response()->json(['total' => $total]);
    }
    public function clear()
    {
        session()->forget('cart');
        return response()->json(['message' => 'تم تفريغ السلة']);
    }
}
