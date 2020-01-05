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
            'email_verified_at' => now(),
            'phone_number' => '08103719833',
            'password' => bcrypt('password'),
            'reg_number'=> '20131835853',
            'role'     => 'master',
            'active'   => 1,
            'section_id' => null,
            'image' => '',
        ]);

        DB::table('users')->insert([
            'name'     => "chioma",
            'email'    => 'chioma@gmail.com',
            'email_verified_at' => now(),
            'phone_number' => '07030562007',
            'password' => bcrypt('password'),
            'reg_number'=> '20131835854',
            'role'     => 'admin',
            'active'   => 1,
            'section_id' => null,
            'image' => '',
        ]);

        /* DB::table('users')->insert([
            'name'     => "nkem",
            'email'    => 'nkem@gmail.com',
            'email_verified_at' => now(),
            'phone_number' => null,
            'password' => bcrypt('password'),
            'reg_number'=> '20131835855',
            'role'     => 'student',
            'active'   => 0,
            'section_id' => 1,
            'image' => '',
        ]); */


       /*  factory(User::Class , 2)->states('admin')->create();
        factory(User::Class , 5)->states('teacher')->create();
        factory(User::Class , 100)->states('student')->create(); */

    }
}
