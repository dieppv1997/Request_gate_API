<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 1; $i <10; $i ++){
            $department = new Department();
            $department->id= $i;
            $department->name = $faker->name();
            $department->save();
        }
    }
}
