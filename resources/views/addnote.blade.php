@extends('layout.layout')
@section('title')
    Add note
@endsection
@section('container')
    <p>Student name: {{$student->student_name}}</p>
    <form method="post" action="{{url('student/add/note')}}">
        @csrf
        @method('post')
        <label>
            Note Content
            <textarea name="content">

            </textarea>
        </label>
        <input type="submit"/>
    </form>
@endsection