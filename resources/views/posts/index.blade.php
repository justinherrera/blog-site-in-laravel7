@extends('layouts.app')
@include('layouts.nav')
@section('content')
<div class="container">

    <div class="row">

      <!-- Blog Entries Column -->
      <div class="col-md-8">

        <h1 class="my-4">Articles
          <small>Secondary Text</small>
        </h1>

        <a href="/post/create">Create new post</a>
        <!-- Blog Post -->
        @foreach($posts as $post)
        {{-- {{dd($post->image)}} --}}
       {{-- {{ dd( asset('images/'.$post->image)) }} --}}
        <div class="card mb-4 post-section post-{{$post->id}}">
          {{-- <img class="card-img-top" src="http://placehold.it/750x300" alt="Card image cap"> --}}
          <img class="card-img-top" src="/storage/images/{{$post->image}}" alt="Card image cap">
          
          <div class="card-body">
            <h2 class="card-title">{{ $post->title }}</h2>
            <p class="card-text">{{ $post->body }}</p>
            <a  href="post/{{ $post->id }}" class="btn btn-primary">Read More →</a>
          </div>
          <div class="card-footer text-muted">
            Posted {{$post->created_at->diffForHumans() }} by
            <a href="user/{{$post->user->id}}">{{ $post->user->name }}</a>
          </div>
        </div>

        @endforeach

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
              <div class="col-lg-6">
                @foreach ($cats as $cat) <!-- show list of categories -->
                <ul class="list-unstyled mb-0">
                  <li>
                  <a href="/category/{{$cat->id}}">{{ $cat->category }}</</a>
                  </li>
                </ul>
                @endforeach
              </div>
              <div class="col-lg-6">
                <ul class="list-unstyled mb-0">
                  <li>
                    <a href="#">JavaScript</a>
                  </li>
                  <li>
                    <a href="#">CSS</a>
                  </li>
                  <li>
                    <a href="#">Tutorials</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <!-- Side Widget -->
        <div class="card my-4">
          <h5 class="card-header">Side Widget</h5>
          <div class="card-body">
            You can put anything you want inside of these side widgets. They are easy to use, and feature the new Bootstrap 4 card containers!
          </div>
        </div>

      </div>

    </div>
    <!-- /.row -->

  </div>
