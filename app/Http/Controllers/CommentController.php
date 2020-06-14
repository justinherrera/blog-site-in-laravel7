<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comments;
class CommentController extends Controller
{
    public function store(Request $request)
    {
    	$request->validate([
            'body'=>'required',
        ]);
        
        $comment = new Comments([
            'post_id' => $request->get('post_id'),
            'body'  => $request->get('body'),
            ]);
        $comment->user_id = auth()->user()->id;
        $comment->save();
        return response()->json(array('avatar' => auth()->user()->avatar), 200);
    }
}
