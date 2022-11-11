<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Component;

class DashboardController extends Controller{

    public function dashboard(Request $request){
        $users = User::all();
        $components = Component::all();
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
