@extends('layout.layout')
@section('title', 'Class info')
@section('container')
    <a href="{{url('/')}}">Go back</a>
    <p>Class: {{$class_name}}</p>

    <table>
        <tr>
            <th>Student</th>
            <th>Average Grade</th>
            <th colspan="4">Operation</th>
        </tr>
        @foreach($students as $student)
            <tr>
                <td>{{$student->student_name}}</td>
                <td>{{number_format($student->average_grade, 2)}}</td>
                <td>
                    <button type="button" style="background: white; border: red 1px;border-radius: 10px;width: 60px">
                        <a style="text-decoration: none;color: red" href="{{url('director/delete/student/' . $student->student_id)}}">Delete</a>
                    </button>
                </td>
                <td>
                    <button type="button" style="background: white; border: red 1px;border-radius: 10px;width: 60px">
                        <a style="text-decoration: none; color: #2a9055" href="{{url('director/edit/student/' . $student->student_id)}}">Edit</a>
                    </button>
                </td>
                <td>
                    <button type="button" style="background: white; border: red 1px;border-radius: 10px;width: 110px">
                        <a style="text-decoration: none;color: #1b4b72" href="{{url('parent/register/' . $student->student_id)}}">Register parent</a>
                    </button>

                </td>

                <td>
                    <a style="text-decoration: none;color: black" href="{{url('parent/register/' . $student->student_id)}}">Info</a>
                </td>
            </tr>
        @endforeach
    </table>
    <a href="{{url('director/add/student/' .  $class_id)}}">Add more students</a>
@endsection