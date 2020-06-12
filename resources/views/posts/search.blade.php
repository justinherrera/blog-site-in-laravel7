@extends('layouts.app')
@section('content')
   @if(!Auth::guest())
    <input type="hidden" class="user_id" id="{{Auth::user()->id}}"> <!-- to determine user id -->
  @endif

  <br>
  <section class="site-section py-sm">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h2 class="mb-4">Search Results</h2>
        </div>
      </div>
      <div class="row blog-entries">
        <div class="col-md-12 col-lg-8 main-content">
          <div class="row">
            @forelse($posts as $post)
            <div class="post-entry-horzontal">
                <a  href="/post/{{ $post->id }}">
                  <div class="image element-animate"  data-animate-effect="fadeIn" style="background-image: url(storage/images/{{$post->image}});"></div>
                  <span class="text">
                    <div class="post-meta">
                      <span class="category">{{$post->category->category}}</span>
                      <span class="mr-2">{{$post->created_at->diffForHumans() }}</span> &bullet;
                      <span class="ml-2"><span class="fa fa-comments"></span>  {{ $comments->where('post_id','=',$post->id)->count() }}</span>
                    </div>
                    <h2>{{$post->title}}</h2>
                  </span>
                </a>
              </div>
            @empty
            No Result Found
            @endforelse
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
              <nav aria-label="Page navigation" class="text-center"> 
                <li class="page-item">{{$posts->links()}}</li>
              </nav>
            </div>
          </div>
        </div>

        <!-- END main-content -->

        <div class="col-md-12 col-lg-4 sidebar">
          <div class="sidebar-box search-form-wrap">
            <form action="/search" class="search-form" method="get">
              <div class="form-group">
                <span class="icon fa fa-search"></span>
                <input type="text" name="search" class="form-control" id="s" placeholder="Type a keyword and hit enter">
              </div>
            </form>
          </div>
          <!-- END sidebar-box -->
          @if(!Auth::guest())
          <div class="sidebar-box">
            <div class="bio text-center">
              <img src="/storage/images/resized/user/{{Auth::user()->avatar}}" alt="Image Placeholder" class="img-fluid">
              <div class="bio-body">
                
                <h2>{{Auth::user()->name}}</h2>
                
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Exercitationem facilis sunt repellendus excepturi beatae porro debitis voluptate nulla quo veniam fuga sit molestias minus.

                  Liked Articles: {{Auth::user()->likes()->count()}}
                  Following:
                  Followers:
                </p>
                <p><a href="/post/create" class="btn btn-primary btn-sm">Create New Article</a></p>
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
            <h3 class="heading">Most Liked Posts</h3>
            <div class="post-entry-sidebar">
              <ul>
                @foreach($latestPosts as $latestPost)
                
                <li>
                    <a href="/post/{{$latestPost->id}}">
                    <img src="storage/images/{{$latestPost->image}}" alt="Image placeholder" class="mr-4">
                    <div class="text">
                      <h4>{{ Str::words($latestPost->title,2) }}</h4>
                      <div class="post-meta">
                        <span class="mr-2">{{$latestPost->created_at->diffForHumans() }}</span> &bullet;
                        <span class="ml-2"><span class="far fa-thumbs-up"></span>  {{ $like->where('post_id','=',$latestPost->id)->count() }}</span>
                      </div>
                    </div>
                  </a>
                </li>
                @endforeach
              </ul>
            </div>
          </div>
          <!-- END sidebar-box -->

          <div class="sidebar-box">
            <h3 class="heading">Categories</h3>
            <ul class="categories">
              @foreach ($cats as $cat) <!-- show list of categories -->
              <li><a href="/category/{{$cat->id}}">{{ $cat->category }}<span>({{$cat->posts->count()}})</span></a></li>
              @endforeach
            </ul>
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


  <footer class="site-footer">
    <div class="container">
      <div class="row mb-5">
        <div class="col-md-4">
          <h3>Paragraph</h3>
          <p>
            <img src="images/img_1.jpg" alt="Image placeholder" class="img-fluid">
          </p>

          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi, accusantium optio unde perferendis eum illum voluptatibus dolore tempora, consequatur minus asperiores temporibus reprehenderit.</p>
        </div>
        <div class="col-md-6 ml-auto">
          <div class="row">
            <div class="col-md-7">
              <h3>Latest Post</h3>
              <div class="post-entry-sidebar">
                <ul>
                  <li>
                    <a href="">
                      <img src="images/img_6.jpg" alt="Image placeholder" class="mr-4">
                      <div class="text">
                        <h4>There’s a Cool New Way for Men to Wear Socks and Sandals</h4>
                        <div class="post-meta">
                          <span class="mr-2">March 15, 2018 </span> &bullet;
                          <span class="ml-2"><span class="fa fa-comments"></span> 3</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="">
                      <img src="images/img_3.jpg" alt="Image placeholder" class="mr-4">
                      <div class="text">
                        <h4>There’s a Cool New Way for Men to Wear Socks and Sandals</h4>
                        <div class="post-meta">
                          <span class="mr-2">March 15, 2018 </span> &bullet;
                          <span class="ml-2"><span class="fa fa-comments"></span> 3</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="">
                      <img src="images/img_4.jpg" alt="Image placeholder" class="mr-4">
                      <div class="text">
                        <h4>There’s a Cool New Way for Men to Wear Socks and Sandals</h4>
                        <div class="post-meta">
                          <span class="mr-2">March 15, 2018 </span> &bullet;
                          <span class="ml-2"><span class="fa fa-comments"></span> 3</span>
                        </div>
                      </div>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-md-1"></div>
            
            <div class="col-md-4">

              <div class="mb-5">
                <h3>Quick Links</h3>
                <ul class="list-unstyled">
                  <li><a href="#">About Us</a></li>
                  <li><a href="#">Travel</a></li>
                  <li><a href="#">Adventure</a></li>
                  <li><a href="#">Courses</a></li>
                  <li><a href="#">Categories</a></li>
                </ul>
              </div>
              
              <div class="mb-5">
                <h3>Social</h3>
                <ul class="list-unstyled footer-social">
                  <li><a href="#"><span class="fa fa-twitter"></span> Twitter</a></li>
                  <li><a href="#"><span class="fa fa-facebook"></span> Facebook</a></li>
                  <li><a href="#"><span class="fa fa-instagram"></span> Instagram</a></li>
                  <li><a href="#"><span class="fa fa-vimeo"></span> Vimeo</a></li>
                  <li><a href="#"><span class="fa fa-youtube-play"></span> Youtube</a></li>
                  <li><a href="#"><span class="fa fa-snapchat"></span> Snapshot</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
        </div>
      </div>
    </div>
  </footer>

    {{-- <div class="row">

      <!-- Blog Entries Column -->
      <div class="col-md-8">

        <h1 class="my-4">Articles
          <small>Secondary Text</small>
        </h1>

        <a href="/post/create">Create new post</a>
        @forelse($posts as $post)
        <div class="card mb-4 post-section" id="post-{{$post->id}}">
          <img class="card-img-top" src="/storage/images/{{$post->image}}" alt="Card image cap">
          
          <div class="card-body">
            <h2 class="card-title">{{ $post->title }}</h2>
            <p class="card-text">{{ Str::words($post->body,10) }}</p>
            <a href="/post/{{ $post->id }}" class="btn btn-primary"><span class="fas fa-eye"></span> Read More →</a>
            @if(!Auth::guest())
            <form action="{{ route('post.likePost',$post->id) }}" method="GET" id="like">
              @csrf
              @method('DELETE')
            <input type="hidden" name="islike" value="{{ (Auth::user()->likes()->where('post_id', $post->id)->first()) ? (Auth::user()->likes()->where('post_id', $post->id)->first()->user_id == auth()->user()->id) ? 1 : 0 : 0}}"> 
          <a id="{{$post->id}}" class="btn btn-success like"><span id="checkLike">{{ (Auth::user()->likes()->where('post_id', $post->id)->first()) ? (Auth::user()->likes()->where('post_id', $post->id)->first()->user_id == auth()->user()->id) ? 'Liked' : 'Like' : 'Like'}}</span> <span id="countLike">({{$like->where('post_id','=',$post->id)->count()}})</span></a>
          </form>
          <form action="{{ route('post.dislikePost',$post->id) }}" method="GET">
            @csrf
            @method('DELETE')
            <input type="hidden" name="isdislike" value="{{ (Auth::user()->dislikes()->where('post_id', $post->id)->first()) ? (Auth::user()->dislikes()->where('post_id', $post->id)->first()->user_id == auth()->user()->id) ? 1 : 0 : 0}}"> 
          <a id="{{$post->id}}" class="btn btn-danger dislike"><span id="checkDislike">{{ (Auth::user()->dislikes()->where('post_id', $post->id)->first()) ? (Auth::user()->dislikes()->where('post_id', $post->id)->first()->user_id == auth()->user()->id) ? 'Disliked' : 'Dislike' : 'Dislike'}}</span> <span id="countDislike">({{$dislike->where('post_id','=',$post->id)->count()}})</span></a>
          </form>
            @endif
            <p>Comments: {{ $comments->where('post_id','=',$post->id)->count() }}</p>
          </div>
          <div class="card-footer text-muted">
            Posted {{$post->created_at->diffForHumans() }} by
            <a href="user/{{$post->user->id}}">{{ $post->user->name }}</a> |
            <a href="/category/{{  $post->category->id }}"> {{ $post->category->category }} </a>

          </div>
        </div>
        @empty
          <p>No posts available</p>
        @endforelse


        <ul class="pagination justify-content-center mb-4">
          <li class="page-item">
            {{ $posts->links() }}
          </li>
        </ul>

      </div>


      <div class="col-md-4">


        <div class="card my-4 ">
          <h5 class="card-header">Search Post</h5>
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

     
        <div class="card my-4">
          <h5 class="card-header">Categories</h5>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-12">    
                <ul class="list-group">
                  @foreach ($cats as $cat) 
                  <li class="list-group-item"><a href="/category/{{$cat->id}}">{{ $cat->category }}</a>({{$cat->posts->count()}})</li>
                  @endforeach
                </ul>   
              </div>
            </div>
          </div>
        </div>

      
        <div class="card my-4">
          <h5 class="card-header">Related Posts</h5>
          <div class="card-body">
            You can put anything you want inside of these side widgets. They are easy to use, and feature the new Bootstrap 4 card containers!
          </div>
        </div>

      </div>

    </div> --}}
    <!-- /.row -->
  {{-- <script type="text/javascript">
    console.log('user '+{!! auth()->user()->id !!})
  </script> --}}

