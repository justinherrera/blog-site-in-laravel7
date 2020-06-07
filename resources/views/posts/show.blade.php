@extends('layouts.app')
@include('layouts.nav')
@section('content')
<div class="container">
  @if(!Auth::guest())
  <input type="hidden" class="user_name" id="{{Auth::user()->name}}"> <!-- to determine user id -->
  @endif
  <section class="site-section py-lg" id="post-{{$post->id}}">
    <div class="container">
      
      <div class="row blog-entries">
        <div class="col-md-12 col-lg-8 main-content">
          <h1 class="mb-4">{{$post->title }}</h1>
          <div class="post-meta">
                      <a href="/category/{{  $post->category->id }}"class="category">{{ $post->category->category }}</a>
                      <span class="mr-2">{{$post->created_at->diffForHumans() }}</span> &bullet;
                      <span class="ml-2"><span class="fa fa-comments"></span>{{$commentCount}}</span>
                      @if(!Auth::guest())
                        @if(Auth::user()->id == $post->user_id)
                          <a href="/post/{{$post->id}}/edit" class="btn btn-success edit">Edit</a>
                          <a  class="btn btn-danger delete">Delete</a>
                        @endif
                      @endif
                    </div>
          <div class="post-content-body">
            <br>
            <div class="row mb-5">
              <div class="col-md-12 mb-4 element-animate">
                <img src="/storage/images/{{$post->image}}" alt="Image placeholder" class="img-fluid">
              </div>
            </div>
            <p>{{$post->body}}</p>
          </div>
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
          
          <div class="pt-5">
            <p>Categories: 
            @foreach ($cats as $cat) <!-- show list of categories -->
            <a href="/category/{{$cat->id}}">{{ $cat->category }}</a>
            @endforeach
            </p>
          </div>


          <div class="pt-5">
            <h3 class="mb-5"><span id="totalComment">{{$commentCount}}</span> Comments</h3>
            <ul class="comment-list">
              @foreach($comments as $comment)
              <li class="comment">
                <div class="vcard">
                  <img src="/storage/images/{{$comment->user->avatar}}" alt="Image placeholder">
                </div>
                <div class="comment-body">
                  <h3>{{ $comment->user->name }}</h3>
                <div class="meta">{{ date('F d, Y', strtotime($comment->created_at)) }}</div>
                  <p>{{ $comment->body }}</p>
                  {{-- <p><a href="#" class="reply">Reply</a></p> --}}
                </div>
              </li>
              @endforeach
            </ul>
            <!-- END comment-list -->
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
            @endif


          </div>

        </div>

        <!-- END main-content -->

        <div class="col-md-12 col-lg-4 sidebar">
          <div class="sidebar-box search-form-wrap">
            <form action="#" class="search-form">
              <div class="form-group">
                <span class="icon fa fa-search"></span>
                <input type="text" class="form-control" id="s" placeholder="Type a keyword and hit enter">
              </div>
            </form>
          </div>
          <!-- END sidebar-box -->
          @if(!Auth::guest())
          <div class="sidebar-box">
            <div class="bio text-center">
              <img src="/storage/images/{{Auth::user()->avatar}}" alt="Image Placeholder" class="img-fluid">
              <div class="bio-body">
                <h2>{{Auth::user()->name}}</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Exercitationem facilis sunt repellendus excepturi beatae porro debitis voluptate nulla quo veniam fuga sit molestias minus.</p>
                <p><a href="#" class="btn btn-primary btn-sm">Read my bio</a></p>
                <p class="social">
                  <a href="#" class="p-2"><span class="fa fa-facebook"></span></a>
                  <a href="#" class="p-2"><span class="fa fa-twitter"></span></a>
                  <a href="#" class="p-2"><span class="fa fa-instagram"></span></a>
                  <a href="#" class="p-2"><span class="fa fa-youtube-play"></span></a>
                </p>
              </div>
            </div>
          </div>
          @endif
          <!-- END sidebar-box -->  


          <div class="sidebar-box">
            <h3 class="heading">Categories</h3>
            @foreach ($cats as $cat) <!-- show list of categories -->
            <ul class="categories">
              <li><a href="/category/{{$cat->id}}">{{ $cat->category }}<span>({{$cat->posts->count()}})</span></a></li>
            </ul>
            @endforeach
          </div>
          <!-- END sidebar-box -->

          <div class="sidebar-box">
            <h3 class="heading">Tags</h3>
            <ul class="tags">
              <li><a href="#">Travel</a></li>
              <li><a href="#">Adventure</a></li>
              <li><a href="#">Food</a></li>
              <li><a href="#">Lifestyle</a></li>
              <li><a href="#">Business</a></li>
              <li><a href="#">Freelancing</a></li>
              <li><a href="#">Travel</a></li>
              <li><a href="#">Adventure</a></li>
              <li><a href="#">Food</a></li>
              <li><a href="#">Lifestyle</a></li>
              <li><a href="#">Business</a></li>
              <li><a href="#">Freelancing</a></li>
            </ul>
          </div>
        </div>
        <!-- END sidebar -->

      </div>
    </div>
  </section>

  <section class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2 class="mb-3 ">Related Post</h2>
        </div>
      </div>
      <div class="row">
        @foreach($relatedPosts as $relatedPost)
        <div class="col-md-6 col-lg-4">
          <a href="/post/{{$relatedPost->id}}" class="a-block d-flex align-items-center height-md" style="background-image: url('/storage/images/{{$relatedPost->image}}'); ">
            <div class="text">
              <div class="post-meta">
                <span class="category">{{$relatedPost->category->category}}</span>
                <span class="mr-2">{{date('d-m-Y', strtotime($relatedPost->created_at))}}</span> &bullet;
              <span class="ml-2"><span class="fa fa-comments"></span> {{$commentCount}}</span>
              </div>
              <h3>{{ $relatedPost->title }}</h3>
            </div>
          </a>
        </div>
        @endforeach
      </div>
    </div>


  </section>
{{-- 
    <div class="row post-section" id="post-{{$post->id}}">


      <div class="col-lg-8">


        <h1 class="mt-4">{{$post->title }}</h1>


        <p class="lead">
          by
          <a href="/user/{{$post->user->id}}">{{ $post->user->name }}</a> |
          <a href="/category/{{  $post->category->id }}"> {{ $post->category->category }} </a>
        </p>

        <hr>


        <p>{{$post->created_at->diffForHumans() }}</p>
        @if(!Auth::guest())
          @if(Auth::user()->id == $post->user_id)
            <a href="/post/{{$post->id}}/edit" class="btn btn-success edit">Edit</a>
            <a  class="btn btn-danger delete">Delete</a>
          @endif
        @endif
        <hr>


        <img class="img-fluid rounded"  src="/storage/images/{{$post->image}}" alt="">

        <hr>


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


      <div class="col-md-4">


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

        <div class="card my-4">
          <h5 class="card-header">Categories</h5>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-12">    
                <ul class="list-group">
                  @foreach ($cats as $cat) 
                  <li class="list-group-item"><a href="/category/{{$cat->id}}">{{ $cat->category }}</a></li>
                  @endforeach
                </ul>   
              </div>
            </div>
          </div>
        </div>

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


  </div> --}}

@endsection