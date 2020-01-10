<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">edit</th>
                <th scope="col">name</th>
                <th scope="col">reg</th>
                <th scope="col">email</th>
                <th scope="col">phone</th>
                <th scope="col">qualification</th>
                <th scope="col">birthday</th>
                <th scope="col">gender</th>
                <th scope="col">address</th>
                <th scope="col">religion</th>
                <th scope="col">nationality</th>
                <th scope="col">state of origin</th>
                <th scope="col">referee name</th>
                <th scope="col">referee phone</th>
                <th scope="col">next of kin</th>
                <th scope="col">next of kin phone</th>
                <th scope="col">previous</th>
                <th scope="col">registration date</th>
                
            </tr>
        </thead>

        <tbody>
            @foreach ($users as $staff)
                <tr>
                    <th scope="row">{{$staff->id}}</th>
                    <th scope="row">
                        <a class = "btn btn-primary"href="{{route('user.edit' , ['id' => $staff->id])}}">edit</a>
                    </th>
                    <th>{{$staff->name}}</th>
                    <th>{{$staff->reg_number}}</th>
                    <th>{{$staff->email}}</th>
                    <th>{{$staff->phone_number}}</th>
                    <th>{{$staff->staffInfo->qualification}}</th>
                    <th>{{$staff->staffInfo->birthday}}</th>
                    <th>{{$staff->staffInfo->gender}}</th>
                    <th>{{$staff->staffInfo->address}}</th>
                    <th>{{$staff->staffInfo->religion}}</th>
                    <th>{{$staff->staffInfo->nationality}}</th>
                    <th>{{$staff->staffInfo->state_of_origin}}</th>
                    <th>{{$staff->staffInfo->referee}}</th>
                    <th>{{$staff->staffInfo->referee_phone}}</th>
                    <th>{{$staff->staffInfo->next_of_kin}}</th>
                    <th>{{$staff->staffInfo->next_of_kin_phone}}</th>
                    <th>{{$staff->staffInfo->previous}}</th>
                    <th>{{$staff->created_at}}</th>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div>{{$users->links()}}</div>