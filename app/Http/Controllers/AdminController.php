<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;

class AdminController extends Controller
{
    public function updateUsers(Request $request)
    {
    	foreach ($request->id as $key=>$value)
    	// foreach($request->input('active') as $value)
    	{
    		// $user = User::find($value);
    		// if()
    		$active = $request->active[$key];
    		// $active = $request->active;
    		// $active = isset($request->active[$key])? 1 : 0;
    		// $id = $value;

    		// var_dump($value);
    		var_dump($active);
    		// echo $id;
    		// echo $active;

    		// $user = User::find($value);
    		// $user->roles()->sync($request->role[$key]);

    	}
    	// return back()->withSuccess('Users has been updated');
    }
}
