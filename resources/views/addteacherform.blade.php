@extends('layout.layout')
@section('title', 'Add teacher')
@section('container')
    <h1>Add teacher</h1>
    @if(count($errors) > 0)
        @foreach($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach
    @endif
    @if(count($subjects) > 0)
        <form action="{{url('director/addteacher')}}" method="post">
            @method('post')
            @csrf
            <label>Full name<input type="text" name="fullname"/></label>
            <br><label>
                Subjects
                <select multiple="multiple" name="subjects[]">
                    @foreach($subjects as $key => $subject)
                        <option value="{{$key}}">{{$subject}}</option>
                    @endforeach
                </select>
            </label>
            <label>
                Email<input type="text" name="email"/>
            </label>
            <input type="submit"/>
        </form>

    @else
        <p>First add subject from <a href="{{url('director/addsubject')}}">here</a>.</p>
    @endif

@endsection

