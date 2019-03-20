@extends('layout.layout')
@section('title')
    Edit School info
@endsection
@section('container')
    <form method="post" action="{{url('director/edit')}}">
        <label>
            {{$config->_key}}
            <input type="text" name="value" value="{{$config->value}}"/>
        </label>
    </form>
@endsection