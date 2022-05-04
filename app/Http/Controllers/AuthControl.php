<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class AuthControl extends Controller
{
    //registar o usuario protegendo

    public function register(Request $request){
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);


        $token = $user->createToken('token_user')->plainTextToken;


        $reponse = [
            'user' => $user,
            'token' => $token
        ];

        return response($reponse, 201);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);


        $user = User::where('email', $request->email)->first();


        if(!$user || !Hash::check($request->password, $user->password)){
            return response([
                'message' => "da pra logar nao bobao"
            ], 401);
        }

        $token = $user->createToken('user_token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);

    }

    public function logout(){

        auth()->user()->tokens()->delete();

        return [
            'message' => 'deletado',
        ];
    }

}
