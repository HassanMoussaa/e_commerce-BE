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
}