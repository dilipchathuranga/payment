<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UProfileController extends Controller
{
    public function index(){

        $user = User::find(auth()->user()->id);

        return view('u_profile')->with(['user' => $user]);
    }

    public function store(Request $request){

        $validator =Validator::make($request->all(),[
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => 'required|min:5',
            'password_confirmation' => ['same:new_password']
        ]);

        if($validator->fails()){
            return redirect('profile')->withErrors($validator);
        }else{

            User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);
            return redirect('profile')->with('message', 'Password Changed !');

        }

    }
}
