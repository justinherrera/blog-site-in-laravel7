{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <a href="/post">Show Posts</a>
    <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <label for="exampleInputEmail1">Title</label>
          <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  name="title" placeholder="Enter Title">
          <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Body</label>
          <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="body"></textarea>
        </div>
        <div class="form-group">
          <select name="category" class="custom-select">
            <option selected disabled>Open this select menu</option>
            @foreach ($cats as $cat)
               <option value="{{$cat->id}}">{{$cat->category}}</option> 
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <div class="col-md-6">
            <input type="file" name="image" class="form-control">
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection --}}