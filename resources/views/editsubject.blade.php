@extends('layout.layout')
@section('title', 'Edit subject')
@section('container')

    @if(count($errors) > 0)
        @foreach($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach
    @endif
    <form method="post" action="{{url('director/edit/subject')}}">
        @csrf
        @method('post')
        <input type="hidden" name="subject_id" value="{{$subject->subject_id}}"/>
        <label>
            Subject name
            <input type="text" name="subject" value="{{$subject->subject_name}}"/>
        </label>
        <input type="submit" value="Edit"/>
    </form>

@endsection