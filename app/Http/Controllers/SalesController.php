<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SalesController extends Controller
{
    // Function to retrieve and display sales data
    function sales(){
        // Retrieve all sales records from the database
        $sales = \App\Models\Sale::get();

        // Retrieve active product records from the database
        $products = \App\Models\Product::where('status', 1)->get();

        // Return the view 'coffee_sales' with sales data
        return view('coffee_sales', compact(['sales', 'products']));
    }

    // Function to add a new sale record
    function add_sale(Request $request){
        // Validate the request data
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'profit_margin' => 'required|integer',
            'unit_cost' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'qty' => 'required|integer'
        ]);

        // Create a new Sale model instance
        $sale = new \App\Models\Sale();

        // Set values for the new sale record
        $sale->employee_id = Auth::user()->id; // Set the employee ID to the currently authenticated user's ID
        $sale->product_id = $request->product_id; //Sets Selected Product Id
        $sale->qty = $request->qty; // Set the quantity of items sold
        $sale->unit_cost = number_format($request->unit_cost, 2); // Format the unit cost to 2 decimal places
        $sale->selling_price = number_format($request->selling_price, 2); // Format the selling price to 2 decimal places
        $sale->profit_margin = $request->profit_margin; // Profit Marg
        $sale->shipping_cost = 10; // Set a default shipping cost

        // Save the new sale record to the database
        $sale->save();

        // Retrieve all sales records from the database
        $sales = \App\Models\Sale::get();

        // Redirect the user to the 'sales' route
        return redirect()->to('sales');
    }
}