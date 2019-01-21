@extends('layout.layout')
@section('title', 'Logged')
@section('container')

    <p>Hello, {{$user_data['username']}}</p>
    <p>Logged</p>
    <a href="{{url('/logout')}}">Log out</a>

@endsection