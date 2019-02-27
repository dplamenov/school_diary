@extends('layout.layout')
@section('title', 'Edit subject')
@section('container')

    <form method="post" action="{{url('director/edit/subject')}}">
        @csrf
        @method('post')
        <label>
            Subject name
            <input type="text" name="subject" value="{{$subject->subject_name}}"/>
        </label>
    </form>

@endsection