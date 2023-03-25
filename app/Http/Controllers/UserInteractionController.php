<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;



use App\Models\UserInteraction;
use Illuminate\Http\Request;
use App\Models\Component;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use App\Service\test;

class UserInteractionController extends Controller
{
   
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $userInteraction = UserInteraction::where('user_id', $request->input('user_id'))->first();
        if (!$userInteraction) {
            $userInteraction = new UserInteraction;
            $userInteraction->user_id =  $request->input('user_id');
            $userInteraction->interactions = $request->input('component_id');
        }else{
            $newValue = $request->input('component_id');
            $oldValue= $userInteraction->interactions;
            $Iarray = explode(",", $oldValue);
            $updateInteraction = $Iarray ? (in_array($newValue, $Iarray) ? $oldValue : $oldValue. ',' .$newValue) : $newValue;
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
    public function singleUserRecommendation($id){
        if (!is_numeric($id)) {
            return response()->json(['message' => 'Invalid user ID']);
        }
        
        $user_id = intval($id);
        $interaction  = UserInteraction::where('user_id', $user_id)->value('interactions');
        if (empty($interaction)) {
            return response()->json(['message' => 'No previous interactions found for this user']);
        }
          // extract component IDs from interaction
        $componentIds = explode(',', $interaction);
        $componentIds = array_map('intval', $componentIds);
        $component = Component::all();
        
        try {
            $args = ['id'=>$componentIds, 'component'=>$component];
            $process = new Process(['ls', '-lsa']);
            $process->run();

            // executes after the command finishes
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            echo $process->getOutput();
     

        } catch (\Throwable $th) {
           return response()->json(['message'=>'da'.$th]);
        }



        return response()->json([
            'status'=> 200,
            'message'=>'fd'
        ]);
    }

}
