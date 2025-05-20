@extends('layouts.master')
@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="class-header">
                        <h4>
                             Edit  Users 
                            <a href="{{ url('users')}}" class="btn btn-primary float-end ">back </a>
                        </h4>
                    </div>

                    <div class="card-body">
                        <form action="{{url('users/'.$user->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="">name </label>
                                <input type="text" name="name"  value="{{$user->name}}" class="form-control">
                                @error ('name')<span class="text-danger"> {{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">Emaill </label>
                                <input type="text" name="email" readonly value="{{$user->email}}" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="">Password </label>
                                <input type="text" name="password" class="form-control">
                                @error ('password')<span class="text-danger"> {{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">Roles</label>
                                <Select  name="roles[]" class="form-control" multiple >
                                    <option value="">Select role </option>
                                           @foreach ($roles as $role )
                                           <option value="{{$role}}"  {{ in_array($role, $userRoles) ? 'selected': '' }}>{{$role}}</option>    
                                           @endforeach                             
                                  </Select>
                                  @error ('roles')<span class="text-danger"> {{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit">Update  </button>
                            </div>  
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
  @endsection