@extends('layout.layout')
@section('title')
    Add note
@endsection
@section('container')

    <p>Student name: {{$student->student_name}}</p>
    @if ($errors->any())
        @foreach($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach
    @endif


    <form method="post" action="{{url('student/add/note')}}">
        @csrf
        @method('post')
        <label>
            Note Content
            <textarea name="content">

            </textarea>
        </label>
        <input type="hidden" name="student_id" value="{{$student->student_id}}"/>
        <input type="submit"/>
    </form>
@endsection