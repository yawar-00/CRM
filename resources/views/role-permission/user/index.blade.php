@extends('layouts.master')
@section('content')
    <div class="container mt-5">
        <div class="row ">
            <div class="col-md-12">
                @if(session('status'))
                <div class="alert alert-success">{{session('status')}}</div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h4>Users
                            <a href="{{url('users/create')}}" class="btn btn-primary float-end">Add User</a>
                        </h4>
                    </div>
                    <div class="card-boady">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users  as $user)
                                <tr >
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if(!empty($user->getRoleNames()))
                                            @foreach ($user->getRoleNames() as $rolename)
                                            <label class="badge bg-primary mx-1">{{$rolename}}</label>
                                            @endforeach
                                        @endif
                                    </td>
                    <td>
                   
                        <a href="{{url('users/'.$user->id.'/edit')}}" class="btn btn-warning" >
                            Edit
                        </a>

                        <a href="{{url('users/'.$user->id.'/destroy')}}" class="btn btn-danger " >
                            <i class="fas fa-trash-alt"></i> Delete
                        </a>
                        
                    </td>
                </tr>
                
                @endforeach
            </table>
        </div>    
    </div>
</div>
</div>
</div>
@endsection