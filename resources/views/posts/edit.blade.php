@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('post.update',$post->id) }}" method="post" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
        <div class="form-group">
        <label for="exampleInputEmail1">Edit Title</label>
        <input type="text" class="form-control" name="title" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Title" value="{{old('title', $post->title)}}">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Edit Body</label>
            <textarea class="form-control" name="body" id="exampleFormControlTextarea1" rows="3">{{old('body', $post->body)}}</textarea>
        </div>
        <div class="form-group">
            <div class="col-md-6">
              <input type="file" name="image" class="form-control">
            </div>
          </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="/post" class="btn btn-danger">Cancel</a>
    </form>
</div>
@endsection