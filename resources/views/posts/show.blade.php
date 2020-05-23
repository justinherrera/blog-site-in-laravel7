@extends('layouts.app')
@include('layouts.nav')
@section('content')
<div class="container">

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
          <a href = "/like/{{$post->id}}" class="btn btn-success like">{{ (Auth::user()->likes()->where('post_id', $post->id)->first()) ? (Auth::user()->likes()->where('post_id', $post->id)->first()->user_id == auth()->user()->id) ? 'Liked' : 'Like' : 'Like'}} ({{$like->where('post_id','=',$post->id)->count()}})</a>
          <a href = "/dislike/{{$post->id}}" class="btn btn-danger dislike">{{ (Auth::user()->dislikes()->where('post_id', $post->id)->first()) ? (Auth::user()->dislikes()->where('post_id', $post->id)->first()->user_id == auth()->user()->id) ? 'Disliked' : 'Dislike' : 'Dislike'}} ({{$dislike->where('post_id','=',$post->id)->count()}})</a>
        @endif

        <hr>

        <!-- Comments Form -->
        <div class="card my-4">
          <h5 class="card-header">Leave a Comment:</h5>
          <div class="card-body">
            <form action="{{ route('comments.store') }}" method="post">
              @csrf
              <input type="hidden" name="post_id" value="{{$post->id}}">
              <div class="form-group">
                <textarea class="form-control" rows="3" name="body"></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>

        <!-- Single Comment -->
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
            You can put anything you want inside of these side widgets. They are easy to use, and feature the new Bootstrap 4 card containers!
          </div>
        </div>

      </div>

    </div>
    <!-- /.row -->

  </div>

@endsection