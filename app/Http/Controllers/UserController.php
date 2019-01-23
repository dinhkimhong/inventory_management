<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use Auth;
use File;
use Storage;

class UserController extends Controller
{
    public function settingPage()
    {
    	return view('user.setting');
    }

    public function resetPassword(Request $request)
    {
    	$id = Auth::user()->id;
    	// $validator = Validator::make($request->all(),[
    	// 	'password'=>'required',
    	// 	'new_password'=>'required',
    	// 	'password_confirmation'=>'required',
    	// ]);

    	$password = $request->password;
    	$new_password = $request->new_password;
    	$password_confirmation = $request->password_confirmation;

    	$update = User::find($id);

    	$current_password = Auth::user()->password;
    	if(Hash::check($password,$current_password) && ($new_password === $password_confirmation)){
    		$update->password = Hash::make($new_password);
    		$update->save();
    		return back()->withSuccess('Your password has been updated');
    	} else{
    		return back();
    	}

    }


    public function updateUser(Request $request){
    	$id = Auth::user()->id;
    	// $username = Auth::user()->username;
    	// $validator = Validator::make($request->all(),[
    	// 			'name'=>'required|max:50',
    	// 			'password'=>'required|max:50',
    	// 			'email'=>'email|required|max:100',
    	// ]);
    	// if($validator->passes())
    	// {
    		$update = User::find($id);


      //       if($request->password !== 'xyz456'){
      //           $update->password = bcrypt($request->password);
      //       } else{
      //           $update->password = $password;
      //       };
    		// $update->remember_token = $remember_token;
    		$photo= Auth::user()->photo;
    		$file = $request->photo;
    		if($request->hasFile('photo') && $photo !== $file)
	    	{
	    		// $destinationPath = "Photo";
	    		
	    		$extension=$file->getClientOriginalName();
	    		$fileName=rand(11111,99999).".".date('Y-m-d').".".time().".".$extension;
	    		// return Storage::putFileAs('public', $request->file('photo'), $fileName);
	    		$request->photo->storeAs('public',$fileName);
	    		// $file->move($destinationPath, $fileName);
	    		$photo=$fileName;

	    	}

	    	// Auth::user()->username = $request->name;
	    	// Auth::user()->photo = $photo;
    		$update->user_name = $request->name;
			$update->photo = $photo;
            $update->save();
    		return redirect()->route('home')->with('success','Your information has been updated.');
    	// }

    	// return back()->withFail($validator->errors());
    }

    public function showPhoto()
    {
        $photo = Auth::user()->photo;
        return redirect("storage/". $photo);
    }

}
