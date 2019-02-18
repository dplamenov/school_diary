@extends('layout.layout')
@section('title')

    Add grade
@endsection
@section('container')
    Student name: {{$student->student_name}}
    @if ($errors->any())
        @foreach($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach
    @endif
    <form action="{{url('student/add/grade')}}" method="post">
        @csrf
        @method('post')
        <input type="hidden" name="student_id" value="{{$student->student_id}}"/>
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
            <select name="subject">
                @foreach($subjects as $subject)
                    <option value="{{$subject->subject_id}}">{{$subject->subject}}</option>
                @endforeach
            </select>
        </label>
        <input type="submit"/>
    </form>
@endsection