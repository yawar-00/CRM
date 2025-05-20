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
                        <h4>Permission
                            <a href="{{url('permission/create')}}" class="btn btn-primary float-end">Add Permission</a>
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
                @foreach($permissions  as $permission)
                <tr >
                    <td>{{ $permission->id }}</td>
                    <td>{{ $permission->name }}</td>
                    <td>
                        <a href="{{url('permission/'.$permission->id.'/edit')}}" class="btn btn-warning" >
                            Edit
                        </a>

                        <a href="{{url('permission/'.$permission->id.'/destroy')}}" class="btn btn-danger " >
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
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js" integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection