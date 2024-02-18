<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SalesController extends Controller
{
    function sales(){
        $sales = \App\Models\Sale::get();

        return view('coffee_sales', compact('sales'));
    }

    function add_sale(Request $request){
        $validated = $request->validate([
            'unit_cost' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'qty' => 'required|integer'
        ]);

        $sale = new \App\Models\Sale();

        $sale->employee_id = Auth::user()->id;
        $sale->qty = $request->qty;
        $sale->unit_cost = number_format($request->unit_cost, 2);
        $sale->selling_price = number_format($request->selling_price, 2);
        $sale->profit_margin = 25;
        $sale->shipping_cost = 10;

        $sale->save();

        $sales = \App\Models\Sale::get();

        return redirect()->to('sales');
    }
}