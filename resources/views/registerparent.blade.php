@extends('layout.layout')
@section('title', 'Register parent')
@section('container')
    @if ($errors->any())
        @foreach($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach
    @endif
    <form method="post" action="{{url('parent/register/' . $id)}}">
        @csrf
        @method('post')
        <label>Parent name <input type="text" name="name"/></label><br>
        <label>Username <input type="text" name="username"/></label><br>
        <label>Password <input type="password" name="password"/></label><br>
        <label>Repeat Password <input type="password" name="password_repeat"/></label><br>
        <input type="submit"/>
    </form>

@endsection