@extends('layout.layout')
@section('title', 'Director')
@section('container')
    <p>You`re login as director with full access</p>
    <a href="{{url('logout')}}">Log out</a>
    <a href="{{url('director/addteacher')}}">Add Teacher</a>
    <a href="{{url('director/addsubject')}}">Add subject</a>
    <a href="{{url('director/addclass')}}">Add class</a>
    <h2>List of teacher</h2>
    <table style="border: 1px">
        <tr>
            <th>Name</th>
            <th>Subject(s)</th>
        </tr>
        @foreach($teachers as $teacher)
            <tr>
                <td>{{$teacher['name']}}</td>
                @if(mb_strlen($teacher['subject']) > 0)
                    <td>{{$teacher['subject']}}</td>
                @else
                    <td>---</td>
                @endif
            </tr>
        @endforeach
    </table>

    <h2>List of subject</h2>
    <table style="border: 1px">
        <tr>
            <th>Subject name</th>
        </tr>
        @foreach($subjects as $subject)
            <tr>
                <td>{{$subject->subject_name}}</td>
            </tr>
        @endforeach
    </table>

    <h2>List of all classes</h2>
    <table style="border: 1px">
        <tr>
            <th>Class name</th>
            <th>Head teacher of class</th>
        </tr>
        @foreach($classes as $class)
            <tr>
                <td>{{$class->class_name}}</td>
                <td>{{$class->teacher_name}}</td>
            </tr>
        @endforeach
    </table>


@endsection