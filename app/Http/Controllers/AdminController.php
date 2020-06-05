<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    //
    public function getAdminlogin(){
    	return view('login');
    }

    public function postAdminlogin(Request $request){
        $this->validate($request , 
            [
                'email'    => 'required | email',
                'password' => 'required | min:6 | max:50',
            ] , 
            [
                'email.required'      =>  'you must write email',
                'email.email'         =>  'wrong format email',

                'password.required'   =>  'you must write password',
                'password.min'        =>  'min of password are 6 characters',
                'password.max'        =>  'max of password are 50 characters',
            ]
        );

    	// echo "<pre>";
    	// print_r($request->all());
    	// echo "</pre>";die();
    	if(Auth::attempt(['email' => $request->email , 'password' => $request->password])){
    		return redirect('dashboard/all')->with('success' , 'Login ok');
    	}else{
    		return redirect()->back()->withErrors('email or password incorrect');
    	}
    }

    public function getAdminLogout(){
        Auth::logout();
        return redirect('login');
    }
}
