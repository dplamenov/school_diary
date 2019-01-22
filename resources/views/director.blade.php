@extends('layout.layout')
@section('title', 'Teacher')
@section('container')
    <p>You`re login as director with full access</p>
    <a href="{{url('logout')}}">Log out</a>
    <a href="{{url('director/addteacher')}}">Add Teacher</a>
@endsection