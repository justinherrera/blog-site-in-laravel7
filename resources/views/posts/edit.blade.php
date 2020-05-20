@extends('layouts.app')

@section('content')
<form action="{{ route('post.update',$post->id) }}" method="post">
    @method('PATCH')
    @csrf
    <input type="text" name="title" placeholder="Title" value="{{old('title', $post->title)}}"> 
    <textarea name="body" cols="30" rows="10">{{old('body', $post->body)}}</textarea>
    <input type="submit">
</form>

@endsection