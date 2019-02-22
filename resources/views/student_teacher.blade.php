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
            <table>
                @foreach($grades as $grade)
                    <tr>
                        <td>
                            {{$grade->subject_name}}
                        </td>
                        <td>
                            {{$grade->grade_name}}
                        </td>
                        @if($grade->signed == 1)
                            <td>Signed</td>
                        @else
                            <td>Un signed</td>
                        @endif
                    </tr>
                @endforeach
            </table>
        @else
            <p>No grades.</p>
        @endif

    </div>


@endsection