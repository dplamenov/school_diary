@extends('layout.layout')
@section('title')
    Add grade
@endsection
@section('container')
    <h2>Add grade</h2>
    <form action="{{url('director/grade')}}" method="post">
        @method('post')
        @csrf
    </form>
@endsection