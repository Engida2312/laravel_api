<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Component;

class ComponentController extends Controller
{
    public function getComponent(){
        $component = Component::all();
        return response()-> json([
            'status'=> 200,
            'component'=> $component
        ]);
    }
    public function add(Request $request){
        $component = new Component;
        $component->category_id = $request->input('category_id');
        $component->user_id = $request->input('user_id');
        $component->viewes = $request->input('viewes');
        $component->likes = $request->input('likes');
        $component->code_referance = $request->input('code_referance');
        $component->save();

        return response()-> json([
            'status'=> 200,
            'message'=>'component added successfully'
        ]);

    }
    public function singleComponent($id){
        $component = Component::find($id);
        return response()-> json([
            'status'=> 200,
            'message'=> $component
        ]);
    }
    public function updateComponent(Request $request, $id){
        $component = Component::find($id);
        $component->category_id = $request->input('category_id');
        $component->user_id = $request->input('user_id');
        $component->viewes = $request->input('viewes');
        $component->likes = $request->input('likes');
        $component->code_referance = $request->input('code_referance');
        $component->update();

        return response()-> json([
            'status'=> 200,
            'message'=>'component updated successfully'
        ]);

    }
    public function delete($id){
        $component = Component::find($id);
        $component->delete();
        return response()-> json([
            'status'=> 200,
            'message'=>'component delated successfully'
        ]);
    }
}
