<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class ProductsController extends Controller
{
    // Function to retrieve a product by ID
    function getProduct(Request $request){
        // Validate the request data
        $validated = $request->validate([
            'id' => 'required|exists:products,id' // Validation rule to ensure 'id' parameter exists in 'products' table
        ]);

        // Find the product by ID or throw an exception if not found
        $product = \App\Models\Product::findOrFail($request->id);

        // Return a JSON response with success status and product data
        return response([
            "success" => true,
            "data" => $product
        ]);
    }

}

