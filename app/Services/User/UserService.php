<?php 
    namespace App\Services\User;

    use App\User;
    use App\StudentInfo;
    use App\StaffInfo;
    use Illuminate\Support\Facades\Hash;

    class UserService{

        public static function storeStudent($data){

           return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'],
                'password' => Hash::make($data['password']),
                'section_id' => (int)$data['section_id'],
                'image' => $data['image'],
                'role' => 'student',
                'active' => 1,
                'reg_number' => date('Ymd') . User::count() + 1, //remeber to fix duplicate issue that may arise due to this 
            ]);
        }

        public static function storeTeacher($data){

            return User::create([
                 'name' => $data['name'],
                 'email' => $data['email'],
                 'phone_number' => $data['phone_number'],
                 'password' => Hash::make($data['password']),
                 'image' => $data['image'],
                 'role' => 'teacher',
                 'active' => 1,
                 'reg_number' => date('Ymd') . User::count() + 1, //remeber to fix duplicate issue that may arise due to this 
                 
             ]);
         }

        public static function updateUser($id , $data){

            return User::where('id' , $id)->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone_number' =>$data['phone_number'],
            ]);

        }

        public static function updateStudentInfo($data){
            return StudentInfo::updateOrCreate(['user_id' => $data['user_id'] ], $data);
        }

        public static function updateStaffInfo($data){
            return StaffInfo::updateOrCreate(['user_id' => $data['user_id'] ], $data);
        }
    }
