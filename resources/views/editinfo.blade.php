@extends('layout.layout')
@section('title')
    Edit School info
@endsection
@section('container')
    @if ($errors->any())
        @foreach($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach
    @endif
    <form method="post" action="{{url('director/edit')}}">
        @csrf
        @method('post')
        <input type="hidden" name="id" value="{{$config->id}}"/>
        <label>
            {{$config->_key}}
            <input type="text" name="value" value="{{$config->value}}"/>
        </label>
        <input type="submit"/>
    </form>
@endsection