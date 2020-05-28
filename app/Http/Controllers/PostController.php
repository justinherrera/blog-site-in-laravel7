<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Post;
use App\User;
use App\Catrgory;
use App\Like;
use App\Dislike;
use App\Comments;
use Auth;
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
        $like = Like::all();
        $dislike = Dislike::all();
        $comments = Comments::all();
        //dd($like->where('user_id',Auth::user()->id)); // next task check if user alerady liked the post
        return view('posts.index', compact('posts','cats','like','dislike','comments'));
        // $user_id = auth()->user()->id;
        // $user = User::findOrFail($user_id);
        
        // return view('posts.index')->with('posts', $user->posts);
    }
    public function search(Request $request){
        $search = $request->get('search');
        $user = User::where('name','like',"%$search%")->first();
        //dd($user); find out on how to change the index layout when searching name result
        $posts = Post::where('title','like',"%$search%")
                    ->orWhere('body','like',"%$search%")
                    ->paginate(2);
        $like = Like::all();
        $dislike = Dislike::all();
        $cats = Catrgory::all();
        return view('posts.index', compact('posts','cats','like','dislike'));
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
        $cat = Catrgory::findOrFail($post->cat_id);
        $relatedPosts = $cat->posts()->orderBy('created_at','desc')->get();
        $cats = Catrgory::all();
        $likeCtr = Like::where([
            'post_id' => $post->id
            ])->count();
        $dislikeCtr = Dislike::where([
            'post_id' => $post->id
            ])->count();
        $like = Like::all();
        $dislike = Dislike::all();
        $comments = Comments::where('post_id', '=', $post->id)->get();
        return view('posts.show', compact('post','cats','likeCtr','dislikeCtr','like','dislike','comments','relatedPosts'));
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
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $post = Post::find($id);
        $post->title =  $request->get('title');
        $post->body =  $request->get('body');
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();  
            $path = $request->file('image')->storeAs('public/images',$imageName);
            $post->image = $imageName;
        }
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
    public function likePost(Request $request, $id){
       
        $user = Auth::user()->id;
        // $islike = 1;
        $like_user = Like::where([
            'user_id' => $user,
            'post_id' => $id,
        ])->first(); // like once
       
        if($request->get('islike') == 0){ // if user has not liked the post yet
            
            $islike = 1;
            if(empty($like_user->user_id)){ //
                $user = Auth::user()->id;
                $post_id = $id;
                $like = new Like([
                    'user_id' => $user,
                    'post_id' => $post_id,
                    'islike' => 1
                ]);
                $like->save();
                
            }
        }
        // else{
        //     $islike = 0;
        //     $post_id = $id;
        //     $like = Auth::user()->likes()->where('post_id', $id)->first();
        //     $like->delete();
        // }
    }
    public function unlikePost(Request $request, $id){
        $post_id = $id;
        $like = Auth::user()->likes()->where('post_id', $id)->first();
        $like->delete();    
    }
    public function dislikePost(Request $request, $id){
        $user = Auth::user()->id;
        // $islike = 1;
        $dislike_user = Dislike::where([
            'user_id' => $user,
            'post_id' => $id,
        ])->first(); // like once
       
        if($request->get('isdislike') == 0){
            $isdislike = 1;
            if(empty($dislike_user->user_id)){ //
                $user = Auth::user()->id;
                $post_id = $id;
                $dislike = new Dislike([
                    'user_id' => $user,
                    'post_id' => $post_id,
                ]);
                $dislike->save();
            }
        }
        // else{
        //     $dislike = 0;
        //     $post_id = $id;
        //     $dislike = Auth::user()->dislikes()->where('post_id', $id)->first();
        //     $dislike->delete();
        //     return redirect()->back();
            
        // }
    }
    public function undislikePost(Request $request, $id){
        $post_id = $id;
        $dislike = Auth::user()->dislikes()->where('post_id', $id)->first();
        $dislike->delete();  
    }
}
