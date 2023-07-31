<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function addFavorite(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
            ]);

            $user = $request->user();
            $productId = $request->input('product_id');

            // Check if the user has already marked the product as a favorite
            $existingFavorite = Favorite::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->first();

            if ($existingFavorite) {
                //  product is already a favorite, remove it
                $existingFavorite->delete();
                return response()->json(['message' => 'Product removed from favorites'], 200);
            } else {
                //  product is not a favorite, add it to the favorites table
                $favorite = new Favorite([
                    'user_id' => $user->id,
                    'product_id' => $productId,
                ]);
                $favorite->save();

                return response()->json(['message' => 'Product added to favorites'], 200);
            }
        } catch (\Exception $e) {
            // Handle any unexpected exceptions and return an error response
            return response()->json(['message' => 'An error occurred. Please try again later.', 'error' => $e->getMessage()], 500);
        }
    }
}