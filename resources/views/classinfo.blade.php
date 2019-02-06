@extends('layout.layout')
@section('title', 'Class info')
@section('container')
    <a href="{{url('/')}}">Go back</a>
    <p>Class: {{$class_name}}</p>
    <p>Students:</p>
    @foreach($students as $student)
        <p>{{$student->student_name}}</p>
    @endforeach
@endsection