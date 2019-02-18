@extends('layout.layout')
@section('title')

    Add grade
@endsection
@section('container')
    Student name: {{$student->student_name}}
    <form action="{{url('student/add/grade')}}" method="post">
        @csrf
        @method('post')
        <label>
            Choose grade
            <select name="grade">
                @foreach($grades as $grade)
                    <option value="{{$grade->grade_id}}">{{$grade->grade_name}}</option>
                @endforeach
            </select>
        </label>
        <br>
        <label>
            Choose subject
            <select>
                @foreach($subjects as $subject)
                    <option value="{{$subject->subject_id}}">{{$subject->subject}}</option>
                @endforeach
            </select>
        </label>
        <input type="submit"/>
    </form>
@endsection