<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'     => "onyia",
            'email'    => 'onyia314@gmail.com',
            'password' => bcrypt('password'),
            'reg_number'=> '20131835853',
            'role'     => 'master',
            'active'   => 1,
        ]);

        DB::table('users')->insert([
            'name'     => "chioma",
            'email'    => 'chioma@gmail.com',
            'password' => bcrypt('password'),
            'reg_number'=> '20131835854',
            'role'     => 'admin',
            'active'   => 1,
        ]);

        DB::table('users')->insert([
            'name'     => "nkem",
            'email'    => 'nkem@gmail.com',
            'password' => bcrypt('password'),
            'reg_number'=> '20131835855',
            'role'     => 'student',
            'active'   => 0,
        ]);

        
    }
}
