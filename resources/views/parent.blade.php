@extends('layout.layout')
@section('title', 'Parent')
@section('container')
    @if($default_password == 1)
        <p style="color: red;font-weight: bold">Change password from <a style="font-weight: bold; color: red;text-decoration: none  " href="{{url('changepassword')}}">here</a>.</p>
    @endif
    <a href="{{url('logout')}}">Log out</a>
    <p>Hello, {{$parent->parent_name}}</p>
    <a href="{{url('changepassword')}}">Change password</a>
    <p>You`re parent on student: {{$student->student_name}} from {{$class->class_name}}</p>

    @if(count($unsigned_notes) > 0)
        <h1>Unsigned notes</h1>
        <table>
            <tr>
                <th>Note</th>
                <th>From Teacher</th>
                <th>Sign</th>
            </tr>
            @foreach($unsigned_notes as $note)
                <tr>
                    <td>{{$note->note}}</td>
                    <td>{{$note->teacher}}</td>
                    <td><a href="{{url('parent/notes/sign/' .  $note->note_id)}}">Sign</a></td>
                </tr>
            @endforeach
        </table>
    @endif
    @if(count($grades) > 0)
        <h2>Unsigned grade</h2>
        <table>

            @foreach($grades as $grade)
                <tr>

                    <td>{{$grade->grade_name}} ({{$grade->grade_number}})</td>
                    <td>{{$grade->subject_name}}</td>
                    <td><a href="{{url('parent/grades/sign/' . $grade->grade_id)}}">Sign</a></td>
                </tr>
            @endforeach
        </table>
    @endif


@endsection