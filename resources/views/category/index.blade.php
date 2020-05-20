@extends('layouts.app')

@section('content')
    @foreach ($cats as $cat)
        <h2>{{ $cat->category }}</h2>
    @endforeach
@endsection