@extends('layout.layout')
@section('title', 'Teacher')
@section('container')
<a href="{{url('logout')}}">Log out</a>
{{$user_data['type']}}
@endsection