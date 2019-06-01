@extends('layout.layout')
@section('title', 'Student Info')
@section('container')
    <p>Student Name: {{$student['student_name']}}</p>
    <p>
        Class: {{$class}}
    </p>
    <h2>Student grade</h2>
    @if(count($grades) >= 1)
        @foreach($grades as $grade)

        @endforeach
    @else
        <p>No grade.</p>
    @endif
@endsection