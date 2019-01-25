@extends('layout.layout')
@section('title')
    {{$title}}
@endsection

@section('container')
    @foreach($subjects as $subject)
        <p>{{$subject}}</p>
    @endforeach
@endsection