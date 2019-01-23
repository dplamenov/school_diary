@extends('layout.layout')
@section('title', 'Teacher')
@section('container')
    <a href="{{url('logout')}}">Log out</a>
    <p>Hello, {{explode(' ', $name)[1]}}</p>
    <div>
        <p>You teach the following classes:</p>

    </div>
@endsection