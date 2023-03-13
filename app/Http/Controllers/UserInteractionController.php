<?php

namespace App\Http\Controllers;

use App\Models\UserInteraction;
use Illuminate\Http\Request;

class UserInteractionController extends Controller
{
   
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        error_log('hjk');
        $userInteraction = UserInteraction::where('user_id', $request->input('user_id'))->first();
        if (!$userInteraction) {
            $userInteraction = new UserInteraction;
            $userInteraction->user_id =  $request->input('user_id');
            $userInteraction->interactions = $request->input('component_id');
        }else{
            $newValue = $request->input('component_id');
            $oldValue= $userInteraction->interactions;
            $updateInteraction = $oldValue ? ($oldValue==$newValue ? $oldValue : $oldValue. ',' .$newValue) : $newValue;
            $userInteraction->interactions = $updateInteraction;
        }
        $userInteraction->save();
        
        return response()-> json([
            'status'=> 200,
            'message'=>'successfully'
        ]);
        
    }
    public function singleUserInteraction($id){
        $userInteraction = UserInteraction::join('users', 'users.id', '=', 'user_Interactions.user_id')
        ->where('user_Interactions.user_id',$id)
        ->get(['user_Interactions.interactions']);

        return response()->json([
            'status'=> 200,
            'message'=>$userInteraction
        ]);
    }

}
