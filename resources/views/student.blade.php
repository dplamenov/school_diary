@extends('layout.layout')
@section('title', 'Student')
@section('container')
    Hello, {{explode(' ',$name)[1]}}
@endsection