@extends('layout.layout')
@section('title', 'Add student')
@section('container')
    <form method="post" action="{{url('director/add/student')}}">
        @csrf
        @method('post')
        <input type="hidden" name="class_id" value="{{$class_id}}"/>
        <label>
            Student name
            <input type="text" name="student_name"/>
        </label>
        <br>
        <label>
            Student email
            <input type="text" name="student_email"/>
        </label>
    </form>
@endsection