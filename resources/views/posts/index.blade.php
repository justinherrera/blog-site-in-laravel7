@extends('layouts.app')
@include('layouts.nav')
@section('content')
<div class="container">
   @if(!Auth::guest())
    <input type="hidden" class="user_id" id="{{Auth::user()->id}}"> <!-- to determine user id -->
  @endif
    <div class="row">

      <!-- Blog Entries Column -->
      <div class="col-md-8">

        <h1 class="my-4">Articles
          <small>Secondary Text</small>
        </h1>

        <a href="/post/create">Create new post</a>
        <!-- Blog Post -->
        @forelse($posts as $post)
        {{-- {{dd($post->image)}} --}}
       {{-- {{ dd( asset('images/'.$post->image)) }} --}}
        <div class="card mb-4 post-section" id="post-{{$post->id}}">
          {{-- <img class="card-img-top" src="http://placehold.it/750x300" alt="Card image cap"> --}}
          <img class="card-img-top" src="/storage/images/{{$post->image}}" alt="Card image cap">
          
          <div class="card-body">
            <h2 class="card-title">{{ $post->title }}</h2>
            <p class="card-text">{{ Str::words($post->body,10) }}</p>
            <a href="/post/{{ $post->id }}" class="btn btn-primary"><span class="fas fa-eye"></span> Read More →</a>
            @if(!Auth::guest())
            <input type="hidden" name="islike" value="{{ (Auth::user()->likes()->where('post_id', $post->id)->first()) ? (Auth::user()->likes()->where('post_id', $post->id)->first()->user_id == auth()->user()->id) ? 1 : 0 : 0}}"> 
          <a id="{{$post->id}}" class="btn btn-success like"><span id="checkLike">{{ (Auth::user()->likes()->where('post_id', $post->id)->first()) ? (Auth::user()->likes()->where('post_id', $post->id)->first()->user_id == auth()->user()->id) ? 'Liked' : 'Like' : 'Like'}}</span> <span id="countLike">({{$like->where('post_id','=',$post->id)->count()}})</span></a>
              <a href = "/dislike/{{$post->id}}" class="btn btn-danger dislike"><span class="far fa-thumbs-down"></span>{{ (Auth::user()->dislikes()->where('post_id', $post->id)->first()) ? (Auth::user()->dislikes()->where('post_id', $post->id)->first()->user_id == auth()->user()->id) ? 'Disliked' : 'Dislike' : 'Dislike'}} ({{$dislike->where('post_id','=',$post->id)->count()}})</a>
            @endif
          </div>
          <div class="card-footer text-muted">
            Posted {{$post->created_at->diffForHumans() }} by
            <a href="user/{{$post->user->id}}">{{ $post->user->name }}</a>
          </div>
        </div>
        @empty
          <p>No posts available</p>
        @endforelse

        <!-- Pagination -->
        <ul class="pagination justify-content-center mb-4">
          <li class="page-item">
            {{ $posts->links() }}
          </li>
        </ul>

      </div>

      <!-- Sidebar Widgets Column -->
      <div class="col-md-4">

        <!-- Search Widget -->
        <div class="card my-4 ">
          <h5 class="card-header">Search</h5>
          <div class="card-body">
            <form action="/search" method="get">
            <div class="input-group">   
              <input type="text" name="search" class="form-control" placeholder="Search for...">
              <span class="input-group-btn">
                <button class="btn btn-secondary" type="submit">Go!</button>
              </span> 
            </div>
          </form>
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
  {{-- <script type="text/javascript">
    console.log('user '+{!! auth()->user()->id !!})
  </script> --}}
  </div>  
