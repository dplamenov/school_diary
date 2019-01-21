@extends('layout.layout')
@section('title', 'Login form')
@section('container')
    @if ($errors->any())
        @foreach($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach

    @endif

    <form method="post">
        @method('post')
        @csrf
        <label>Username<input type="text" name="username"/></label>
        <label>Password<input type="password" name="password"/></label>
        <label>

            <select name="type">
                @foreach($types_user as $key => $value)
                    <option value="{{$key}}">{{$value}}</option>
                @endforeach
            </select>

        </label>
        <input type="submit"/>
    </form>
@endsection
