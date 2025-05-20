@extends('layouts.master')
@section('content')
    @if(session('status'))
                <div class="alert alert-success">{{session('status')}}</div>
                @endif
    <div class="container">
        
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Role : {{$role->name}}
                            <a href="{{url('role')}}" class="btn btn-primary float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-boady">
                        <form action="{{url('role/'.$role->id.'/give-permissions')}}" method="POSt">
                            @csrf
                            @method('PUT')
                            <div class="m-3">
                                @error('permission')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                <label for="">Permissions</label>
                                <div class="row">
                                    @foreach($permissions as $permission)
                                    <div class="col-md-2">
                                        <label for="">
                                            <input type="checkbox" name="permission[]" value="{{$permission->name}}" 
                                                {{in_array($permission->id,$rolePermissions)?'checked':''}}
                                            />
                                            {{$permission->name}}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="m-3">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection