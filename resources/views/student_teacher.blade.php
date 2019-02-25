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
                            {{$grade->grade_name}} ({{$grade->grade_number}})
                        </td>
                        @if($grade->signed == 1)
                            <td>Signed</td>
                        @else
                            <td>Unsigned</td>
                        @endif
                    </tr>
                @endforeach
            </table>
        @else
            <p>No grades.</p>
        @endif

        <h1>All notes</h1>
        @if(count($notes) > 0)
            <table>
                @foreach($notes as $note)
                    <tr>
                        <td>
                            {{$note->note}}
                        </td>
                        <td>
                            {{$note->teacher}}
                        </td>
                        @if($note->signed == 1)
                            <td>Signed</td>
                        @else
                            <td>Unsigned</td>
                        @endif
                    </tr>
                @endforeach
            </table>
        @else
            <p>No notes.</p>
        @endif

    </div>


@endsection