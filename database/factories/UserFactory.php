<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

/* $factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'phone_number' => $faker->unique()->phoneNumber,
        'reg_number'=> $faker->unique()->numberBetween(201300000000, 20139999999),
        'role'     => $faker->randomElement(['admin' , 'teacher' , 'student']),
        'active'   => 1,
        'section_id' => $faker->numberBetween(1 , 7),
        'image' => '',
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->state(User::class , 'admin' , [
        'role' => 'admin',
        'section_id' => null,
]);
$factory->state(User::class , 'teacher' , [
        'role' => 'teacher',
        'section_id' => null,
]);
$factory->state(User::class , 'student' , [
        'role' => 'student',
]); */
