<?php

namespace App\Http\Controllers;
use App\Catrgory;
use App\Post;
use Illuminate\Http\Request;

class Category extends Controller
{
    public function getPostsByCategory($id){
        // $user_id = auth()->user()->id;
        // $user = User::findOrFail($user_id);
        // $sortedPost = $user->posts()->orderBy('created_at','desc')->get();
        // return view('home')->with('posts', $sortedPost);

        // $cat_id = category()->id;
        $cat = Catrgory::findOrFail($id);
        $sortedPost = $cat->posts()->orderBy('created_at','desc')->get();
        return view('category.show')->with('cats', $sortedPost);
    }

}
