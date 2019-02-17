@extends('layout.layout')
@section('title', 'Parent')
@section('container')
    <a href="{{url('logout')}}">Log out</a>
    <p>You`re parent on student: {{$student->student_name}}</p>
@endsection