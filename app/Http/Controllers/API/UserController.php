<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Symfony\Component\CssSelector\Node\FunctionNode;

class UserController extends Controller
{
    public function store(Request $request){
        // validation
        $formFields = $request->validate([
            'name'=> ['required', 'min:3'],
            'email'=> ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|min:6',
        ]);

        // hash password
        $formFields['password'] = bcrypt($formFields['password']);

        // create user 
        $user = User::create($formFields);

        // login
        auth()->login($user);

        // return redirect('/')->with('message', 'User created and logged in');

        // $user = new User;
        // $user->name = $request ->input('name');
        // $user->email = $request ->input('email');
        // $user->password = $request->input('password');
        // $user->save();
        return response()->json([
            'status'=>200, 
            'message'=>'User created successfully',
            'auth'=> auth()->user(),
        ]);
    }
}
