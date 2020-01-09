## School Managenent System
This school Management system in its initial development stage is open source and free for any one when a stable version is ready. ( Things we do for the love of the community ).

## CONTRIBUTE
This school management software is in its initial stage of development, and I'll appreciate your contribution. 

Want to contribute? Great, thanks a lot , kindly view the [Contribution guideline](https://github.com/onyia314/school/blob/master/CONTRIBUTING.md)


## Getting Started

```git clone https://github.com/onyia314/school```

copy the contents of the  ```.env.example``` to  your ```.env``` and edit APP_TIMEZONE according to your location's timezone. Don't worry about the APP_KEY at this stage just proceed:

```
APP_NAME=School
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost
APP_TIMEZONE = 'Africa/Lagos'

```
And also edit the database details according to your database environment:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=school
DB_USERNAME=yourDBusername
DB_PASSWORD=yourpassword

```
Run ```composer install```

Generate `APP_KEY` by running ```php artisan key:generate ```

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

Serve your application with ```php artisan serve```

## Things To Know Before Contributing

### Add Admin and Login as the Admin
After running the UsersTableSeeder, login with your email or reg_number.

create admin(s)

login as the admin

### Classes and Sections (Arms) 
a) go to academic settings link to create a class 

b) After creating a class, you have to create a section for this class (what others may call ARMS).

### School Session and Semesters (Term).
a)  go to academic settings link to create academic session

b) proceed to create a semester (Term)

kindly view the [Contribution guideline](https://github.com/onyia314/school/blob/master/CONTRIBUTING.md) for more guideline on contributing. Thanks.