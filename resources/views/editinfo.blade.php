@extends('layout.layout')
@section('title')
    Edit School info
@endsection
@section('container')
    <form method="post" action="{{url('director/edit')}}">
        @csrf
        @method('post')
        <label>
            {{$config->_key}}
            <input type="text" name="value" value="{{$config->value}}"/>
        </label>
        <input type="submit"/>
    </form>
@endsection