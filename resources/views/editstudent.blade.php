@extends('layout.layout')
@section('title', 'Edit student')
@section('container')
    <p>You`re edit student {{$student->student_name}}.</p>
    @if ($errors->any())
        @foreach($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach

    @endif
    <form method="post" action="{{url('director/edit/student')}}">
        @csrf
        @method('post')
        <label>
            Student name
            <input type="text" name="name" value="{{$student->student_name}}"/>
        </label><br>
        <label>
            Student email
            <input type="text" name="email" value="{{$user->email}}"/>
        </label>
        <input type="submit" value="Edit"/>
    </form>
@endsection