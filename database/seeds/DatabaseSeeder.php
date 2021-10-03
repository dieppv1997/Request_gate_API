<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\User::class, 10)->create();
        $this->call(CommentHistorySeeder::class);
        $this->call(RequestSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(UserSeeder::class);
    }
}
