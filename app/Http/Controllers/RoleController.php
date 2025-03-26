<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(){
        return response()->json(Role::all());
    }

    public function store(Request $request){
        Role::create([
            'role_name' => $request['role_name'],
        ]);

        return response()->json(['success'=>'Role added successfully.']);
    }

    public function show($id){
        $role = Role::find($id);

        if(!$role){
            return response()->json(['error'=>'Role not found.']);
        }

        return response()->json(['role' => $role]);
    }

    public function update(Request $request, $id){

    }

    public function destroy($id){
        $role = Role::find($id);

        if(!$role){
            return response()->json(['error'=>'Role not found.']);
        }

        $role->delete();
        return response()->json(['success'=>'Role deleted successfully.']);
    }
}
