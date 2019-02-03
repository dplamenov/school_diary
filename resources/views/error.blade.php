@extends('layout.layout')
@section('title', 'Error')
@section('container')
    <p>{{$type_error}}, go back to <a href="{{url('/')}}">home page</a></p>
@endsection
