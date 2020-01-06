<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">edit</th>
                <th scope="col">name</th>
                <th scope="col">reg</th>
                <th scope="col">section</th>
                <th scope="col">class</th>
                <th scope="col">email</th>
                <th scope="col">phone</th>
                <th scope="col">birthday</th>
                <th scope="col">gender</th>
                <th scope="col">nationality</th>
                <th scope="col">state of origin</th>
                <th scope="col">father's name</th>
                <th scope="col">father's phone</th>
                <th scope="col">mother's name</th>
                <th scope="col">mother's phone</th>
                <th scope="col">address</th>
                <th scope="col">religion</th>
                <th scope="col">registration date</th>
                
            </tr>
        </thead>

        <tbody>
            @foreach ($users as $student)
                <tr>
                    <th scope="row">{{$student->id}}</th>
                    <th scope="row">
                        <a class = "btn btn-primary"href="{{route('user.edit' , ['id' => $student->id])}}">edit</a>
                    </th>
                    <th>{{$student->name}}</th>
                    <th>{{$student->reg_number}}</th>
                    <th>{{$student->section->section_name}}</th>
                    <th>{{$student->section->SchoolClass->class_name .' ' 
                    .$student->section->SchoolClass->group}}
                    </th>
                    <th>{{$student->email}}</th>
                    <th>{{$student->phone_number}}</th>
                    <th>{{$student->studentInfo->birthday}}</th>
                    <th>{{$student->studentInfo->gender}}</th>
                    <th>{{$student->studentInfo->nationality}}</th>
                    <th>{{$student->studentInfo->state_of_origin}}</th>
                    <th>{{$student->studentInfo->father_name}}</th>
                    <th>{{$student->studentInfo->father_phone}}</th>
                    <th>{{$student->studentInfo->mother_name}}</th>
                    <th>{{$student->studentInfo->mother_phone}}</th>
                    <th>{{$student->studentInfo->address}}</th>
                    <th>{{$student->studentInfo->religion}}</th>
                    <th>{{$student->created_at}}</th>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div>{{$users->links()}}</div>