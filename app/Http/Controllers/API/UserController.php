<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Symfony\Component\CssSelector\Node\FunctionNode;
use Illuminate\Support\Facades\Validator;

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

    public function edit($id)
    {
        $data = User::find($id);
        if($data)
        {
            return response()->json([
                'status'=> 200,
                'user' => $data,
            ]);
        }
        else
        {
            return response()->json([
                'status'=> 404,
                'message' => 'No User ID Found',
            ]);
        }

    }

    public function update(Request $request, $id)
    {
        // $validator = Validator::make($request->all(),[
        //     'firstname'=>'required|max:191',
        //     'lastname'=>'required|max:191',
        //     'github'=>'required|email|max:191',
        //     'linkedin'=>'required|email|max:191',
        //     'email'=>'required|email|max:191',
        //     // 'phone'=>'required|max:10|min:10',
        // ]);

        // if($validator->fails())
        // {
        //     return response()->json([
        //         'status'=> 422,
        //         'validationErrors'=>  $validator->messages(),
        //     ]);
        // }
        // else
        // {

            $data = User::find($id);
            if($data)
            {

                
                $data->firstname= $request->input('firstname');
                $data->lastname= $request->input('lastname');
                $data->github= $request->input('github');
                $data->linkedin= $request->input('linkedin');
                // $data->password= $request->input('password');
                $data->email= $request->input('email');
                $data->update();

                return response()->json([
                    'status'=> 200,
                    'message'=>'User Updated Successfully',
                ]);
            }
            else
            {
                return response()->json([
                    'status'=> 404,
                    'message' => 'No user ID Found',
                ]);
            }
        }
    }
// }
