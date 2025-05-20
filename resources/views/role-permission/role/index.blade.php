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
                        <h4>Roles
                            <a href="{{url('role/create')}}" class="btn btn-primary float-end">Add Role</a>
                        </h4>
                    </div>
                    <div class="card-boady">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles  as $role)
                                <tr >
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                    <td>
                    <a href="{{url('role/'.$role->id.'/give-permissions')}}" class="btn btn-warning" >
                            Add/Edit Role Permission
                        </a>
                        <a href="{{url('role/'.$role->id.'/edit')}}" class="btn btn-warning" >
                            Edit
                        </a>

                        <a href="{{url('role/'.$role->id.'/destroy')}}" class="btn btn-danger " >
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