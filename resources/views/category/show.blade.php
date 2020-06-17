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
          <h2 class="mb-4">Related Posts</h2>
        </div>
      </div>
      <div class="row blog-entries">
        <div class="col-md-12 col-lg-8 main-content">
          <div class="row">
            @forelse($sortedPost as $sorted)
            <div class="post-entry-horzontal">
                <a  href="/post/{{ $sorted->id }}">
                  @if(!is_null($sorted->image))
                    <div class="image element-animate"  data-animate-effect="fadeIn" style="background-image: url(/storage/images/{{$sorted->image}});"></div>
                  @else
                    <div class="image element-animate"  data-animate-effect="fadeIn" style="background-image: url(/storage/images/resized/post/default_post_resized.jpg);"></div>
                  @endif
                  <span class="text">
                    <div class="post-meta">
                      <span class="category">{{$sorted->category->category}}</span>
                      <span class="mr-2">{{$sorted->created_at->diffForHumans() }}</span> &bullet;
                      <span class="ml-2"><span class="fa fa-comments"></span>  {{ $comments->where('post_id','=',$sorted->id)->count() }}</span>
                    </div>
                    <h2>{{$sorted->title}}</h2>
                  </span>
                </a>
              </div>
            @empty
            No Related Posts Found
            @endforelse
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
              <nav aria-label="Page navigation" class="text-center"> 
                <li class="page-item">{{$sortedPost->links()}}</li>
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
                    <img src="/storage/images/{{$latestPost->image}}" alt="Image placeholder" class="mr-4">
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
@endsection