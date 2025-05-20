<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
  
        /**
         * Display a listing of the resource.
         */
        public function index()
        {
            $roles = Role::get();
            return view('role-permission.role.index', compact('roles'));
        }
    
        /**
         * Show the form for creating a new resource.
         */
        public function create()
        {   
            
            return view('role-permission.role.create');
            
        }
    
        /**
         * Store a newly created resource in storage.
         */
        public function store(Request $request)
        {
            $request->validate([
                'name'=>[
                    'required',
                    'string',
                    'unique:roles,name'
                ]
            ]);
            $role = Role::create([
                    'name'=>$request->name
            ]);
            return redirect('role')->with('status','Role Created Successfully');
        }
    
        /**
         * Display the specified resource.
         */
       
    
        /**
         * Show the form for editing the specified resource.
         */
        public function edit(Role $role)
        {
            return view('role-permission.role.edit',compact('role'));
        }
    
        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request,Role $role)
        {
            $request->validate([
                'name'=>[
                    'required',
                    'string',
                    'unique:roles,name,'.$role->id
                ]
            ]);
            $role ->update([
                    'name'=>$request->name
            ]);
            return redirect('role')->with('status','Role Updated Successfully');
        }
    
        /**
         * Remove the specified resource from storage.
         */
        public function destroy($id)
        {
            $role =Role::findOrFail($id);
            $role->delete();
            return redirect('role')->with('status','Role Deleted Successfully');
    
        }
        public function addPermissionToRole($id){
            $permissions =Permission::get();
            $role =Role::findOrFail($id);
            $rolePermissions=DB::table('role_has_permissions')->where('role_has_permissions.role_id',$role->id)->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')->all();
            return view('role-permission.role.add-permission',compact('role','permissions','rolePermissions'));
        }
        public function givePermissionToRole(Request $request, $id){
            $request->validate([
                'permission'=>'required'
            ]);
            $role = Role::findOrFail($id);
           
            $role->syncPermissions($request->permission);
            return redirect()->back()->with('status','Permissions added to role');
        }
    
}
