@extends('layout.layout')
@section('title')
    Student: {{$student->student_name}}
@endsection
@section('container')
    Student name: {{$student->student_name}}
    <a href="">Add note</a>
    <a href="">Add grade</a>
    <a href="{{url('')}}">Go back</a>
@endsection