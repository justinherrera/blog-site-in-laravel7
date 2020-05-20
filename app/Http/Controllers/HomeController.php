<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $user = User::findOrFail($user_id);
        $sortedPost = $user->posts()->orderBy('created_at','desc')->get();
        return view('home')->with('posts', $sortedPost);
    }
    
    public function userProfile($id){
        $user = User::findOrFail($id);
        return view('profile')->with('posts',$user->posts);
    }
}
