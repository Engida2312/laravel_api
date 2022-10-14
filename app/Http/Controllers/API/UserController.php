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
            'password' => 'required|min:8',
            'role',
        ]);
        // hash password
        $formFields['password'] = bcrypt($formFields['password']);
        $formFields['role'] = 'user';

        // create user 
        $user = User::create($formFields);
        
        // login
        if($user){
            // create token
            $token = $user->createToken('token')->plainTextToken;
            // create cookie
            $cookie = cookie('jwt', $token, 60*24);//1 day
    
            return response([  
                'status'=>200,  
                'message'=> 'User created successfully',
                'name' => $user->name,
                'email' => $user->email,
                'id' => $user->id,
                'token'=>$token
            ])->withCookie($cookie);
        }
    }

    public function login(Request $request){
        $email = $request->email;
        $password = $request->password;
        // if(!Auth::attempt($request->only('email', 'password'))){

        if(!Auth::attempt(['email'=> $email,  'password'=> $password]))
        {
            return response([
                'message' => 'Invalid credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $user = Auth::user();
        // create token
        $token = $user->createToken('token')->plainTextToken;
        // create cookie
        $cookie = cookie('jwt', $token, 60*24);//1 day

        return response([   
            'message'=> 'success',
            'user' => $user,
            'token'=>$token
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
