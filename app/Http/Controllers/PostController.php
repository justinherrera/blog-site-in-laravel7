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
use App\Category;
use Auth;
use Image;
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
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]); 
    }
    public function index()
    {
        // for public posts
        
        $posts = Post::orderBy('created_at','desc')->paginate(8);
        $sortedLikedPosts = Post::withCount('liked')->orderBy('liked_count','desc')->take(3)->get();
        $cats = Catrgory::all();
        $like = Like::all();
        $dislike = Dislike::all();
        $comments = Comments::all();
        $latestPosts = Post::orderBy('created_at','desc')->take(3)->get();
        $cat = Catrgory::findOrFail(1); // get food posts
        $foodPosts = $cat->posts()->orderBy('created_at','desc')->take(8)->get();
        return view('posts.index', compact('posts','cats','like','dislike','comments','latestPosts','lik','sortedLikedPosts'));
    }
    public function search(Request $request){
        $search = $request->get('search');
        $user = User::where('name','like',"%$search%")->first();
        $latestPosts = Post::orderBy('created_at','desc')->take(3)->get();
        $comments = Comments::all();
        //dd($user); find out on how to change the index layout when searching name result
        $posts = Post::where('title','like',"%$search%")
                    ->orWhere('body','like',"%$search%")
                    ->orderBy('created_at','desc')
                    ->paginate(10);
        $like = Like::all();
        $dislike = Dislike::all();
        $cats = Catrgory::all();
        return view('posts.search', compact('posts','cats','like','dislike','latestPosts','comments'));
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
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10000',
        ]);
        $post = new Post([
            'title' => $request->get('title'),
            'body'  => $request->get('body'),
            'cat_id' => $request->get('category')
            ]);
        $post->user_id = auth()->user()->id;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->fit(350,247)->save(public_path('/storage/images/resized/post/'.$filename));
            Image::make($image)->fit(500,500)->save(public_path('/storage/images/resized/show_post/'.$filename));
            Image::make($image)->save(public_path('/storage/images/'.$filename));
            $post->image = $filename;
        }
        $post->save();
        return response()->json(array('image' => $post->image, 'last_insert_id' => $post->id), 200);
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
        $relatedPosts = $cat->posts()->orderBy('created_at','desc')->take(3)->get();
        $cats = Catrgory::all();
        // $likeCtr = Like::where([
        //     'post_id' => $post->id
        //     ])->count();
        // $dislikeCtr = Dislike::where([
        //     'post_id' => $post->id
        //     ])->count();
        $like = Like::all();
        $dislike = Dislike::all();
        $comments = Comments::where('post_id', '=', $post->id)->get();
        $commentCount = $comments->count();
        return view('posts.show', compact('post','cats','like','dislike','comments','relatedPosts','commentCount'));
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
        $cats = Catrgory::all();
        if(auth()->user()->id !== $post->user_id){
            return redirect()->back();
        }
        // dd(old('category'));
        // //dd(old('title', $post->title));
        // foreach($cats as $cat){
        //     //dd($cat->category);
        //     //dd(old('category'));
        // }
        return view('posts.edit', compact('post','cats'));
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
            'category' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $post = Post::find($id);
        $post->title =  $request->get('title');
        $post->body =  $request->get('body');
        $post->cat_id = $request->get('category');
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->fit(350,247)->save(public_path('/storage/images/resized/post/'.$filename));
            Image::make($image)->fit(500,500)->save(public_path('/storage/images/resized/show_post/'.$filename));
            Image::make($image)->save(public_path('/storage/images/'.$filename));
            $post->image = $filename;
        }
        // dd($post);
        $post->save();
        return response()->json(array(
            'title' => $post->title,
            'body' => $post->body,
            'image' => $post->image,
            'category' => $post->category->category,
            'last_insert_id' => $post->id), 200);
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
        $like_user = Like::where([
            'user_id' => $user,
            'post_id' => $id,
        ])->first(); // like once
       
            if(empty($like_user->user_id)){ //
                $user = Auth::user()->id;
                $post_id = $id;
                $like = new Like([
                    'user_id' => $user,
                    'post_id' => $post_id,
                ]);
                $like->save();
                
            }
    }
    public function unlikePost(Request $request, $id){
        $post_id = $id;
        $like = Auth::user()->likes()->where('post_id', $id)->first();
        $like->delete();    
    }
    public function dislikePost(Request $request, $id){
        $user = Auth::user()->id;
        $dislike_user = Dislike::where([
            'user_id' => $user,
            'post_id' => $id,
        ])->first(); // like once
       
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
    public function undislikePost(Request $request, $id){
        $post_id = $id;
        $dislike = Auth::user()->dislikes()->where('post_id', $id)->first();
        $dislike->delete();  
    }
}
