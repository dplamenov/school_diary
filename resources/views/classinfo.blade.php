@extends('layout.layout')
@section('title', 'Class info')
@section('container')
    <a href="{{url('/')}}">Go back</a>
    <p>Class: {{$class_name}}</p>

    <p>Students:</p>
    <button type="button" class="btn btn-danger">Danger</button>
    <table>

        @foreach($students as $student)
            <tr>
                <td>{{$student->student_name}}</td>
                <td>{{number_format($student->average_grade, 2)}}</td>
                <td>
                    <button type="button" class="btn btn-danger">
                        <a style="text-decoration: none;color: red" href="{{url('director/delete/student/' . $student->student_id)}}">Delete</a>
                    </button>
                </td>
                <td>
                    <a href="{{url('director/edit/student/' . $student->student_id)}}">Edit</a>
                </td>
                <td>
                    <a href="{{url('parent/register/' . $student->student_id)}}">Register parent</a>
                </td>
            </tr>
        @endforeach
    </table>
    <a href="{{url('director/add/student/' .  $class_id)}}">Add more students</a>
@endsection