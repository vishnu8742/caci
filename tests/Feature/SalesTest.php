<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Sale;

class SalesTest extends TestCase
{

    public function test_add_sale()
    {
        // Get Sales User
        $user = User::find(1);

        // Authenticate as the user
        $this->actingAs($user);

        // Define the data to be sent in the request
        $data = [
            'product_id' => 1,
            'unit_cost' => 10.00,
            'selling_price' => 20.00,
            'profit_margin' => 25,
            'qty' => 5
            // Add any other required data here
        ];

        // Send a POST request to the add_sale route
        $response = $this->post(route('coffee.add_sale'), $data);

        // Assert that the response has a successful status code
        $response->assertStatus(302); // Assuming you're redirecting after adding the sale
        
        // Assert that the sale was added to the database
        $this->assertDatabaseHas('sales', $data);
    }

    public function test_get_sales_data()
    {
        // Create a user
        $user = User::find(1);

        // Authenticate as the user
        $this->actingAs($user);

        // Create dummy sales data
        $sales = [];
        for ($i = 0; $i < 5; $i++) {
            $sale = new Sale();
            $sale->employee_id = $user->id;
            $sale->qty = 10;
            $sale->unit_cost = 20;
            $sale->selling_price = 30;
            $sale->shipping_cost = 30;
            $sale->profit_margin = 25;
            $sale->product_id = 1;
            
            $sale->save();
            
            $sales[] = $sale;
        }

        // Send a GET request to the sales route
        $response = $this->get(route('coffee.sales'));

        // Assert that the response has a successful status code
        $response->assertStatus(200); // returning a view for the sales page

        
        // Assert that the response contains the sales data
        foreach ($sales as $sale) {
            $response->assertSee($sale->id); // check if the sale ID is present in the response
            $response->assertSee($sale->product->name); // Check If the product Name its fetching by product_id
        }
    }
}
