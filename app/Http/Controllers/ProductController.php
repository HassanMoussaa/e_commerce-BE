<?php

namespace App\Http\Controllers;

use App\Models\Product;


class ProductController extends Controller
{
    public function getProducts()
    {
        // Fetch all products along with their categories
        $products = Product::with('category')->get();

        return response()->json($products);
    }


    public function deleteProduct($id)
    {
        try {

            $product = Product::find($id);
            $product->delete();

            return response()->json(['message' => 'Product deleted successfully ' . $id], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete product'], 500);
        }

    }


}