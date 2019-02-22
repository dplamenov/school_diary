@extends('layout.layout')
@section('title')
    Student: {{$student->student_name}}
@endsection
@section('container')
    Student name: {{$student->student_name}}
    <a href="{{url('student/add/note/' . $student->student_id)}}">Add note</a>
    <a href="{{url('student/add/grade/' . $student->student_id)}}">Add grade</a>
    <a href="{{url('')}}">Go back</a>
    <div>
        <h1>All grades</h1>
        @if(count($grades) > 0)

        @else
            <p>No grades.</p>
        @endif
        <table>

        </table>
    </div>


@endsection