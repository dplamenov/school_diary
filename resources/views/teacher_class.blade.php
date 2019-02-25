@extends('layout.layout')
@section('title')
    {{$title}}
@endsection

@section('container')
    <p>Class name {{$class_name}}</p>
    <h2>Subjects</h2>
    <a href="{{url()}}">Go back</a>
    @foreach($subjects as $subject)
        <p>{{$subject}}</p>
    @endforeach

    <h2>Students</h2>
    @foreach($students as $student)
        <p><a href="{{url('student/' . $student->student_id)}}">{{$student->student_name}}</a></p>
    @endforeach
@endsection