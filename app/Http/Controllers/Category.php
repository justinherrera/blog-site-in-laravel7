<?php

namespace App\Http\Controllers;
use App\Catrgory;
use App\Post;
use App\User;
use App\Like;
use App\Dislike;
use App\Comments;
use Auth;
use Illuminate\Http\Request;

class Category extends Controller
{
    public function getPostsByCategory($id){
        // $user_id = auth()->user()->id;
        // $user = User::findOrFail($user_id);
        // $sortedPost = $user->posts()->orderBy('created_at','desc')->get();
        // return view('home')->with('posts', $sortedPost);

        // $cat_id = category()->id;
        // $search = $request->get('search');
        // $user = User::where('name','like',"%$search%")->first();
        $latestPosts = Post::orderBy('created_at','desc')->take(3)->get();
        $comments = Comments::all();
        //dd($user); find out on how to change the index layout when searching name result
        // $posts = Post::where('title','like',"%$search%")
        //             ->orWhere('body','like',"%$search%")
        //             ->paginate(10);
        $like = Like::all();
        $dislike = Dislike::all();
        $cats = Catrgory::all();
        $cat = Catrgory::findOrFail($id);
        $sortedPost = $cat->posts()->orderBy('created_at','desc')->paginate(8);
        return view('category.show',compact('sortedPost','posts','cats','like','dislike','latestPosts','comments'));
    }

}
