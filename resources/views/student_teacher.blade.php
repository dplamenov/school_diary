@extends('layout.layout')
@section('title')
    Student: {{$student->student_name}}
@endsection
@section('container')
    Student name: {{$student->student_name}}
    <a href="{{url('student/add/note/' . $student->student_id)}}">Add note</a>
    <a href="{{url('student/add/grade/' . $student->student_id)}}">Add grade</a>
    <a href="{{url('')}}">Go back</a>
@endsection