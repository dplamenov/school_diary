@extends('layout.layout')
@section('title', 'Parent')
@section('container')
    <a href="{{url('logout')}}">Log out</a>
    <p>Your name is {{$parent->parent_name}}</p>
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


@endsection