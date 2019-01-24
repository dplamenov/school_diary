@extends('layout.layout')
@section('title', 'Student')
@section('container')
    <p>Hello, {{explode(' ',$name)[1]}}</p>
    <p>Your class is (class)</p>
@endsection