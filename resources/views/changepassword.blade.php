@extends('layout.layout')
@section('title', 'Change password')
@section('container')
    <h1>Change password</h1>
    @if ($errors->any())
        @foreach($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach

    @endif
    <form action="{{url('changepassword')}}" method="post">
        @csrf
        @method('post')
        <label>
            Password
            <input type="text" name="password"/>
        </label>
        <br>
        <label>
            New Password
            <input type="text" name="new"/>
        </label>
        <br>
        <label>
            Repeat New Password
            <input type="text" name="repeat"/>
        </label>
        <input type="submit"/>
    </form>

@endsection