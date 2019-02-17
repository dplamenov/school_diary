@extends('layout.layout')
@section('title', 'Parent')
@section('container')
    <a href="{{url('logout')}}">Log out</a>
    <p>Your name is {{$parent->parent_name}}</p>
    <p>You`re parent on student: {{$student->student_name}}</p>

@endsection