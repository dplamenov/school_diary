@extends('layout.layout')
@section('title', 'Add class')

@section('container')


    <form method="post" action="{{url('director/select/teacher')}}">
        @foreach($teachers as $key => $teacher)
            <p>{{$teachers[$key][0]->subject_name}}</p>
            <select name="teacher{{$teachers[$key][0]->subject_id}}">

                @foreach($teachers[$key] as $k=>$t)

                    <option>{{$teachers[$key][$k]->teacher_name}}</option>

                @endforeach
            </select>
        @endforeach
        <input type="submit"/>
    </form>


@endsection