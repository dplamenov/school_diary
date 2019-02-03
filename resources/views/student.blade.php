@extends('layout.layout')
@section('title', 'Student')
@section('container')

    <a href="{{url('logout')}}">Log out</a>
    <a href="{{url('parent/register/' . $user_data['id'])}}">Register parent</a>
    <p>Hello, {{explode(' ',$name)[1]}}</p>
    <p>Your class is {{$class}}</p>
@endsection