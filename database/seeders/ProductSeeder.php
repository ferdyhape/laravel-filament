<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        for ($i = 1; $i <= 10; $i++) {
            Product::create([
                'name' => $faker->sentence(2),
                'price' => $faker->randomFloat(2, 1, 100),
                'description' => $faker->sentence(10),
                'category_id' => Category::inRandomOrder()->first()->id,
            ]);
        }
    }
}
