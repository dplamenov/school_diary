@extends('layout.layout')
@section('title')
    Add grade
@endsection
@section('container')


    <h2>Add grade</h2>
    @if ($errors->any())
        @foreach($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach
    @endif
    <form action="{{url('director/grade')}}" method="post">
        @method('post')
        @csrf
        <label>
            Grade number
            <input type="text" name="grade_number"/>
            Grade name
            <input type="text" name="grade_name"/>
        </label>
        <input type="submit"/>
    </form>

    <div>
        @if(count($grades) > 0)
            <h2>All grade</h2>
            @foreach($grades as $grade)
                <p>{{$grade->grade_name}}</p>
            @endforeach
        @else
            <h3>No grades.</h3>
        @endif

    </div>

@endsection