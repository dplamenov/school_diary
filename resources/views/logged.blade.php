@extends('layout.layout')
@section('title', 'Error')
@section('container')
    <p>Logged</p>
    <a href="{{url('/logout')}}">Log out</a>
    @foreach($user_data as $user)
        <p>{{$user}}</p>
    @endforeach
@endsection