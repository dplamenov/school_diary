@extends('layout.layout')
@section('title', 'Add teacher')
@section('container')
    <h1>Add class</h1>
    @if(count($errors) > 0)
        @foreach($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach
    @endif
    <form action="{{url('director/addclass')}}" method="post">
        @method('post')
        @csrf
    </form>
@endsection