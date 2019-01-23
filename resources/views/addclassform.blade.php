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
        <label>Class name <input type="text" name="class_name"/></label>
        <label>Select head teacher
            <select>
                @foreach($teachers as $key => $teacher)
                    <option value="{{$key}}">{{$teacher}}</option>
                @endforeach
            </select>
        </label>
    </form>
@endsection