@extends('layout.layout')
@section('title', 'Student Info')
@section('container')
    <p>Student Name: {{$student['student_name']}}</p>
    <p>
        Class: {{$class}}
    </p>
    <h2>Student grade</h2>
    @if(count($grades) >= 1)
        <table>
            <tr><th>Subject</th><th>Grade</th></tr>
            @foreach($grades as $grade)
                <tr><td>{{$grade->subject}}</td><td>{{$grade->grade_}}</td></tr>
            @endforeach
        </table>
    @else
        <p>No grade.</p>
    @endif
@endsection