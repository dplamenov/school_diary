@extends('layout.layout')
@section('title', 'Add class')
@section('script')

"
@section('container')
    <form method="post" action="{{url('director/select/teacher')}}">
        @method('post')
        @csrf
        <input type="hidden" hidden name="class" value="{{$class_id}}" >
        @foreach($teachers as $key => $teacher)
            <p>{{$teachers[$key][0]->subject_name}}</p>
            <select name="{{$teachers[$key][0]->subject_id}}teacher">

                @foreach($teachers[$key] as $k=>$t)
                    <option value="{{$teachers[$key][$k]->teacher_id}}">{{$teachers[$key][$k]->teacher_name}}</option>
                @endforeach
            </select>
        @endforeach
        <input type="submit"/>
    </form>


@endsection