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
            Grade name
            <input type="text" name="grade_name"/>
            <br>
            Grade number
            <input type="text" name="grade_number"/>
        </label>
        <input type="submit"/>
    </form>

    <div>
        @if(count($grades) > 0)
            <h2>All grade</h2>
            <table>
                <tr>
                    <th>Grade</th>
                    <th>Grade as word</th>
                    <th>Delete</th>
                </tr>

                @foreach($grades as $grade)
                    <tr>
                        <td>{{$grade->grade_number}}</td>
                        <td>{{$grade->grade_name}}</td>
                        <td><a href="{{url('director/grade/delete/' . $grade->grade_id)}}">Delete</a></td>
                    </tr>
                @endforeach
            </table>
        @else
            <h3>No grades.</h3>
        @endif

    </div>
@endsection