<?php

namespace App\Http\Controllers\Api;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
   public function register(Request $request){

    $validData = $request->validate([
        'name' =>'required|max:30',
        'email' => 'email|required|unique:users',
        'password' => 'required|confirmed'
    ]);

    $validData['password']  = bcrypt($request->password);
    $user = User::create($validData);

    // $accessToken = $user->createToken('authToken')->accessToken;
    
    // return response(['user' => $user,'access_token' => $accessToken ]);
    return response(['user' => $user ]);

    }

   public function login(Request $request){

    $loginData = $request->validate([
        
        'email' => 'email|required',
        'password' => 'required'

    ]);

    if (!auth()->attempt($loginData)){
        return response(['message' => 'Invalid Credentials']);

    }

    $Token = auth()->user()->createToken('authToken')->accessToken;
    
    return response(['user' => auth()->user(),'access_token' => $Token ]);

   }
}
