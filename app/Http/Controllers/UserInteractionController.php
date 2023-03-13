<?php

namespace App\Http\Controllers\API;

use App\Models\UserInteraction;
use App\Http\Requests\StoreUserInteractionRequest;
use App\Http\Requests\UpdateUserInteractionRequest;

class UserInteractionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserInteractionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserInteractionRequest $request)
    {
        $userInteraction = UserInteraction::where('user_id', Auth::id())->first();
        if (!$userInteraction) {
            $userInteraction = new UserInteraction;
            $userInteraction->user_id = Auth::id();
            $userInteraction->interactions = [];
        }
        $userInteraction->interactions[] = $request->input('component_id');
        $userInteraction->save();
        
        return response()-> json([
            'status'=> 200,
            'message'=>'category added successfully'
        ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserInteraction  $userInteraction
     * @return \Illuminate\Http\Response
     */
    public function show(UserInteraction $userInteraction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserInteraction  $userInteraction
     * @return \Illuminate\Http\Response
     */
    public function edit(UserInteraction $userInteraction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserInteractionRequest  $request
     * @param  \App\Models\UserInteraction  $userInteraction
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserInteractionRequest $request, UserInteraction $userInteraction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserInteraction  $userInteraction
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserInteraction $userInteraction)
    {
        //
    }
}
