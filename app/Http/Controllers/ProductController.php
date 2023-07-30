<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

// use Illuminate\Http\UploadedFile\getClientOriginalExtention;

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

        if ($request->image) {
            $file_extension = $request->image->getClientOriginalExtension();
            $file_name = time() . "." . $file_extension;
            $path = 'images';
            $request->image->move($path, $file_name);
            $image_url = " http://127.0.0.1:8000/images/" . $file_name;

        }


        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'image_url' => $image_url,
        ]);

        return response()->json([
            'message' => 'Product added successfully',
            'product' => $product,
        ]);
    }


    public function productsUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:999',
            'category_id' => 'required|int',
        ]);




        if ($request->image) {
            $file_extension = $request->image->getClientOriginalExtension();
            $file_name = time() . "." . $file_extension;
            $path = 'images';
            $request->image->move($path, $file_name);
            $image_url = " http://127.0.0.1:8000/images/" . $file_name;

        }
        $product = Product::find($id);

        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->image_url = $image_url;


        $product->save();


        return response()->json([
            'message' => 'Product updated successfully',
        ]);

    }


}