<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function index()
    {
        $users = User::all();

        return response()->json([
            'status' => true,
            'message' => 'Users fetched successfully',
            'data' => $users
        ],200);
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' =>'required|string|max:255',
            'email' =>'required|email',
            'password' =>'required|min:6',
        ]);
        if(!$validator){
            return response()->json([
            'status' => false,
            'message' => 'Validation failed',
            'error'=> $validator->errors()
        ],422);
        }
        $user = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> $request->password,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Users created successfully',
            'data' => $user
        ],200);
    }

    public function update(Request $request,$id)
    {
        $user = User::find($id);
        if(!$user){
            
        return response()->json([
            'status' => false,
            'message' => 'Users not found',
        ],404);
        }
        $validator = Validator::make($request->all(),[
            'name' =>'required|string|max:255',
            'email' =>'required|email',
            'password' =>'sometimes|min:6',
        ]);
        if(!$validator){
            return response()->json([
            'status' => false,
            'message' => 'Validation failed',
            'error'=> $validator->errors()
        ],422);
        }
        $user->name =$request->name;
        $user->email =$request->email;
        if($request->filled('password')){
            $user->password =$request->password;

        }
        $user->save();
        return response()->json([
            'status' => true,
            'message' => 'Users uptades successfully',
            'data' => $user
        ],200);
    }


    public function updatePartial(Request $request,$id)
    {
        $user = User::find($id);
        if(!$user){
            
        return response()->json([
            'status' => false,
            'message' => 'Users not found',
        ],404);
        }
        $rules=[];
        if($request->has('name')){
            $rules['name'] ='string|max:255';
        }
        if($request->has('email')){
            $rules['email'] ='email'.$id;
        }
        if($request->has('password')){
            $rules['password'] ='min:6';
        }
        $validator = Validator::make($request->all(),$rules);
        if(!$validator){
            return response()->json([
            'status' => false,
            'message' => 'Validation failed',
            'error'=> $validator->errors()
        ],422);
        }
        if($request->has('name')){
            $user->name =$request->name;
        }
        if($request->has('email')){
            $user->email =$request->email;
        }
        if($request->has('password')){
            $user->password =$request->password;
        }
        $user->save();
        return response()->json([
            'status' => true,
            'message' => 'Users partially uptades successfully',
            'data' => $user
        ],200);
    }
    public function destroy($id){
        $user = User::find($id);
        if(!$user){    
            return response()->json([
                'status' => false,
                'message' => 'Users not found',
            ],404);
        }
        $user->delete();
        return response()->json([
            'status' => true,
            'message' => 'Users partially uptades successfully',
            'data' => $user
        ],200);
    }
}
