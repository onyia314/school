## Getting Started
```git clone https://github.com/onyia314/school```
rename the ```.env.example``` to ```.env``` and edit APP_NAME , APP_TIMEZONE as you want:
```
APP_NAME=School
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost
APP_TIMEZONE = 'Africa/Lagos'

```
And the database varibles according to your database environment:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=school
DB_USERNAME=root
DB_PASSWORD=

```
Run ```composer install```

Generate `APP_KEY` by running ````php artisan key:generate ```

migrate your database ```php artisan migrate```

Go to ```APP\database\seeds\UsersTableSeeder.php``` 

```
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

```
edit name ,email ,phone_number , password , reg_number, email_verified_at...
Do not change the other details (role , active , section_id , 'image').

seed the database ```php artisan db:seed```
NOTE : You have to seed the UsersTableSeeder so as to create the master account.