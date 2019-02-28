@extends('layout.layout')
@section('title')
    Edit teacher
@endsection
@section('container')
    <p>You will edit {{$teacher->teacher_name}} teacher.</p>
    <form method="post" action="{{url('teacher/edit')}}">
        @csrf
        @method('post')
        <input type="hidden" name="teacher_id" value="{{$teacher->teacher_id}}"/>
        <label>
            Teacher name
            <input type="text" name="name" value="{{$teacher->teacher_name}}"/>
        </label>
        <br>
        <label>
            Teacher email
            <input type="text" name="email" value="{{$user->email}}"/>
        </label>
        <input type="submit" value="Edit"/>
    </form>
@endsection