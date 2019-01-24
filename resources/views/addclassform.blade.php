@extends('layout.layout')
@section('title', 'Add teacher')
@section('script')
    <script src="{{\Illuminate\Support\Facades\URL::asset('js/addclass.js')}}"></script>
@endsection
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
        <label>Class name <input type="text" name="class_name" placeholder="Example: 10c"/></label><br>
        <label>Select head teacher
            <select name="teacher">
                @foreach($teachers as $key => $teacher)
                    <option value="{{$key}}">{{$teacher}}</option>
                @endforeach
            </select>
        </label>
        <br>
        <label>
            Select subjects

            <select name="subject[]" multiple="multiple" style="height: {{count($subjects) * 17.5}}px">
                @foreach($subjects as $key => $subject)
                    <option value="{{$key + 1}}">{{$subject->subject_name}}</option>
                @endforeach
            </select>
        </label>
        <br>
        <label>
            Add Students
            <button onclick="add()" type="button">+</button>
            <br>
            <div id="addstudents">
                <input type="text" name="name1" placeholder="Full Name"/>
            </div>
        </label>

        <input style="display: block; margin-top: 50px" type="submit"/>
    </form>
@endsection