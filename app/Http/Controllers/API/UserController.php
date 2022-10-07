<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\CssSelector\Node\FunctionNode;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function register(Request $request){
        // validation
        $formFields = $request->validate([
            'name'=> ['required', 'min:3'],
            'email'=> ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|min:6',
            'role',
        ]);
        // hash password
        $formFields['password'] = bcrypt($formFields['password']);
        $formFields['role'] = 'user';

        // create user 
        $user = User::create($formFields);
        // login
        // auth()->login($user);

        return response()->json([
            'status'=>200, 
            'message'=>'User created successfully',
            'user'=> $user,
        ]);
    }
    public function login(Request $request){
        
        if(!Auth::attempt($request->only('user', 'pwd'))){
            return response([
                'message' => 'Invalid credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }
        
        // create token
        $token = $user->createToken('token')->plainTextToken;
        // create cookie
        $cookie = cookie('jwt', $token, 60*24);//1 day
        return response([   
            'message'=> 'success',
        ])->withCookie($cookie);
    }

    public function user(){
        return Auth::user();
    }

    public function logout(Request $request){
        $cookie = Cookie::forget('jwt');
        return response([
            'message'=> 'success'
        ])->withCookie($cookie);
    }
}
