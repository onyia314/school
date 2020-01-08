<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">id</th>
                @if(Auth::user()->role == 'master') 
                <th scope="col">change status</th>
                <th scope="col">edit</th>
                @endif
                <th scope="col">name</th>
                <th scope="col">reg</th>
                <th scope="col">email</th>
                <th scope="col">phone</th>
                <th scope="col">registration date</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($users as $admin)
                <tr>
                    <th scope="row">{{$admin->id}}</th>
                    @if(Auth::user()->role == 'master') 
                    <th>activate or de-activae</th>
                    <th scope="row">
                        <a class = "btn btn-primary"href="{{route('user.edit' , ['id' => $admin->id])}}">edit</a>
                    </th>
                    @endif
                    <th>{{$admin->name}}</th>
                    <th>{{$admin->reg_number}}</th>
                    <th>{{$admin->email}}</th>
                    <th>{{$admin->phone_number}}</th>
                    <th>{{$admin->created_at}}</th>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div>{{$users->links()}}</div>