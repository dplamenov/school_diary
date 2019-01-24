@extends('layout.layout')
@section('title', 'Teacher')
@section('container')
    <a href="{{url('logout')}}">Log out</a>
    <p>Hello, {{explode(' ', $name)[1]}}</p>
    <div>
        @if(count($class) > 0 or count($classes) >0)
            <p>You teach the following classes:</p>
            @foreach($class as $item)
                <p><a href="#">{{$item->class_name}}</a></p>
            @endforeach
            @foreach($classes as $class)
                <p><a href="">{{$class->class_name}}</a></p>
            @endforeach
        @else
            <p>You don`t teach.</p>
        @endif

    </div>
@endsection