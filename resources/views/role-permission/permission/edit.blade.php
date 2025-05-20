
@extends('layouts.master')
@section('content')

<div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Permission
                            <a href="{{url('permission')}}" class="btn btn-primary float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-boady">
                        <form action="{{url('permission/'.$permission->id)}}" method="POSt">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                            <label for="">Permission Name</label>
                            <input type="text" name="name" value="{{$permission->name}}" class="form-control">
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