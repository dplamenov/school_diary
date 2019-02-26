@extends('layout.layout')
@section('title', 'Class info')
@section('container')
    <a href="{{url('/')}}">Go back</a>
    <p>Class: {{$class_name}}</p>

    <p>Students:</p>

    <table>
        @foreach($students as $student)
            <tr>
                <td>{{$student->student_name}}</td>
                <td>{{number_format($student->average_grade, 2)}}</td>
            </tr>
        @endforeach
    </table>
    <a href="{{url('director/add/student')}}">Add more students</a>
@endsection