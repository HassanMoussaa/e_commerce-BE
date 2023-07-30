<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;


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





    public function productsAdd(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:999',
            'category_id' => 'required|int',
            'image_url' => 'string',

        ]);

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'image_url' => $request->image_url,
        ]);

        return response()->json([
            'message' => 'Product added successfully',
        ]);
    }





}