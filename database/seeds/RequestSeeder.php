<?php

use Illuminate\Database\Seeder;
use App\Models\Request;
use Faker\Factory as Faker;

class RequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 1; $i < 15; $i++) {
            $request = new Request();
            $request->category_id = $faker->numberBetween(1, 9);
            $request->content = $faker->name();
            $request->due_date = $faker->datetimeBetween('now', '+3 weeks');
            $request->user_id = $faker->numberBetween(1, 3);
            $request->admin_id = 1;
            $request->status_admin = $faker->randomElement(['Open', 'In progress', 'Close']);
            $request->status_manager = $faker->randomElement(['Open', 'Approve', 'Reject']);;
            $request->priority = $faker->randomElement(['High', 'Medium', 'Low']);;
            $request->department_id = $faker->numberBetween(1, 3);;
            $request->title = $faker->name();
            $request->save();
        }
    }
}
