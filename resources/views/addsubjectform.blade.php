@extends('layout.layout')
@section('title', 'Add teacher')
@section('container')
    <h1>Add subject</h1>
    @if(count($errors) > 0)
        @foreach($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach
    @endif
    <form action="{{url('director/addsubject')}}" method="post">
        @method('post')
        @csrf
        <label>Subject name<input type="text" name="subject"/></label>
        <input type="submit"/>
    </form>
@endsection