@extends('layouts.app')
@section('content')
<div class="container">
  @if(!Auth::guest())
  <input type="hidden" class="user_name" id="{{Auth::user()->name}}"> <!-- to determine user id -->
  @endif
  <section class="site-section py-lg" id="post-{{$post->id}}">
    <div class="container">
      
      <div class="row blog-entries">
        <div class="col-md-12 col-lg-8 main-content">
          <h1 class="mb-4 title">{{$post->title }}</h1>
          <div class="post-meta">
                      <a href="/category/{{  $post->category->id }}"class="category">{{ $post->category->category }}</a>
                      <span class="mr-2">{{$post->created_at->diffForHumans() }}</span> &bullet;
                      <span class="ml-2"><span class="fa fa-comments"></span><span class="totalComments">{{$commentCount}}</span></span>
                      @if(!Auth::guest())
                        @if(Auth::user()->id == $post->user_id)
                          <a style="cursor:pointer" class="edit editModal" data-backdrop="static">Edit</a>
                          <a style="cursor:pointer" class="delete">Delete</a>
                        @endif
                      @endif
                    </div>
          <div class="post-content-body">
            <br>
            <div class="row mb-5">
              @if(!is_null($post->image))
              <img class="post-image" src="/storage/images/resized/show_post/{{$post->image}}" alt="Image placeholder"> 
              @else 
              <img class="post-image" src="/storage/images/default_post.jpg" alt="Image placeholders"> 
              @endif
            </div>
            <div class="body">{!! $post->body !!}</div>
          </div>
          @if(!Auth::guest())
          <form action="{{ route('post.likePost',$post->id) }}" method="GET">
            @csrf
            @method('DELETE')
          <input type="hidden" name="islike" value="{{ (Auth::user()->likes()->where('post_id', $post->id)->first()) ? (Auth::user()->likes()->where('post_id', $post->id)->first()->user_id == auth()->user()->id) ? 1 : 0 : 0}}"> 
          <a type="submit" id="{{$post->id}}" class="like"><i class="fas fa-thumbs-up"></i><span id="checkLike">{{ (Auth::user()->likes()->where('post_id', $post->id)->first()) ? (Auth::user()->likes()->where('post_id', $post->id)->first()->user_id == auth()->user()->id) ? '  Liked' : '  Like' : '  Like'}}</span> <span id="countLike">({{$like->where('post_id','=',$post->id)->count()}})</span></a>
          </form>
          <form action="{{ route('post.dislikePost',$post->id) }}" method="GET">
            @csrf
            @method('DELETE')
            <input type="hidden" name="isdislike" value="{{ (Auth::user()->dislikes()->where('post_id', $post->id)->first()) ? (Auth::user()->dislikes()->where('post_id', $post->id)->first()->user_id == auth()->user()->id) ? 1 : 0 : 0}}"> 
          <a type="submit" id="{{$post->id}}" class="dislike"><i class="fas fa-thumbs-down"></i><span id="checkDislike">{{ (Auth::user()->dislikes()->where('post_id', $post->id)->first()) ? (Auth::user()->dislikes()->where('post_id', $post->id)->first()->user_id == auth()->user()->id) ? '  Disliked' : '  Dislike' : '  Dislike'}}</span> <span id="countDislike">({{$dislike->where('post_id','=',$post->id)->count()}})</span></a>
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
                  <img src="/storage/images/resized/user/{{$comment->user->avatar}}" class="avatar"alt="Image placeholder">
                </div>
                <div class="comment-body">
                  <h3>{{ $comment->user->name }}</h3>
                {{-- <div class="meta">{{ date('F d, Y', strtotime($comment->created_at)) }}</div> --}}
                <div class="meta">{{ $comment->created_at->diffForHumans() }}</div>
                
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
              <img src="/storage/images/resized/user/{{Auth::user()->avatar}}" alt="Image Placeholder" class="img-fluid">
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
              @if(strlen($relatedPost->title) > 10)
                <h3>{{ substr($relatedPost->title,0,10) }}...</h3>
              @else
              <h3>{{ $relatedPost->title }}</h3>
              @endif
            </div>
          </a>
        </div>
        @endforeach
      </div>
    </div>
  </section>
  <!-- Modal -->
  <div class="modal fade" id="editPost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add New Post</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
  <div class="container">
    <form method="post" enctype="multipart/form-data" id="updatePost" class="{{$post->id}}">
        @method('PATCH')
        @csrf
        <div class="form-group">
        <label for="exampleInputEmail1">Edit Title</label>
        <input type="text" class="form-control" name="title" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Title" value="{{old('title', $post->title)}}">
        <span style="color:red" class="title-error"></span>
        {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Edit Body</label>
            <textarea class="form-control" name="body" id="exampleFormControlTextarea1" rows="3">{{old('body', $post->body)}}</textarea>
            <span style="color:red" class="body-error"></span>
        </div>
        <div class="form-group">
          <select name="category" class="form-control category-select">
            <option selected disabled>Choose Category</option>
            @foreach ($cats as $cat)
          <option {{old('$cat_id',$post->cat_id) == $cat->id ? 'selected' : ''}} value="{{$cat->id}}" name="category" class="category-option edit-option">{{$cat->category}}</option> 
            @endforeach
          </select>
          <span style="color:red" class="category-error"></span>
        </div>
        <div class="form-group">
              <label for="image">Choose Image File</label>
              <input type="file" name="image" class="form-control-file">
            </div>
        </div>
          <span style="color:red" class="image-error"></span>
          <div class="modal-footer">
            {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary save">Post</button> --}}
          
        <button type="submit" class="btn btn-primary update">Update</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
    </form>
</div>

<script type="text/javascript">
  // WYSIWYG Editor Integration

  tinymce.init({
    selector: '#exampleFormControlTextarea1',
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