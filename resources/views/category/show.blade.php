@extends('layouts.app')
@include('layouts.nav')
@section('content')
<div class="container">

        <div class="row">
    
          <!-- Blog Entries Column -->
          <div class="col-md-8">
                            <!-- Blog Post -->
                            @forelse($cats as $cat)
                
                            <div class="card mb-4">
                            <img class="card-img-top" src="/storage/images/{{$cat->image}}" alt="Card image cap">
                            <div class="card-body">
                                <h2 class="card-title">{{ $cat->title }}</h2>
                                <p class="card-text">{{ $cat->body }}</p>
                                <a  href="/post/{{ $cat->id }}" class="btn btn-primary">Read More →</a>
                            </div>
                            <div class="card-footer text-muted">
                                Posted {{$cat->created_at->diffForHumans() }} by
                                <a href="user/{{$cat->user->id}}">{{ $cat->user->name }}</a>
                            </div>
                            </div>
        
                            @empty
                                <p>You have no posts yet.</p>
                                <a href="/post/create">Create New Post</a>
                            @endforelse

          </div></div></div>
@endsection