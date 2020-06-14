@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('post.update',$post->id) }}" method="post" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
        <div class="form-group">
        <label for="exampleInputEmail1">Edit Title</label>
        <input type="text" class="form-control" name="title" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Title" value="{{old('title', $post->title)}}">
        {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Edit Body</label>
            <textarea class="form-control" name="body" id="exampleFormControlTextarea1" rows="3">{{old('body', $post->body)}}</textarea>
        </div>
        <div class="form-group">
          <select name="category" class="form-control category-select">
            <option selected disabled>Choose Category</option>
            @foreach ($cats as $cat)
          <option {{old('$cat_id',$post->cat_id) == $cat->id ? 'selected' : ''}} value="{{$cat->id}}" name="category" class="category-option edit-option">{{$cat->category}}</option> 
            @endforeach
          </select>
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