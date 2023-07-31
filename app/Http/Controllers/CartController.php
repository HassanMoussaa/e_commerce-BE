<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
            ]);

            $user = auth()->user();
            $cart = $user->cart;

            // Check if the user has a cart
            if (!$cart) {
                return response()->json(['message' => 'Cart not found'], 404);
            }

            $productId = $request->input('product_id');

            // Check if the item is already in the cart
            $existingItem = CartItem::where('cart_id', $cart->id)->where('product_id', $productId)->first();

            if ($existingItem) {
                return response()->json(['message' => 'Item is already in the cart'], 200);
            } else {
                // Add a new item to the cart
                $newItem = new CartItem([
                    'cart_id' => $cart->id,
                    'product_id' => $productId,
                ]);
                $newItem->save();

                return response()->json(['message' => 'Item added to cart successfully'], 200);
            }
        } catch (\Exception $e) {
            // Handle any unexpected exceptions and return an error response
            return response()->json(['message' => 'An error occurred. Please try again later.', 'error' => $e->getMessage()], 500);
        }
    }
}