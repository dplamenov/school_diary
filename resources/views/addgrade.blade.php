@extends('layout.layout')
@section('title')

    Add grade
@endsection
@section('container')
    Student name: {{$student->student_name}}
    <form action="{{url('student/add/grade')}}" method="post">
        @csrf
        @method('post')
        <select>
            @foreach($grades as $grade)
                <option value="{{$grade->grade_id}}">{{$grade->grade_name}}</option>
            @endforeach
        </select>

    </form>
@endsection