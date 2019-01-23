@extends('layout.layout')
@section('title', 'Teacher')
@section('container')
    <a href="{{url('logout')}}">Log out</a>
    <p>Hello, {{explode(' ', $name)[1]}}</p>
    <div>
        <p>You teach the following classes:</p>
        @foreach($class as $item)
            <p><a href="#">{{$item->class_name}}</a></p>
        @endforeach
    </div>
@endsection