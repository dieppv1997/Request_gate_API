<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Admin';
        $user->email= 'admin@hblab.vn';
        $user->role_id = '1';
        $user->department_id = '1';
        $user->password = Hash::make('123456');
        $user->status = 'active';
        $user->employee_id = 'admin1';
        $user->save();
    }
}
