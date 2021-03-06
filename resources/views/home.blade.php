@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Your Recent Posts</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                   
                    <!-- Blog Post -->
                    @forelse($posts as $post)
                
                    <div class="card mb-4">
                        @if(!is_null($post->image))
                        <img src="/storage/images/{{$post->image}}" alt="Image placeholder"> 
                        @else 
                        <img src="/storage/images/default_post.jpg" alt="Image placeholders"> 
                        @endif
                    {{-- <img class="card-img-top" src="/storage/images/{{$post->image}}" alt="Card image cap"> --}}
                    <div class="card-body">
                        <h2 class="card-title">{{ $post->title }}</h2>
                        <p class="card-text">{!! $post->body !!}</p>
                        <a  href="post/{{ $post->id }}" class="btn btn-primary">Read More →</a>
                    </div>
                    <div class="card-footer text-muted">
                        Posted {{$post->created_at->diffForHumans() }} by
                        <a href="#">{{ $post->user->name }}</a>
                    </div>
                    </div>

                    @empty
                        <p>You have no posts yet.</p>
                        <a href="/post/create">Create New Post</a>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
