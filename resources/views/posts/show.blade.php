@extends('layouts.app')
@include('layouts.nav')
@section('content')
<div class="container">
  @if(!Auth::guest())
  <input type="hidden" class="user_name" id="{{Auth::user()->name}}"> <!-- to determine user id -->
  @endif
    <div class="row post-section" id="post-{{$post->id}}">

      <!-- Post Content Column -->
      <div class="col-lg-8">

        <!-- Title -->
        <h1 class="mt-4">{{$post->title }}</h1>

        <!-- Author -->
        <p class="lead">
          by
          <a href="/user/{{$post->user->id}}">{{ $post->user->name }}</a>
        </p>

        <hr>

        <!-- Date/Time -->
        <p>{{$post->created_at->diffForHumans() }}</p>
        @if(!Auth::guest())
          @if(Auth::user()->id == $post->user_id)
            <a href="/post/{{$post->id}}/edit" class="btn btn-success edit">Edit</a>
            <a  class="btn btn-danger delete">Delete</a>
          @endif
        @endif
        <hr>

        <!-- Preview Image -->
        <img class="img-fluid rounded"  src="/storage/images/{{$post->image}}" alt="">

        <hr>

        <!-- Post Content -->
        <p class="lead">{{$post->body }}</p>
        @if(!Auth::guest())
        <form action="{{ route('post.likePost',$post->id) }}" method="GET">
          @csrf
          @method('DELETE')
        <input type="hidden" name="islike" value="{{ (Auth::user()->likes()->where('post_id', $post->id)->first()) ? (Auth::user()->likes()->where('post_id', $post->id)->first()->user_id == auth()->user()->id) ? 1 : 0 : 0}}"> 
      <button type="submit" id="{{$post->id}}" class="btn btn-success like"><span id="checkLike">{{ (Auth::user()->likes()->where('post_id', $post->id)->first()) ? (Auth::user()->likes()->where('post_id', $post->id)->first()->user_id == auth()->user()->id) ? 'Liked' : 'Like' : 'Like'}}</span> <span id="countLike">({{$like->where('post_id','=',$post->id)->count()}})</span></button>
      </form>
      <form action="{{ route('post.dislikePost',$post->id) }}" method="GET">
        @csrf
        @method('DELETE')
        <input type="hidden" name="isdislike" value="{{ (Auth::user()->dislikes()->where('post_id', $post->id)->first()) ? (Auth::user()->dislikes()->where('post_id', $post->id)->first()->user_id == auth()->user()->id) ? 1 : 0 : 0}}"> 
      <button type="submit" id="{{$post->id}}" class="btn btn-danger dislike"><span id="checkDislike">{{ (Auth::user()->dislikes()->where('post_id', $post->id)->first()) ? (Auth::user()->dislikes()->where('post_id', $post->id)->first()->user_id == auth()->user()->id) ? 'Disliked' : 'Dislike' : 'Dislike'}}</span> <span id="countDislike">({{$dislike->where('post_id','=',$post->id)->count()}})</span></button>
      </form>
        @endif

        <hr>

        <!-- Comments Form -->
        @if(!Auth::guest())
          <div class="card my-4">
            <h5 class="card-header">Leave a Comment:</h5>
            <div class="card-body">
              <form action="{{ route('comments.store') }}" method="post" id="addComment">
                @csrf
                <input type="hidden" name="post_id" value="{{$post->id}}">
                <div class="form-group">
                  <textarea class="form-control body" rows="3" name="body"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
        @else 
          <div class="card my-4">
            <a href="/login">Login</a>
          </div>
        @endif
        <!-- Single Comment -->
        <div class="comment-section">
        @foreach($comments as $comment)
          <div class="media mb-4">
            <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
            <div class="media-body">
              <h5 class="mt-0">{{ $comment->user->name }}</h5>
              {{ $comment->body }}
            </div>
          </div>
        @endforeach
        </div>
      </div>

      <!-- Sidebar Widgets Column -->
      <div class="col-md-4">

        <!-- Search Widget -->
        <div class="card my-4">
          <h5 class="card-header">Search</h5>
          <div class="card-body">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search for...">
              <span class="input-group-btn">
                <button class="btn btn-secondary" type="button">Go!</button>
              </span>
            </div>
          </div>
        </div>

        <!-- Categories Widget -->
        <div class="card my-4">
          <h5 class="card-header">Categories</h5>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-12">    
                <ul class="list-group">
                  @foreach ($cats as $cat) <!-- show list of categories -->
                  <li class="list-group-item"><a href="/category/{{$cat->id}}">{{ $cat->category }}</a></li>
                  @endforeach
                </ul>   
              </div>
            </div>
          </div>
        </div>

        <!-- Side Widget -->
        <div class="card my-4">
          <h5 class="card-header">Related Posts</h5>
          <div class="card-body">
            <ul class="list-group">
              @foreach($relatedPosts as $relatedPost)
                <li class="list-group-item"><a href="/post/{{$relatedPost->id}}">{{ $relatedPost->title }}</a></li> 
              @endforeach
              </ul>
          </div>
        </div>

      </div>

    </div>
    <!-- /.row -->

  </div>

@endsection