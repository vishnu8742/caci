<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class ProductsTest extends TestCase
{
    public function test_get_product()
    {
        // Create a user to authenticate with
        $user = User::findOrFail(1);

        // Authenticate the user for the test
        $this->actingAs($user);

        $csrfToken = csrf_token();

        $response = $this->post(route('coffee.get_product'), ['_token' => $csrfToken,'id' => 1]);

        $response->assertStatus(200); // Assert that the response status is 200
        $response->assertJson(['success' => true]); // Assert that the response contains a 'success' key with a value of true
        $response->assertJsonStructure(['data' => ['id']]); // Assert that the response contains a 'data' key with a nested 'id' key
    }
}
