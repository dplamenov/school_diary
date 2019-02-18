@extends('layout.layout')
@section('title')

    Add grade
@endsection
@section('container')
    Student name: {{$student->student_name}}
    <form action="{{url('student/add/grade')}}" method="post">
        @csrf
        @method('post')
    </form>
@endsection