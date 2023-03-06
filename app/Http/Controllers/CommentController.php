<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function index($id)
    {
        $comments = Comment::with('user')->where('component_id', $id)->get();
        return response()->json($comments);
    }

    public function store(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'body' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $comment = new Comment();
        $comment->body = $request->body;
        $comment->id = $id;
        $comment->user_id = $request->user()->id;
        $comment->save();

        return response()->json(['comment' => $comment]);
    }
}
