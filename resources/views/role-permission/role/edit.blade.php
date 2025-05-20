@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Role
                            <a href="{{url('role')}}" class="btn btn-primary float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-boady">
                        <form action="{{url('role/'.$role->id)}}" method="POSt">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                            <label for="">Role Name</label>
                            <input type="text" name="name" value="{{$role->name}}" class="form-control">
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection