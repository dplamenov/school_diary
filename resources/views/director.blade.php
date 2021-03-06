@extends('layout.layout')
@section('title', 'Director')
@section('container')
    <p>You`re login as director with full access</p>
    <a href="{{url('logout')}}">Log out</a>
    <a href="{{url('director/addteacher')}}">Add Teacher</a>
    <a href="{{url('director/addsubject')}}">Add subject</a>
    <a href="{{url('director/addclass')}}">Add class</a>
    <a href="{{url('director/grade')}}">Choose grade system</a>
    <a href="{{url('director/schoolinfo')}}">School info</a>
    <h2>List of teacher</h2>
    <table style="border: 1px">
        <tr>
            <th>Name</th>
            <th>Subject(s)</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>

        @foreach($teachers as $k => $teacher)
            <tr>
                <td>{{$teacher['name']}}</td>
                @if(mb_strlen($teacher['subject']) > 0)
                    <td>{{$teacher['subject']}}</td>
                @endif
                <td><a href="{{url('teacher/edit/' . $k)}}">Edit</a></td>
                <td><a href="{{url('teacher/delete/' . $k)}}">Delete</a></td>
            </tr>
        @endforeach
    </table>

    <h2>List of subject</h2>
    <table style="border: 1px">
        <tr>
            <th>Subject name</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        @foreach($subjects as $subject)
            <tr>
                <td>{{$subject->subject_name}}</td>
                <td><a href="{{url("director/edit/subject/".$subject->subject_id)}}">Edit</a></td>
                <td><a href="{{url("subject/delete/".$subject->subject_id)}}">Delete</a></td>
            </tr>
        @endforeach
    </table>

    <h2>List of all classes</h2>
    @if(count($classes) > 0 )
        <table style="border: 1px">
            <tr>
                <th>Class name</th>
                <th>Head teacher of class</th>
                <th>Info</th>
                <th>Delete</th>
            </tr>
            @foreach($classes as $class)
                <tr>
                    <td>{{$class->class_name}}</td>
                    <td>{{$class->teacher_name}}</td>
                    <td><a href="{{url('director/class/' . $class->class_id)}}">Info</a></td>
                    <td><a href="{{url('director/delete/class/' . $class->class_id)}}">Delete</a></td>
                </tr>
            @endforeach
        </table>
    @else
        <p>No classes, add first from <a href="{{url('director/addclass')}}">here</a>.</p>
    @endif


@endsection