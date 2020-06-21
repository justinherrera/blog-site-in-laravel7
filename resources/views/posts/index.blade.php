@extends('layouts.app')
@section('content')
   @if(!Auth::guest())
    <input type="hidden" class="user_id" id="{{Auth::user()->id}}"> <!-- to determine user id -->
  @endif
  <section class="site-section pt-5">
    <div class="container">
      <div class="row">
        <div class="col-md-12">

          <div class="owl-carousel owl-theme home-slider">
            @foreach($latestPosts as $latestPost)
            <div>
              <a href="/post/{{ $latestPost->id }}" class="a-block d-flex align-items-center height-lg" style="background-image: url('storage/images/{{$latestPost->image}}'); ">
                <div class="text half-to-full">
                  <div class="post-meta">
                    <span class="category">{{$latestPost->category->category}}</span>
                    <span class="mr-2">{{date('d-m-Y', strtotime($latestPost->created_at))}} </span> &bullet;
                    <span class="ml-2"><span class="fa fa-comments"></span> {{ $comments->where('post_id','=',$latestPost->id)->count() }}</span>
                  </div>
                  <h3>{{ substr($latestPost->title,0,30) }}</p>
                </div>
              </a>
            </div>
            @endforeach
          </div>
          
        </div>
      </div>
      
      <div class="row">
        @foreach($latestPosts as $latestPost)
        <div class="col-md-6 col-lg-4">
          <a href="/post/{{ $latestPost->id }}" class="a-block d-flex align-items-center height-md" style="background-image: url('/storage/images/{{$latestPost->image}}'); ">
            <div class="text">
              <div class="post-meta">
                <span class="category">{{$latestPost->category->category}}</span>
                <span class="mr-2">{{$latestPost->created_at->diffForHumans() }} </span> &bullet;
                <span class="ml-2"><span class="fa fa-comments"></span> {{ $comments->where('post_id','=',$latestPost->id)->count() }}</span>
              </div>
              <h3>{{ substr($latestPost->title,0,10) }}</h3>
            </div>
          </a>
        </div>
        @endforeach
      </div>
    </div>
  </section> <!-- end of section-->

  <section class="site-section py-sm">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h2 class="mb-4">More Posts</h2>
        </div>
      </div>
      <div class="row blog-entries">
        <div class="col-md-12 col-lg-8 main-content">
          <div class="row postSection">
            @forelse($posts as $post)
            <div class="col-md-6">
              <a href="/post/{{ $post->id }}" class="blog-entry element-animate" data-animate-effect="fadeIn">
                @if(!is_null($post->image))
                <img src="/storage/images/resized/post/{{$post->image}}" alt="Image placeholder"> 
                @else 
                <img src="/storage/images/resized/post/default_post_resized.jpg" alt="Image placeholder"> 
                @endif
                <div class="blog-content-body">
                  <div class="post-meta">
                    <span class="category">{{$post->category->category}}</span>
                    <span class="mr-2">{{$post->created_at->diffForHumans() }}</span> &bullet;
                    <span class="ml-2"><span class="fa fa-comments"></span> {{ $comments->where('post_id','=',$post->id)->count() }}</span>
                  </div>
                  @if(strlen($post->title) >= 30)
                    <h2>{{ substr($post->title,0,30) }}...</h2>
                  @else
                    <h2>{{ $post->title }}</h2>
                  @endif
                  <small>Posted by: {{  substr($post->user->name,0,10) }}</small>
                </div>
              </a>
            </div>
            @empty
            <div class="col-md-6">
              <p>No Posts</p>
            </div>
            
            @endforelse
            
          </div>

          <div class="row">
            <div class="col-md-12 text-center">
              <nav aria-label="Page navigation" class="text-center"> 
                {{$posts->links()}}
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
              @if(!is_null(Auth::user()->avatar))
              <img src="storage/images/resized/user/{{Auth::user()->avatar}}" alt="Image Placeholder" class="img-fluid">
              @else
              <img src="storage/images/resized/user/default_avatar.png" alt="Image Placeholder" class="img-fluid">
              @endif
              <div class="bio-body">
                
                <h2>{{Auth::user()->name}}</h2>
                
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Exercitationem facilis sunt repellendus excepturi beatae porro debitis voluptate nulla quo veniam fuga sit molestias minus. <br>

                  Member Since: {{date('F d, Y', strtotime(Auth::user()->created_at))}} <br>
                  Liked Articles: {{Auth::user()->likes()->count()}}<br>
                  Following: <br>
                  Followers: <br>
                </p>
                <p><a class="btn btn-primary btn-sm openModal" data-backdrop="static">Create New Article</a></p>
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
                @foreach($sortedLikedPosts as $sortedLikedPost)
                
                <li>
                    <a href="/post/{{$sortedLikedPost->id}}">
                    @if(!is_null($sortedLikedPost->image))
                      <img src="/storage/images/resized/post/{{$sortedLikedPost->image}}" alt="Image placeholder" class="mr-4"> 
                    @else 
                      <img src="/storage/images/resized/post/default_post_resized.jpg" alt="Image placeholder" class="mr-4"> 
                    @endif    
                    {{-- <img src="storage/images/{{$sortedLikedPost->image}}" alt="Image placeholder" class="mr-4"> --}}
                    <div class="text">
                      <h4>{{ substr($sortedLikedPost->title,0,20) }}</h4>
                      <div class="post-meta">
                        <span class="mr-2">{{$sortedLikedPost->created_at->diffForHumans() }}</span> &bullet;
                        <span class="ml-2"><span class="far fa-thumbs-up"></span>  {{ $like->where('post_id','=',$sortedLikedPost->id)->count() }}</span>
                        {{-- <span>x{{$like->post->title}}</span> --}}
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

  <!-- Modal -->
  <div class="modal fade" id="createPost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add New Post</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" enctype="multipart/form-data" id="addPost">
            @csrf
            <div class="form-group">
              <label for="exampleInputEmail1">Title</label>
              <input type="text" class="form-control title" id="title" aria-describedby="emailHelp"  name="title" placeholder="Enter Title" autocomplete="off">
              <span style="color:red" class="title-error"></span>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Body</label>
              <textarea class="form-control body" id="body" rows="3" name="body"></textarea>
              <span style="color:red" class="body-error"></span>
            </div>
            <div class="form-group">
              <select name="category" class="form-control category-select">
                <option selected disabled>Choose Category</option>
                @foreach ($cats as $cat)
                   <option value="{{$cat->id}}" name="category" class="category-option">{{$cat->category}}</option> 
                @endforeach
              </select>
              <span style="color:red" class="category-error"></span>
            </div>
            <div class="form-group">
                <label for="image">Choose Image File</label>
                <input type="file" name="image" class="form-control-file" id="image">
                <span style="color:red" class="image-error"></span>
            </div>
            {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary save">Post</button>
        </div>
      </form>
      </div>
    </div>
  </div>
  
  <script type="text/javascript">
    // WYSIWYG Editor Integration

    tinymce.init({
      selector: 'textarea',
      height: 300,
      menubar: false,
      plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount'
      ],
      toolbar: 'undo redo | formatselect | ' +
      'bold italic backcolor | alignleft aligncenter ' +
      'alignright alignjustify | bullist numlist outdent indent | ' +
      'removeformat | help',
      content_css: '//www.tiny.cloud/css/codepen.min.css'
    });



  </script>
  @endsection
 
