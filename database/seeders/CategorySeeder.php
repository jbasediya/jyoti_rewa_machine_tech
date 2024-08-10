<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Electronics'],
            ['name' => 'Furniture'],
            ['name' => 'Clothing'],
            ['name' => 'Books'],
            ['name' => 'Toys'],
            ['name' => 'Groceries'],
            ['name' => 'Health & Beauty'],
            ['name' => 'Automotive'],
            ['name' => 'Sports & Outdoors'],
            ['name' => 'Home Appliances'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
