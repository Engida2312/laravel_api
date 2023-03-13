<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Component;

class DashboardController extends Controller{
    public function limitedComponents(Request $request){
       $components = Component::join('users', 'users.id', '=', 'component.user_id')
        ->orderBy('component.viewes', 'desc')
        ->get(['component.id','component.category_id','component.name','component.discription','component.viewes','component.likes','component.code_referance',
        'component.created_at','component.updated_at', 'users.firstname']);
        
        return $components;
    }

    public function dashboard(Request $request){
        $users = User::all();
        $components = Component::join('users', 'users.id', '=', 'component.user_id')
        ->get(['component.id','component.category_id','component.name','component.discription','component.viewes','component.likes','component.code_referance',
        'component.created_at','component.updated_at', 'users.firstname']);
        $userCount = User::count();
        $categoryCount = Category::count();
        $componentCount = Component::count();

        
        $data =[
            'users'=> $users,
            'components'=> $components,
            'userCount'=> $userCount,
            'categoryCount'=> $categoryCount,
            'componentCount'=> $componentCount,
        ];
       return $data;
    }
   
}
