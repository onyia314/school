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
            'email'    => 'youremail@gmail.com',
            'email_verified_at' => now(),
            'phone_number' => '070305620763763',
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

        DB::table('users')->insert([
            'name'     => "miss temitope",
            'email'    => 'temi@example.com',
            'email_verified_at' => now(),
            'phone_number' => '0703035855',
            'password' => bcrypt('password'),
            'reg_number'=> '20131835855',
            'role'     => 'teacher',
            'active'   => 1,
            'section_id' => null,
            'image' => '',
        ]);

        DB::table('users')->insert([
            'name'     => "mr luke shaw",
            'email'    => 'luke@example.com',
            'email_verified_at' => now(),
            'phone_number' => '0703035855647',
            'password' => bcrypt('password'),
            'reg_number'=> '20131835856',
            'role'     => 'teacher',
            'active'   => 1,
            'section_id' => null,
            'image' => '',
        ]);

        DB::table('users')->insert([
            'name'     => "uba smart",
            'email'    => 'smart@example.com',
            'email_verified_at' => now(),
            'phone_number' => '07030358557565',
            'password' => bcrypt('password'),
            'reg_number'=> '20131835857',
            'role'     => 'accountant',
            'active'   => 1,
            'section_id' => null,
            'image' => '',
        ]);

       // factory(User::Class , 2)->states('admin')->create();
        factory(User::Class , 5)->states('teacher')->create();
        factory(User::Class , 100)->states('student')->create();

    }
}
