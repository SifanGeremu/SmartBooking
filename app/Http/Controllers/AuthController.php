<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function Register(Request $request){

    //Registration Logic 

    $request->validate([
        'name'=>'required|string|max:255',
        'email'=>'required|string|email|max:255|unique:users',
        'password'=>'required|string|min:8|confirmed',
    ]);

    $user = User::Create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>bcrypt($request->password),
    ]);

    $user->assignRole('user');

    return response()->json(['message'=>'User registered successfully'],201);

    }
     
    
    public function Login(Request $request){

    
    }
     public function Logout(Request $request){

    
    }
}
