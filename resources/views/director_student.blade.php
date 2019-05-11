@extends('layout.layout')
@section('title', 'Student Info')
@section('container')
    <p>Student Name: {{$student['student_name']}}</p>
    <p>
        Class: {{$class}}
    </p>
@endsection