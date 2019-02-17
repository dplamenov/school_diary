@extends('layout.layout')
@section('title')
    Add grade
@endsection
@section('container')
    <h2>Add grade</h2>
    @if ($errors->any())
        @foreach($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach
    @endif
    <form action="{{url('director/grade')}}" method="post">
        @method('post')
        @csrf
        <label>
            Grade name
            <input type="text" name="grade_name"/>
        </label>
        <input type="submit"/>
    </form>
@endsection