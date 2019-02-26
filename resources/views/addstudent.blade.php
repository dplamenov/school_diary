@extends('layout.layout')
@section('title', 'Add student')
@section('container')
    <p>You will create student in {{$class_name}} class</p>
    @if(count($errors) > 0)
        @foreach($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach
    @endif
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
        <br>
        <input type="submit"/>
    </form>
@endsection