<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Catrgory;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // to not allow guest to view posts
    // public function __construct()
    // {
	//     $this->middleware('auth'); 
    // }
    public function index()
    {
        // for public posts
        $posts = Post::orderBy('created_at','desc')->paginate(2);
        $cats = Catrgory::all();
        return view('posts.index', compact('posts','cats'));
        // $user_id = auth()->user()->id;
        // $user = User::findOrFail($user_id);
        
        // return view('posts.index')->with('posts', $user->posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cats = Catrgory::all();
        return view('posts.create',compact('cats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'category' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
          
        $imageName = time().'.'.$request->image->extension();  
   
        $path = $request->file('image')->storeAs('public/images',$imageName);
        $post = new Post([
            'title' => $request->get('title'),
            'body'  => $request->get('body'),
            'cat_id' => $request->get('category'),
            'image' => $imageName
            ]);
        $post->user_id = auth()->user()->id;
        $post->save();
        return redirect('/post');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        $cats = Catrgory::all();
        return view('posts.show', compact('post','cats'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageName = time().'.'.$request->image->extension();  
   
        $path = $request->file('image')->storeAs('public/images',$imageName);
        $post = Post::find($id);
        $post->title =  $request->get('title');
        $post->body =  $request->get('body');
        $post->image = $imageName;
        $post->save();
        return redirect('/post');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        // return redirect('/post');
    }
}
