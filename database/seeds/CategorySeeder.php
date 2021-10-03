<?php

use App\Models\Category;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 1; $i < 10; $i++) {
            $category = new Category();
            $category->id = $i;
            $category->user_id = '1';
            $category->name = $faker->name();
            $category->status = $faker->randomElement(['enable', 'disable']);
            $category->save();
        }
    }
}
