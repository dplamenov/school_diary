@extends('layout.layout')
@section('title')
    {{$title}}
@endsection

@section('container')
    <p>Class name {{$class_name}}</p>
    <h2>Subjects</h2>
    @foreach($subjects as $subject)
        <p>{{$subject}}</p>
    @endforeach

    <h2>Students</h2>
    @foreach($students as $student)
        <p>{{$student}}</p>
    @endforeach
@endsection