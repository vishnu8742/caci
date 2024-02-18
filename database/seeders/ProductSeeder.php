<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Check if at least one record exists in the database
        if ( \App\Models\Product::count() > 0) {
            $this->command->info('Data already exists. Skipping seeding.');
            return;
        }

        \App\Models\Product::create(["name"    =>  "Gold Coffee", "profit_margin" => 25, "status" => 1]);
        \App\Models\Product::create(["name"    =>  "Arabic Coffee", "profit_margin" => 15, "status" => 1]);

        //As products are introduced newly so we are seeding sales data with product_id seeded from products table
        $defaultProduct = \App\Models\Product::where('name', 'Gold Coffee')->latest()->get();
        $this->command->info($defaultProduct[0]['id']);

        \App\Models\Sale::whereNull('product_id')->update(['product_id' => $defaultProduct[0]['id']]);

        $this->command->info('Products seeded successfully.');
    }
}